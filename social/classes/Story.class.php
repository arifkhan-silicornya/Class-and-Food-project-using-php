<?php

namespace miuan;

class Story {
	private $id;
	private $conn;
	private $timelineObj;
	private $recipientObj;
	public $data;
	public $template;
	public $view_all_comments = false;
	private $comment_mentions;
	private $escapeObj;
	private $profileId;

	private $allowed_reactions = array('like', 'love', 'haha', 'wow', 'sad', 'angry');

	function __construct()
	{
		global $conn;
		$this->conn = $conn;
		$this->escapeObj = new \miuan\Escape();
		return $this;
	}

	public function setConnection(\mysqli $conn)
	{
		$this->conn = $conn;
		return $this;
	}

	protected function getConnection()
	{
		return $this->conn;
	}

	public function getRows()
	{
		$query1 = $this->getConnection()->query("SELECT * FROM " . DB_POSTS . " WHERE id=" . $this->id . " AND timeline_id IN (SELECT id FROM " . DB_ACCOUNTS . " WHERE active=1) AND active=1");

		if ($query1->num_rows == 1)
		{
			$ghost = $query1->fetch_array(MYSQLI_ASSOC);
			$userObj = new \miuan\User($this->getConnection());
			$ghost['timeline'] = $userObj->getById($ghost['timeline_id']);
			unset($ghost['timeline_id']);

			$this->data = $ghost;
			$post = array();

			if (isLogged())
			{
				global $user;

				$postQuery = $this->getConnection()->query("SELECT * FROM " . DB_POSTS . " WHERE post_id=" . $this->data['id'] . " AND (timeline_id=" . $user['id'] . " OR timeline_id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . ")) AND shared=1 AND active=1");

				if ($postQuery->num_rows > 0)
				{
					$post = $postQuery->fetch_array(MYSQLI_ASSOC);
					$post['type'] = "share";
					$postUserObj = new \miuan\User($this->getConnection());
					$postUserObj->setId($post['timeline_id']);
					$post['timeline'] = $postUserObj->getRows();
					unset($post['timeline_id']);
				}
			}
			else
			{
				$postQuery = $this->getConnection()->query("SELECT * FROM " . DB_POSTS . " WHERE post_id=" . $this->data['id'] . " AND timeline_id=" . $this->profileId . " AND shared=1 AND active=1");

				if ($postQuery->num_rows > 0)
				{
					$post = $postQuery->fetch_array(MYSQLI_ASSOC);
					$post['type'] = "share";
					$postUserObj = new \miuan\User($this->getConnection());
					$postUserObj->setId($post['timeline_id']);
					$post['timeline'] = $postUserObj->getRows();
					unset($post['timeline_id']);
				}
			}

			/* Timeline Object */
			$this->timelineObj = $userObj;
			
			// Get Type
			$this->data['type'] = $this->getType();


			// See if it's reported
			$this->data['isReported'] = $this->isReported();


			// Get recipient, if available
			$this->data['recipient'] = $this->getRecipient();


			// Get activity text (sub-text)
	        $this->data['activity_text'] = $this->getActivity();


	        // Emoticons
	        $this->data['original_text'] = $this->data['text'];
	        $this->data['text'] = $this->escapeObj->getEmoticons($this->data['text']);
	        $this->data['text'] = $this->escapeObj->getLinks($this->data['text']);
	        $this->data['text'] = $this->escapeObj->getHashtags($this->data['text']);
	        $this->data['text'] = $this->escapeObj->getMentions($this->data['text']);


	        // Media, if available
			$this->data['media'] = $this->getMedia();


			// Location
	        $this->data['location'] = $this->getLocation();


	        // Via
	        $this->data['via'] = $this->getVia($post);


			// Admin Rights
	        $this->data['admin'] = $this->isAdmin();
	        

	        // Invoke addons
	        $this->data = \miuan\Addons::invoke(array('story_content_editor', 'array'), $this->data);


	        // Basic Template Data
	        $this->getBasicTemplateData();

	        // Caching
			/*$_SESSION['tempche']['story'][$this->id] = $this->data;
			$_SESSION['tempche']['story'][$this->id]['expire_time'] = time() + (60 * 5);*/

	        return $this->data;
		}
	}

	public function isReacted($r='', $timeline_id=0) {
	    global $user;

	    $timeline_id = (int) $timeline_id;

	    if ($timeline_id == 0) {
	        $timeline_id = $user['id'];
	    }

	    $query = $this->getConnection()->query("SELECT id,reaction FROM " . DB_POSTLIKES . " WHERE post_id=" . $this->data['id'] . " AND timeline_id=$timeline_id AND active=1");

	    if (empty($r))
	    {
	    	$query = $this->getConnection()->query("SELECT id,reaction FROM " . DB_POSTLIKES . " WHERE post_id=" . $this->data['id'] . " AND timeline_id=$timeline_id AND active=1");
	    }
	    else
	    {
	    	$r = $this->escapeObj->stringEscape($r);
	    	$query = $this->getConnection()->query("SELECT id,reaction FROM " . DB_POSTLIKES . " WHERE post_id=" . $this->data['id'] . " AND timeline_id=$timeline_id AND reaction='$r' AND active=1");
	    }
	    
	    if ($query->num_rows == 1)
	    {
	    	$fetch = $query->fetch_array(MYSQLI_ASSOC);
	        return $fetch['reaction'];
	    }
	}

	public function isShared($timeline_id=0) {
	    global $user;

	    $timeline_id = (int) $timeline_id;

	    if ($timeline_id == 0) {
	        $timeline_id = $user['id'];
	    }
	    
	    $query = $this->getConnection()->query("SELECT id FROM " . DB_POSTS . " WHERE post_id=" . $this->data['id'] . " AND timeline_id=$timeline_id AND shared=1 AND active=1");
	    
	    if ($query->num_rows == 1) {
	        return true;
	    }
	}

	public function isFollowed($timeline_id=0) {
	    global $user;

	    $timeline_id = (int) $timeline_id;

	    if ($timeline_id == 0) {
	        $timeline_id = $user['id'];
	    }
	    
	    $query = $this->getConnection()->query("SELECT id FROM " . DB_POSTFOLLOWS . " WHERE post_id=" . $this->data['id'] . " AND timeline_id=$timeline_id AND active=1");
	    
	    if ($query->num_rows == 1) {
	        return true;
	    }
	}

	public function isReported() {
	    if (! isLogged()) {
			return false;
		}
		
		global $user;
		$query = $this->getConnection()->query("SELECT id FROM " . DB_REPORTS . " WHERE reporter_id=" . $user['id'] . " AND post_id=" . $this->data['id'] . " AND type='story'");

		if ($query->num_rows == 1) {
			return true;
		}
	}

	public function isAdmin()
	{
		if (! isLogged())
		{
			return false;
		}

		$admin = false;
        
        if ($this->timelineObj->isAdmin())
        {
			$admin = true;
		}

		if (is_array($this->data['recipient']))
		{
			if ($this->recipientObj->isAdmin())
			{
				$admin = true;
			}
		}

        return $admin;
	}

	function numReactions($r='')
	{
		if (in_array($r, $this->allowed_reactions))
	    {
	    	$query = $this->getConnection()->query("SELECT COUNT(id) AS count FROM " . DB_POSTLIKES . " WHERE post_id=" . $this->data['id'] . " AND active=1 AND reaction='$r'");
	    }
	    else
	    {
	    	$query = $this->getConnection()->query("SELECT COUNT(id) AS count FROM " . DB_POSTLIKES . " WHERE post_id=" . $this->data['id'] . " AND active=1");
	    }

	    $fetch = $query->fetch_array(MYSQLI_ASSOC);
	    
	    return $fetch['count'];
	}

	function numComments()
	{
	    $query = $this->getConnection()->query("SELECT COUNT(id) AS count FROM " . DB_COMMENTS . " WHERE post_id=" . $this->data['id'] . " AND active=1");
	    $fetch = $query->fetch_array(MYSQLI_ASSOC);
	    
	    return $fetch['count'];
	}

	function numCommenters()
	{
	    $query = $this->getConnection()->query("SELECT DISTINCT timeline_id AS count FROM " . DB_COMMENTS . " WHERE post_id=" . $this->data['id'] . " AND active=1");
	    
	    return $query->num_rows;
	}

	function numShares()
	{
	    $query = $this->getConnection()->query("SELECT COUNT(id) AS count FROM " . DB_POSTS . " WHERE post_id=" . $this->data['id'] . " AND shared=1 AND active=1");
	    $fetch = $query->fetch_array(MYSQLI_ASSOC);
	    
	    return $fetch['count'];
	}

	function numFollowers()
	{
	    $query = $this->getConnection()->query("SELECT COUNT(id) AS count FROM " . DB_POSTFOLLOWS . " WHERE post_id=" . $this->data['id'] . " AND active=1");
	    $fetch = $query->fetch_array(MYSQLI_ASSOC);
	    
	    return $fetch['count'];
	}

	public function getType()
	{
		return "story";
	}

	public function getMedia()
	{
		$get = false;

		if ($this->data['media_id'] > 0)
		{
			$get = array();
			$get['type'] = 'photos';
			$mediaObj = new \miuan\Media();
			$media = $mediaObj->getById($this->data['media_id']);

			if ($media['type'] == "photo")
			{
				$get = $media;
				$get['type'] = 'photos';
				$get['each'][0]['url'] = SITE_URL . '/' . $get['each'][0]['url'] . '.' . $get['each'][0]['extension'];
				$get['each'][0]['post_id'] = $this->data['id'];
				$get['each'][0]['post_url'] = smoothLink('index.php?tab1=story&id=' . $this->data['id']);
			}
			elseif ($media['type'] == "album")
			{
				$get = $media;
				$get['type'] = 'photos';
				$get['each'] = array();

				if ($get['temp'] == 0)
				{
					for ($each_i = 0; $each_i < 6; $each_i++)
					{
						if (isset($media['each'][$each_i]) && is_array($media['each'][$each_i]))
						{
							$get['each'][$each_i] = $media['each'][$each_i];
							$get['each'][$each_i]['url'] = SITE_URL . '/' . $media['each'][$each_i]['url'] . '_100x100.' . $media['each'][$each_i]['extension'];
						}
					}
				}
				else
				{
					$get['each'] = $media['each'];
					
					foreach ($media['each'] as $each_i => $each_v)
					{
						$get['each'][$each_i]['url'] = SITE_URL . '/' . $each_v['url'] . '_100x100.' . $each_v['extension'];
					}
				}
			}
			
			unset($this->data['media_id']);
		}
		elseif (! empty($this->data['soundcloud_uri']))
		{
			$get = array();
			$get['type'] = 'soundcloud';
			$get['each'][]['url'] = $this->data['soundcloud_uri'];
			unset($this->data['soundcloud_uri']);
		}

		return $get;
	}

	public function getLocation() {
		$location = false;

		if (! empty($this->data['google_map_name'])) {
			$location = array(
				'name' => $this->data['google_map_name']
			);
		}

		return $location;
	}

	public function getVia($post)
	{
		$via = false;

		if (! empty($post['timeline']['id']))
		{
            $via = array(
            	'type' => 'share',
            	'timeline' => $post['timeline']
            );
        }

        return $via;
	}

	public function getActivity() {
		$activity = false;

		if (! empty($this->data['activity_text'])) {
	            
            preg_match(
            	'/\[album\]([0-9]+)\[\/album\]/i',
            	$this->data['activity_text'],
            	$matches
            );

            $activity_query1 = $this->getConnection()->query("SELECT id,name FROM " . DB_MEDIA . " WHERE id=" . $matches[1]);
            $activity_fetch1 = $activity_query1->fetch_object();

            $activity_text_replace = '<a href="' . smoothLink('index.php?tab1=album&tab2=' . $activity_fetch1->id) . '" data-href="?tab1=album&tab2=' . $activity_fetch1->id . '">' . $activity_fetch1->name . '</a>';

            $activity = str_replace(
            	$matches[0],
            	'<a href="' . smoothLink('index.php?tab1=album&tab2=' . $activity_fetch1->id) . '" data-href="?tab1=album&tab2=' . $activity_fetch1->id . '">' . $activity_fetch1->name . '</a>',
            	$this->data['activity_text']
            );
        }

        return $activity;
	}

	public function getRecipient() {
		$recipient = false;
		
		if ($this->data['recipient_id'] > 0) {
			$recipientObj = new \miuan\User($this->getConnection());
			$recipient = $recipientObj->getById($this->data['recipient_id']);
			$this->recipientObj = $recipientObj;
		}

		unset($this->data['recipient_id']);
		return $recipient;
	}

	public function getReactions($r='')
	{
		$get = array();
		$query = $this->getConnection()->query("SELECT id,timeline_id,reaction FROM " . DB_POSTLIKES . " WHERE post_id=" . $this->data['id'] . " AND active=1");

		if (in_array($r, $this->allowed_reactions))
		{
			$query = $this->getConnection()->query("SELECT id,timeline_id,reaction FROM " . DB_POSTLIKES . " WHERE post_id=" . $this->data['id'] . " AND active=1 AND reaction='$r'");
		}
		else
		{
			$query = $this->getConnection()->query("SELECT id,timeline_id,reaction FROM " . DB_POSTLIKES . " WHERE post_id=" . $this->data['id'] . " AND active=1");
		}
	    
	    if ($query->num_rows > 0)
	    {
	        while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
	        {
	        	$get[$fetch['timeline_id']] = $fetch['reaction'];
	        }
	    }

	    return $get;
	}

	public function getTopReactions($l=3)
	{
		$l = (int) $l;
		$g = array();
		$query = $this->getConnection()->query("SELECT DISTINCT reaction FROM " . DB_POSTLIKES . " WHERE post_id=" . $this->data['id'] . " AND active=1 LIMIT $l");

		while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
		{
			$g[] = $fetch['reaction'];
		}

		return $g;
	}

	public function getComments($li=0)
	{
		$comments = '';
		$numComments = $this->numComments();

		if ($li < 1)
		{
			$li = $numComments;
		}

		$commentFeed = new \miuan\CommentFeed($this->getConnection());
		$commentFeed->setPostId($this->data['id']);
		$commentFeed->setLimit($li);
		$commentFeed->setTotal($numComments);

        foreach ($commentFeed->getFeed() as $commentId)
        {
        	$comment = new \miuan\Comment($this->conn);
        	$comment->setId($commentId);
        	$comments .= $comment->getTemplate();
        }

        return $comments;
	}

	public function getCommentIds($li=0) {
		$get = array();
		$comments = '';
		$numComments = $this->numComments();

		if ($li < 1)
		{
			$li = $numComments;
		}

		$commentFeed = new \miuan\CommentFeed($this->getConnection());
		$commentFeed->setPostId($this->data['id']);
		$commentFeed->setLimit($li);
		$commentFeed->setTotal($numComments);

        foreach ($commentFeed->getFeed() as $commentId)
        {
        	$get[] = $commentId;
        }

        return $get;
	}

	public function getShares()
	{
		$get = array();
		$query = $this->getConnection()->query("SELECT id,timeline_id FROM " . DB_POSTS . " WHERE post_id=" . $this->data['id'] . " AND shared=1 AND active=1");
	    
	    if ($query->num_rows > 0)
	    {
	        while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
	        {
	        	$get[] = $fetch['timeline_id'];
	        }
	    }

	    return $get;
	}

	public function getFollowers()
	{
		$get = array();
		$query = $this->getConnection()->query("SELECT id,timeline_id FROM " . DB_POSTFOLLOWS . " WHERE post_id=" . $this->data['id'] . " AND active=1");
	    
	    if ($query->num_rows > 0)
	    {
	        while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
	        {
	        	$sharer = new \miuan\User($this->getConnection());
	        	$sharer->setId($fetch['timeline_id']);

	            $get[] = $sharer->getRows();
	        }
	    }

	    return $get;
	}

	public function getCommentBox($timelineId=0)
	{
	    if (! isLogged())
	    {
	        return false;
	    }
	    
	    global $themeData, $user;
	    $continue = true;
	    $timelineId = (int) $timelineId;

	    if ($timelineId < 1)
	    {
	    	$timelineId = $user['id'];
	        $timeline = $user;
	    }
	    else
	    {
	        $timelineObj = new \miuan\User();
	        $timelineObj->setId($timelineId);
	        $timeline = $timelineObj->getRows();

	        if (! $timelineObj->isAdmin())
	        {
	        	$continue = false;
	        }
	    }
	    
	    if ($this->data['timeline']['type'] == "user")
	    {
	        if ($this->data['timeline']['id'] != $timelineId && $this->data['timeline']['comment_privacy'] == "following")
	        {
	            if (! $this->timelineObj->isFollowedBy($timelineId))
	            {
	                $continue = false;
	            }
	        }
	    }
	    
	    if ($continue == false)
	    {
	        return false;
	    }

	    $themeData['publisher_id'] = $timeline['id'];
	    $themeData['publisher_url'] = $timeline['url'];
	    $themeData['publisher_username'] = $timeline['username'];
	    $themeData['publisher_name'] = $timeline['name'];
	    $themeData['publisher_thumbnail_url'] = $timeline['thumbnail_url'];

	    $themeData['comment_textarea'] = \miuan\UI::view('comment/publisher-box/textarea');

	    return \miuan\UI::view('comment/publisher-box/content', 'comment_publisher_ui_editor');
	}

	public function setId($id) {
		$this->id = (int) $id;
	}

	public function setProfileId($id) {
		$this->profileId = (int) $id;
	}

	public function putReaction($r)
	{
	    if (! isLogged())
	    {
	        return false;
	    }

	    if (empty($r))
	    {
	    	$r = "like";
	    }
	    else
	    {
	    	$r = $this->escapeObj->stringEscape($r);
	    }
	    
	    global $user;
	    
	    if ($this->isReacted($r))
	    {
	        $this->getConnection()->query("DELETE FROM " . DB_POSTLIKES . " WHERE post_id=" . $this->data['id'] . " AND timeline_id=" . $user['id'] . " AND active=1");
	        $this->putNotification('reaction', $r, true);
	    }
	    else
	    {
	    	$this->getConnection()->query("DELETE FROM " . DB_POSTLIKES . " WHERE post_id=" . $this->data['id'] . " AND timeline_id=" . $user['id'] . " AND reaction<>'$r' AND active=1");

	        $this->getConnection()->query("INSERT INTO " . DB_POSTLIKES . " (timeline_id,active,post_id,reaction,time) VALUES (" . $user['id'] . ",1," . $this->data['id'] . ",'$r'," . time() . ")");

	        $this->putNotification('reaction', $r);

	        /* E-mail notification */
	        if ($this->data['timeline']['id'] != $user['id'])
	        {
	        	if ($this->data['timeline']['type'] == "user")
		        {
		        	if ($this->data['timeline']['mailnotif_postlike'] == true)
		        	{
		        		global $themeData, $config, $lang;
					    $themeData['story_url'] = smoothLink('index.php?tab1=story&id=' . $this->data['id']);
					    $themeData['mail_recipient_name'] = $this->data['timeline']['name'];
					    $themeData['mail_generator_url'] = $user['url'];
					    $themeData['mail_generator_name'] = $user['name'];
					    
					    $subject = $config['site_name'];
						$subject .= " | ";
					    
					    if ($r == "like")
					    {
					    	$subject .= str_replace("{user}", $user['name'] . " (@" . $user['username'] . ")", $lang['new_like_email_subject']);
					    	$message = \miuan\UI::view('emails/notifications/new-like');
					    }
					    else
					    {
					    	$subject .= str_replace("{user}", $user['name'] . " (@" . $user['username'] . ")", $lang['new_reaction_email_subject']);
					    	$message = \miuan\UI::view('emails/notifications/new-reaction');
					    }

					    send_mail($this->data['timeline']['email'], $subject, $message);
		        	}
		        }
	        }
	    }

	    return true;
	}

	public function putShare() {
	    if (! isLogged())
	    {
	        return false;
	    }
	    
	    global $user;
	    
	    if ($this->isShared())
	    {
	        $this->getConnection()->query("DELETE FROM " . DB_POSTS . " WHERE post_id=" . $this->data['id'] . " AND timeline_id=" . $user['id'] . " AND shared=1 AND active=1");
	    }
	    else
	    {
	        $this->getConnection()->query("INSERT INTO " . DB_POSTS . " (active,post_id,shared,time,timeline_id) VALUES (1," . $this->data['id'] . ",1," . time() . "," . $user['id'] . ")");
	        $this->putNotification('share');

	        /* E-mail notification */
	        if ($this->data['timeline']['type'] == "user" && $this->data['timeline']['id'] != $user['id'])
	        {
	        	if ($this->data['timeline']['mailnotif_postshare'] == true)
	        	{
	        		global $themeData, $config, $lang;
				    $themeData['story_url'] = smoothLink('index.php?tab1=story&id=' . $this->data['id']);
				    $themeData['mail_recipient_name'] = $this->data['timeline']['name'];
				    $themeData['mail_generator_url'] = $user['url'];
				    $themeData['mail_generator_name'] = $user['name'];
				    
				    $subject = $config['site_name'];
					$subject .= " | ";
				    $subject .= str_replace("{user}", $user['name'] . " (@" . $user['username'] . ")", $lang['new_share_email_subject']);

				    $message = \miuan\UI::view('emails/notifications/new-share');
				    
				    send_mail($this->data['timeline']['email'], $subject, $message);
	        	}
	        }
	    }

	    return true;
	}

	public function putFollow()
	{
	    if (! isLogged())
	    {
	        return false;
	    }
	    
	    global $user;
	    
	    if ($this->isFollowed())
	    {
	        $this->getConnection()->query("DELETE FROM " . DB_POSTFOLLOWS . " WHERE post_id=" . $this->data['id'] . " AND timeline_id=" . $user['id'] . " AND active=1");
	        $this->putNotification('follow');
	    }
	    else
	    {
	        $this->getConnection()->query("INSERT INTO " . DB_POSTFOLLOWS . " (timeline_id,active,post_id,time) VALUES (" . $user['id'] . ",1," . $this->data['id'] . "," . time() . ")");
	    }

	    return true;
	}

	public function putComment($text='', $timelineId=0)
	{
		if (! isLogged())
	    {
	        return false;
	    }
	    
	    global $user, $config;
	    $ntext = str_replace("\n", "", trim($text));

	    if (empty($ntext))
	    {
	        return false;
	    }

	    if ($config['comment_character_limit'] > 0)
	    {
	        if (strlen($ntext) > $config['comment_character_limit'])
	        {
	            return false;
	        }
	    }
	    
	    $timelineId = (int) $timelineId;

	    if ($timelineId < 1)
	    {
	        $timelineId = $user['id'];
	    }
	    
	    $timelineObj = new \miuan\User($this->getConnection());
	    $timelineObj->setId($timelineId);
	    $timeline = $timelineObj->getRows();
	    $continue = true;
	    
	    if (! $timelineObj->isAdmin())
	    {
	    	return false;
	    }
	    
	    if ($this->data['timeline']['type'] == "user" && $this->data['timeline']['id'] != $timelineId)
	    {
	        if ($this->data['timeline']['comment_privacy'] == "following")
	        {
	            if (! $this->timelineObj->isFollowing($timelineId))
	            {
	                $continue = false;
	            }
	        }
	    }
	    elseif ($this->data['timeline']['type'] == "group")
	    {
	        
	        if (! $this->timelineObj->isFollowing($timelineId))
	        {
	            $continue = false;
	        }
	    }

	    if (!$continue)
	    {
	        return false;
	    }


	    /* Links */
	    $text = $this->escapeObj->createLinks($text);

	    /* Hashtags */
	    $text = $this->escapeObj->createHashtags($text);

	    /* Mentions */
	    $mentions = $this->escapeObj->createMentions($text);
	    $text = $mentions['content'];
	    $this->comment_mentions = $mentions['mentions'];

	    /* Text */
	    $text = $this->escapeObj->postEscape($text);

	    /* Query */
	    $query = $this->getConnection()->query("INSERT INTO " . DB_COMMENTS . " (timeline_id,active,post_id,text,time) VALUES ($timelineId,1," . $this->data['id'] . ",'$text'," . time() . ")");
	    
	    if ($query)
	    {
	        $commentId = $this->getConnection()->insert_id;
	        
	        /* Put follow */
	        if (! $this->isFollowed())
	        {
	            $this->putFollow();
	        }
	        
	        /* Notify followers */
	        $this->putNotification('comment', $commentId, $timeline['id']);


	        /* E-mail notification */
	        if ($this->data['timeline']['type'] == "user" && $this->data['timeline']['id'] != $timeline['id'])
	        {
	        	if ($this->data['timeline']['mailnotif_comment'] == true)
	        	{
	        		global $themeData, $config, $lang;
				    $themeData['story_url'] = smoothLink('index.php?tab1=story&id=' . $this->data['id']);
				    $themeData['mail_recipient_name'] = $this->data['timeline']['name'];
				    $themeData['mail_generator_url'] = $timeline['url'];
				    $themeData['mail_generator_name'] = $timeline['name'];
				    
				    $subject = $config['site_name'];
					$subject .= " | ";
				    $subject .= str_replace("{user}", $timeline['name'] . " (@" . $timeline['username'] . ")", $lang['new_comment_email_subject']);
				    
				    $message = \miuan\UI::view('emails/notifications/new-comment');
				    
				    send_mail($this->data['timeline']['email'], $subject, $message);
	        	}
	        }
	        

	        /* Return results */
	        return $commentId;
	    }
	}

	public function putReport()
	{
		if (! isLogged()) {
			return false;
		}

		if ($this->isReported())
		{
			return false;
		}

		global $user;
		$query = $this->getConnection()->query("INSERT INTO " . DB_REPORTS . " (active,post_id,reporter_id,type) VALUES (1," . $this->data['id'] ."," . $user['id'] . ",'story')");

		if (! $query)
		{
			return false;
		}

		return true;
	}

	public function putRemove()
	{
		if (! isLogged()) {
			return false;
		}

		$continue = false;
        
        if ($this->timelineObj->isAdmin())
        {
            $continue = true;
        }
        elseif (is_array($this->data['recipient']))
        {
            if ($this->recipientObj->isAdmin())
            {
                $continue = true;
            }
        }
        
        if ($continue)
        {
        	if ($this->data['media']['type'] == "photos")
        	{
        		$continue = true;

        		if (isset ($this->data['media']['temp']))
	        	{
	        		$continue = false;

	        		if ($this->data['media']['temp'] == 1)
	        		{
	        			$continue = true;
	        		}
	        	}

        		if ($continue)
        		{
        			foreach ($this->data['media']['each'] as $key => $value)
        			{
	        			$this->getConnection()->query("DELETE FROM " . DB_MEDIA . " WHERE id=" . $value['id'] . " AND type='photo'");
	        			$this->getConnection()->query("DELETE FROM " . DB_POSTS . " WHERE media_id=" . $value['id']);

	        			$dirImages = glob(str_replace(SITE_URL . "/", "", $value['url']) . "*");
	        			
	        			foreach ($dirImages as $k => $img)
	        			{
	                        unlink($img);
	                    }
	        		}
        		}
        	}

        	$this->getConnection()->query("DELETE FROM " . DB_POSTS . " WHERE post_id=" . $this->data['id']);
        	return true;
        }
	}

	public function putNotification($action)
	{
		if (! isLogged())
		{
			return false;
		}

		$lang = array();
		$langQuery = $this->getConnection()->query("SELECT keyword,text FROM " . DB_LANGUAGES . " WHERE type='" . $this->data['timeline']['language'] . "'");
		
		while($langFetch = $langQuery->fetch_array(MYSQLI_ASSOC))
		{
			$lang[$langFetch['keyword']] = $langFetch['text'];
		}

		global $user;
		$text = '';

		if ($this->data['timeline']['id'] == $user['id'])
		{
			return false;
		}

		if ($action == "reaction")
		{
			$count = $this->numReactions();
			$arg2 = 'like';
			$reverse = false;
	        
	        if (func_num_args() > 2)
	        {
	        	$arg2 = (int) func_get_arg(1);
	        }

	        if (func_num_args() > 3)
	        {
	        	$reverse = func_get_arg(2);
	        }
	        
			if ($this->isReacted())
	        {
	            $count = $count - 1;
	        }
	        
	        if ($count > 1)
	        {
	            $text .= str_replace('{count}', ($count-1), $lang['notif_other_people']) . ' ';
	        }

	        if ($arg2 == "like")
	        {
	        	$text .= str_replace('{post}', substr(strip_tags($this->data['text']), 0, 45), $lang['likes_your_post']);
	        }
	        else
	        {
	        	$text .= str_replace('{post}', substr(strip_tags($this->data['text']), 0, 45), $lang['reacted_to_your_post']);
	        }
	        
	        $query = $this->getConnection()->query("SELECT id FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $this->data['timeline']['id'] . " AND post_id=" . $this->data['id'] . " AND type='like' AND active=1");
			
		    if ($query->num_rows > 0)
		    {
		        $this->getConnection()->query("DELETE FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $this->data['timeline']['id'] . " AND post_id=" . $this->data['id'] . " AND type='like' AND active=1");
		    }

		    if ($reverse == false)
		    {
		    	$this->getConnection()->query("INSERT INTO " . DB_NOTIFICATIONS . " (timeline_id,active,notifier_id,post_id,text,time,type,url) VALUES (" . $this->data['timeline']['id'] . ",1," . $user['id'] . "," . $this->data['id'] . ",'$text'," . time() . ",'like','index.php?tab1=story&id=" . $this->data['id'] . "')");
		    }

		    return true;
		}
		elseif ($action == "share")
		{
			$count = $this->numShares();
	        
	        if ($this->isShared())
	        {
	            $count = $count - 1;
	        }
	        
	        if ($count > 1)
	        {
	            $text .= str_replace('{count}', ($count-1), $lang['notif_other_people']) . ' ';
	        }
	        
	        $text .= str_replace('{post}', substr(strip_tags($this->data['text']), 0, 45), $lang['shared_your_post']);
	        $query = $this->getConnection()->query("SELECT id FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $this->data['timeline']['id'] . " AND post_id=" . $this->data['id'] . " AND type='share' AND active=1");
			
		    if ($query->num_rows > 0)
		    {
		        $this->getConnection()->query("DELETE FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $this->data['timeline']['id'] . " AND post_id=" . $this->data['id'] . " AND type='share' AND active=1");
		    }
		    else
		    {
		    	$this->getConnection()->query("INSERT INTO " . DB_NOTIFICATIONS . " (timeline_id,active,notifier_id,post_id,text,time,type,url) VALUES (" . $this->data['timeline']['id'] . ",1," . $user['id'] . "," . $this->data['id'] . ",'$text'," . time() . ",'share','index.php?tab1=story&id=" . $this->data['id'] . "')");
		    }

		    return true;
		}
		elseif ($action == "comment")
		{
			$count = $this->numCommenters();
			$commenterId = 0;
			$countText = '';
			
			if ($count > 1)
            {
                $countText .= str_replace('{count}', ($count-1), $lang['notif_other_people']) . ' ';
            }

            if (func_num_args() > 2)
	        {
	        	$commenterId = (int) func_get_arg(2);
	        }

	        /* Notify story followers */
            foreach ($this->getFollowers() as $follower)
	        {
	        	$text = $countText;
	        	$proceed = true;

	        	if ($proceed)
	        	{
		        	if ($follower['id'] != $commenterId)
		        	{
		        		$postText = strip_tags($this->data['text']);
			        	
			            if ($follower['id'] == $this->data['timeline']['id'])
			            {
			                $text .= str_replace('{post}', substr($postText, 0, 45), $lang['commented_on_post']);
			            }
			            else
			            {
			            	$langtext = $lang['commented_on_user_post'];
		                    $langtext = str_replace('{user}', $this->data['timeline']['name'], $langtext);
		                    $langtext = str_replace('{post}', substr($postText, 0, 45), $langtext);
		                    $text .= $langtext;
			            }

			            $query = $this->getConnection()->query("SELECT id FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $follower['id'] . " AND post_id=" . $this->data['id'] . " AND type='comment' AND active=1");
						
					    if ($query->num_rows > 0)
					    {
					        $this->getConnection()->query("DELETE FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $follower['id'] . " AND post_id=" . $this->data['id'] . " AND type='comment' AND active=1");
					    }
					    
					    $this->getConnection()->query("INSERT INTO " . DB_NOTIFICATIONS . " (timeline_id,active,notifier_id,post_id,text,time,type,url) VALUES (" . $follower['id'] . ",1," . $commenterId . "," . $this->data['id'] . ",'$text'," . time() . ",'comment','index.php?tab1=story&id=" . $this->data['id'] . "')");
		        	}
		        }
		    }

	        /* Notify people mentioned */
	        if (func_num_args() > 1)
	        {
	        	$commentId = (int) func_get_arg(1);
	        	$text = $lang['mentioned_in_comment'];

		        foreach ($this->comment_mentions as $mention)
		        {
	            	$query = $this->getConnection()->query("SELECT id FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $mention . " AND post_id=" . $this->data['id'] . " AND type='post_mention' AND active=1");
					
				    if ($query->num_rows > 0)
				    {
				        $this->getConnection()->query("DELETE FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $mention . " AND post_id=" . $this->data['id'] . " AND type='post_mention' AND active=1");
				    }
				    else
				    {
				    	$this->getConnection()->query("INSERT INTO " . DB_NOTIFICATIONS . " (timeline_id,active,notifier_id,post_id,text,time,type,url) VALUES (" . $mention . ",1," . $user['id'] . "," . $this->data['id'] . ",'$text'," . time() . ",'post_mention','index.php?tab1=story&id=" . $this->data['id'] . "#comment_$commentId')");
				    }
		        }
	        }

            return true;
		}
	}

	/* Template Methods */

	public function getTemplate() {

		if (! is_array($this->data))
		{
			$this->getRows();
		}

		if (! isset($this->data['id']))
		{
			return false;
		}
		
		global $themeData, $user, $config;

		$themeData['story_privacy'] = "public";
		$themeData['story_privacy_title'] = "Public";
		$themeData['story_privacy_icon'] = '<i class="fa fa-globe"></i>';

		if ($this->data['privacy'] == "friends")
		{
			$themeData['story_privacy'] = "people_i_follow";
			$themeData['story_privacy_title'] = "People I Follow";
			$themeData['story_privacy_icon'] = '<i class="fa fa-users"></i>';

			if ( !isLogged() )
			{
				return "";
			}

			if ($this->data['timeline']['id'] != $user['id'])
			{
				$friendsCheck = $this->conn->query("SELECT id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $this->data['timeline']['id'] . " AND following_id=" . $user['id'] . " AND active=1");

				if ($friendsCheck->num_rows != 1)
				{
					return "";
				}
			}
		}

		if (is_array ($this->data['recipient']))
		{
			if ($this->data['recipient']['type'] == "group")
			{
				$themeData['story_privacy'] = "people_i_follow";
				$themeData['story_privacy_title'] = $this->data['recipient']['name'];
				$themeData['story_privacy_icon'] = '<i class="fa fa-group"></i>';
			}
		}
		
		// Basic Template Data
		$this->getBasicTemplateData();

		// Recipient Template Data
        $this->getRecipientTemplate();

        /* Control buttons */
        $themeData['story_control_buttons'] = $this->getControlButtonTemplate();

        /* Text */
        $themeData['story_text_html'] = $this->getTextTemplate();

        /* Media */
        $themeData['media_html'] = $this->getMediaTemplate();
        $mediaHtml = \miuan\Addons::invoke(array('story_display_addon_data', 'string'), $this->conn, $this->data);

        if ( !is_array($mediaHtml) )
        {
        	$themeData['media_html'] .= $mediaHtml;
        }

        /* Location */
        $themeData['story_location_name'] = '';
        if (! empty ($this->data['location']))
        {
			$themeData['story_location_name'] = $this->data['location']['name'];
        }

        $themeData['story_location_html'] = $this->getLocationTemplate();

        // Reaction Activity
        $themeData['story_like_activity'] = $themeData['story_reaction_activity'] = $this->getReactionActivityTemplate();

        // Comment Activity
        $themeData['story_comment_activity'] = $this->getCommentActivityTemplate();

        // Share Activity
        $themeData['story_share_activity'] = $this->getShareActivityTemplate();

        // Follow Activity
        $themeData['story_follow_activity'] = $this->getFollowActivityTemplate();

        // Via
        $themeData['via'] = $this->getViaTemplate();

        // View all comments
        $themeData['view_all_comments_html'] = '';
        $commentsNum = $themeData['story_comments_num'];
        
        if ($this->view_all_comments == false) {
            
            if ($commentsNum > 3) {
            	$themeData['view_all_comments_html'] = \miuan\UI::view('story/view-all-comments-html');
            }

            $commentsNum = 3;
        }

        // Comments
        $themeData['comments'] = $this->getComments($commentsNum);

        // Comment Publisher Box
        $show_comment_publisher_box = true;
        $commentPublisherBox = '';
        
        if ($this->data['timeline']['type'] == "user")
        {
            if ($this->data['timeline']['comment_privacy'] == "following" && $this->data['timeline']['id'] != $user['id'])
            {
                if (! $this->timelineObj->isFollowing())
                {
                    $show_comment_publisher_box = false;
                }
            }

        } elseif ($this->data['timeline']['type'] == "group")
        {
            if (! $this->timelineObj->isFollowedBy())
            {
                $show_comment_publisher_box = false;
            }
        }
        
        if ($show_comment_publisher_box == true)
        {
        	if ($this->timelineObj->isAdmin())
        	{
        		$commentPublisherBox = $this->getCommentBox($this->data['timeline']['id']);
        	}
        	else
        	{
        		$commentPublisherBox = $this->getCommentBox();
        	}
        }

        $themeData['comment_publisher_box'] = $commentPublisherBox;

        $this->template = \miuan\UI::view('story/content', 'story_content_ui_editor', $this->conn, $this->data);
        return $this->template;
	}

	public function getBasicTemplateData() {
		global $themeData;

		$themeData['story_id'] = $this->data['id'];
        $themeData['story_activity_text'] = $this->data['activity_text'];
        $themeData['story_time'] = date('c', $this->data['time']);

        $themeData['story_timeline_id'] = $this->data['timeline']['id'];
        $themeData['story_timeline_url'] = $this->data['timeline']['url'];
        $themeData['story_timeline_username'] = $this->data['timeline']['username'];
        $themeData['story_timeline_name'] = $this->data['timeline']['name'];
        $themeData['story_timeline_thumbnail_url'] = $this->data['timeline']['thumbnail_url'];
        $themeData['story_timeline_link'] = \miuan\UI::view('story/timeline-link');
	}

	public function getRecipientTemplate() {
		global $themeData;
		$themeData['story_recipient_html'] = '';
		
		if (isset($this->data['recipient']['id']))
		{
            $themeData['story_recipient_id'] = $this->data['recipient']['id'];
            $themeData['story_recipient_url'] = $this->data['recipient']['url'];
            $themeData['story_recipient_username'] = $this->data['recipient']['username'];
            $themeData['story_recipient_name'] = $this->data['recipient']['name'];
            $themeData['story_recipient_thumbnail_url'] = $this->data['recipient']['thumbnail_url'];
            $themeData['story_recipient_html'] = \miuan\UI::view('story/recipient-html');
        }
	}

	public function getRemoveButtonTemplate() {
		if ($this->data['admin'] == true)
		{
            return \miuan\UI::view('story/remove-button');
        }
	}

	public function getReportButtonTemplate() {
		if ($this->data['admin'] != true && ! $this->isReported())
		{
            return \miuan\UI::view('story/report-button');
        }
	}

	public function getReactButtonTemplate()
	{
		global $themeData;

		$themeData['story_reactions'] = \miuan\UI::view('story/reactions');

		if ($reaction = $this->isReacted())
		{
            return \miuan\UI::view('story/reaction-' . $reaction . '-button');
        } else {
            return \miuan\UI::view('story/react-button');
        }
	}

	public function getShareButtonTemplate() {
		if ($this->isShared()) {
	        return \miuan\UI::view('story/unshare-button');
	    } else {
	        return \miuan\UI::view('story/share-button');
	    }
	}

	public function getFollowButtonTemplate() {
		if ($this->isFollowed()) {
	        return \miuan\UI::view('story/unfollow-button');
	    } else {
	        return \miuan\UI::view('story/follow-button');
	    }
	}

	public function getControlButtonTemplate() {
		
		if (isLogged()) {
			global $themeData;

        	// Remove Button
        	$themeData['story_remove_button'] = $this->getRemoveButtonTemplate();

        	// Report Button
        	$themeData['story_report_button'] = $this->getReportButtonTemplate();

		    // Reaction Button
        	$themeData['story_like_button'] = $themeData['story_reaction_button'] = $this->getReactButtonTemplate();

	        // Share Button
	        $themeData['story_share_button'] = $this->getShareButtonTemplate();

		    // Notification Button
		    $themeData['story_notification_button'] = $this->getFollowButtonTemplate();

		    return \miuan\UI::view('story/control-buttons');
        }
	}

	public function getTextTemplate()
	{
		global $themeData;
		$themeData['story_text'] = "";

		if (! empty($this->data['text']))
		{
        	$themeData['story_text'] = $this->data['text'];
        }

        return \miuan\UI::view('story/story-text');
	}

	public function getMediaTemplate()
	{
		global $themeData;

		if ($this->data['media'] != false)
		{
        	if ($this->data['media']['type'] == "photos")
        	{
        		$photo_class = 'width-' . $this->data['media']['num'];
	            
	            if ($this->data['media']['num'] >= 3)
	            {
	                $photo_class = 'width-3';
	            }
	            
	            $listPhotos = '';

	            if (is_array($this->data['media']['each']))
	            {
	            	foreach ($this->data['media']['each'] as $photo)
	            	{
		                $themeData['list_photo_class'] = $photo_class;
		                $themeData['list_photo_url'] = $photo['url'];
		                $themeData['list_photo_story_id'] = $photo['post_id'];

		                $listPhotos .= \miuan\UI::view('story/list-photo-each');
		            }
	            }

	            $themeData['list_photos'] = $listPhotos;
	            return \miuan\UI::view('story/photos-html');

        	}
        } elseif ($this->data['location'] != false)
        {
        	$themeData['story_location_name'] = $this->data['location']['name'];
        	return \miuan\UI::view('story/map-html');
        }
	}

	public function getLocationTemplate() {
		if (! empty ($this->data['location']))
		{
			$themeData['story_location_name'] = $this->data['location']['name'];
        	return \miuan\UI::view('story/location-html');
        }
	}

	public function getReactionActivityTemplate()
	{
		global $themeData;

		$vvv = '';
		$themeData['story_likes_num'] = $themeData['story_reaction_num'] = $this->numReactions();
		$themeData['list_reactions'] = '';

		foreach ($this->getTopReactions() as $k => $v)
		{
			$themeData['list_reaction_name'] = $v;
			$themeData['list_reactions'] .= \miuan\UI::view('story/list-reaction-activity-each');
		}

        return \miuan\UI::view('story/reaction-activity') . $vvv;
	}

	public function getCommentActivityTemplate() {
		global $themeData;

		$themeData['story_comments_num'] = $this->numComments();
        return \miuan\UI::view('story/comment-activity');
	}

	public function getShareActivityTemplate() {
		global $themeData;

		$themeData['story_shares_num'] = $this->numShares();
        return \miuan\UI::view('story/share-activity');
	}

	public function getFollowActivityTemplate() {
		global $themeData;

		$themeData['story_followers_num'] = $this->numFollowers();
        return \miuan\UI::view('story/follow-activity');
	}

	public function getViaTemplate() {
		global $themeData;

		if (! empty ($this->data['via']))
		{
        	$themeData['story_via_id'] = $this->data['via']['timeline']['id'];
        	$themeData['story_via_url'] = $this->data['via']['timeline']['url'];
        	$themeData['story_via_username'] = $this->data['via']['timeline']['username'];
        	$themeData['story_via_name'] = $this->data['via']['timeline']['name'];

        	if (isLogged())
        	{
        		global $user;

        		if ($this->data['via']['timeline']['id'] == $user['id'])
        		{
        			$themeData['story_via_name'] = "You";
        		}
        	}
        	
        	if ($this->data['via']['type'] == "like")
        	{
        		$themeData['via_html'] = \miuan\UI::view('story/via-reaction-html');

        	} elseif ($this->data['via']['type'] == "share")
        	{
        		$themeData['via_html'] = \miuan\UI::view('story/via-share-html');

        	} elseif ($this->data['via']['type'] == "tag") {
        		$themeData['via_html'] = \miuan\UI::view('story/via-tag-html');
        	}

        	return \miuan\UI::view('story/via-html');
        }
	}

	public function getReactionsTemplate($r='')
	{
		global $themeData;

		$themeData['reaction_story_id'] = $this->data['id'];

		$themeData['story_reaction_likes_num'] = $this->numReactions('like');
		$themeData['story_reaction_love_num'] = $this->numReactions('love');
		$themeData['story_reaction_haha_num'] = $this->numReactions('haha');
		$themeData['story_reaction_wow_num'] = $this->numReactions('wow');
		$themeData['story_reaction_sad_num'] = $this->numReactions('sad');
		$themeData['story_reaction_angry_num'] = $this->numReactions('angry');
		
		$listReactions = $this->getReactionsListTemplate($r);

        $themeData['list_likes'] = $themeData['list_reactions'] = $listReactions;
        return \miuan\UI::view('story/view-reactions');
	}

	public function getReactionsListTemplate($r='')
	{
		global $themeData;
		
		$i = 0;
		$listReactions = '';

        foreach ($this->getReactions($r) as $reactorId => $reaction)
        {
        	$reactorObj = new \miuan\User();
        	$reactorObj->setId($reactorId);
        	$reactor = $reactorObj->getRows();

        	$themeData['list_liker_reaction'] = $reaction;

            $themeData['list_liker_id'] = $themeData['list_reactor_id'] = $reactor['id'];
            $themeData['list_liker_url'] = $themeData['list_reactor_url'] = $reactor['url'];
            $themeData['list_liker_username'] = $themeData['list_reactor_username'] = $reactor['username'];
            $themeData['list_liker_name'] = $themeData['list_reactor_name'] = $reactor['name'];
            $themeData['list_liker_thumbnail_url'] = $themeData['list_reactor_thumbnail_url'] = $reactor['thumbnail_url'];

            $themeData['list_liker_button'] = $themeData['list_reactor_button'] = $reactorObj->getFollowButton();

            $listReactions .= \miuan\UI::view('story/list-view-reactions-each');
            $i++;
        }

        if ($i < 1)
        {
            $listReactions .= \miuan\UI::view('story/view-reactions-none');
        }

        return $listReactions;
	}

	public function getSharesTemplate() {
		global $themeData;
		$i = 0;
		$listShares = '';

        foreach ($this->getShares() as $sharerId)
        {
            $sharerObj = new \miuan\User();
        	$sharerObj->setId($sharerId);
        	$sharer = $sharerObj->getRows();

            $themeData['list_sharer_id'] = $sharer['id'];
            $themeData['list_sharer_url'] = $sharer['url'];
            $themeData['list_sharer_username'] = $sharer['username'];
            $themeData['list_sharer_name'] = $sharer['name'];
            $themeData['list_sharer_thumbnail_url'] = $sharer['thumbnail_url'];

            $themeData['list_sharer_button'] = $sharerObj->getFollowButton();

            $listShares .= \miuan\UI::view('story/list-view-shares-each');
            $i++;
        }

        if ($i < 1) {
            $listShares .= \miuan\UI::view('story/view-shares-none');
        }

        $themeData['list_shares'] = $listShares;
        return \miuan\UI::view('story/view-shares');
	}

	public function getRemoveTemplate() {
		return \miuan\UI::view('story/view-remove');
	}
}