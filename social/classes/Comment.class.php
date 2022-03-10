<?php

namespace miuan;

class Comment {
	use \SocialTrait\AddOn;

	private $id;
	private $conn;
	private $timelineObj;
	
	public $data;
	public $themeData;
	public $template;
	private $escapeObj;

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
		$this->id = (int) $this->id;

		$query1 = $this->getConnection()->query("SELECT * FROM " . DB_COMMENTS . " WHERE id=" . $this->id . " AND active=1");

		if ($query1->num_rows == 1)
		{
			$this->data = $query1->fetch_array(MYSQLI_ASSOC);

			/* Timeline */
			$this->data['timeline'] = $this->getTimeline();

			/* Text */
			$this->data['text'] = $this->escapeObj->getEmoticons($this->data['text']);
	        $this->data['text'] = $this->escapeObj->getLinks($this->data['text']);
	        $this->data['text'] = $this->escapeObj->getHashtags($this->data['text']);
	        $this->data['text'] = $this->escapeObj->getMentions($this->data['text']);

			/* Admin */
			$this->data['admin'] = $this->isAdmin();

			/* Basic Template Data */
			$this->getBasicTemplate();

			/* Return result */
			return $this->data;
		}
	}

	public function getById($id) {
		$this->setId($id);
		return $this->getTemplate();
	}

	function isLiked($timeline_id=0) {
	    if (! isLogged()) {
	        return false;
	    }
	    
	    global $user;
	    $timeline_id = (int) $timeline_id;

	    if ($timeline_id == 0) {
	        $timeline_id = $user['id'];
	    }
	    
	    $query = $this->getConnection()->query("SELECT id FROM " . DB_COMMENTLIKES . " WHERE post_id=" . $this->id . " AND timeline_id=$timeline_id AND active=1");
	    
	    if ($query->num_rows == 1) {
	        return true;
	    }
	}

	public function isReported() {
	    if (! isLogged())
	    {
			return false;
		}
		
		global $user;
		$query = $this->getConnection()->query("SELECT id FROM " . DB_REPORTS . " WHERE reporter_id=" . $user['id'] . " AND post_id=" . $this->data['id'] . " AND type='comment'");

		if ($query->num_rows == 1) {
			return true;
		}
	}

	public function isAdmin()
	{
		global $user;
		$admin = false;

		if ($this->timelineObj->isAdmin())
        {
			$admin = true;
		}

        return $admin;
	}

	public function numLikes()
	{
	    $query = $this->getConnection()->query("SELECT COUNT(id) AS count FROM " . DB_COMMENTLIKES . " WHERE post_id=" . $this->id . " AND active=1");
	    $fetch = $query->fetch_array(MYSQLI_ASSOC);
	    
	    return $fetch['count'];
	}

	public function getLikes()
	{
		$get = array();
		$query = $this->getConnection()->query("SELECT id,timeline_id FROM " . DB_COMMENTLIKES . " WHERE post_id=" . $this->id . " AND active=1");
	    
	    if ($query->num_rows > 0)
	    {
	        while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
	        {
	        	$get[] = $fetch['timeline_id'];
	        }
	    }

	    return $get;
	}

	public function getTimeline()
	{
		$this->timelineObj = new \miuan\User($this->getConnection());
		$this->timelineObj->setId($this->data['timeline_id']);
		$timeline = $this->timelineObj->getRows();

		unset($this->data['timeline_id']);
		return $timeline;
	}

	public function getId($id)
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = (int) $id;
	}

	public function putLike()
	{
	    if (! isLogged())
	    {
	        return false;
	    }
	    
	    global $user;
	    
	    if ($this->isLiked())
	    {
	        $this->getConnection()->query("DELETE FROM " . DB_COMMENTLIKES . " WHERE post_id=" . $this->id . " AND timeline_id=" . $user['id'] . " AND active=1");
	    }
	    else
	    {
	        $this->getConnection()->query("INSERT INTO " . DB_COMMENTLIKES . " (timeline_id,active,post_id,time) VALUES (" . $user['id'] . ",1," . $this->id . "," . time() . ")");
	        $this->putNotification('like');
	    }

	    return true;
	}

	public function putReport()
	{
		if (! isLogged())
		{
			return false;
		}

		if ($this->isReported())
		{
			return false;
		}

		global $user;
		$query = $this->getConnection()->query("INSERT INTO " . DB_REPORTS . " (active,post_id,reporter_id,type) VALUES (1," . $this->data['id'] ."," . $user['id'] . ",'comment')");

		if (! $query) {
			return false;
		}

		return true;
	}

	public function putRemove()
	{
		if (! isLogged())
		{
			return false;
		}

		$continue = false;
        
        if ($this->timelineObj->isAdmin())
        {
            $continue = true;
        }
        
        if ($continue)
        {
        	$this->getConnection()->query("DELETE FROM " . DB_COMMENTS . " WHERE id=" . $this->id);
        	$this->getConnection()->query("DELETE FROM " . DB_COMMENTLIKES . " WHERE post_id=" . $this->id);
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

		if ($action == "like")
		{
			$count = $this->numLikes();
	        
	        if ($this->isLiked())
	        {
	            $count = $count - 1;
	        }
	        
	        if ($count > 1)
	        {
	            $text .= str_replace('{count}', ($count-1), $lang['notif_other_people']) . ' ';
	        }
	        
	        $text .= str_replace('{comment}', substr(strip_tags($this->data['text']), 0, 45), $lang['likes_your_comment']);
	        $query = $this->getConnection()->query("SELECT id FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $this->data['timeline']['id'] . " AND post_id=" . $this->id . " AND type='like' AND active=1");
			
		    if ($query->num_rows > 0)
		    {
		        $this->getConnection()->query("DELETE FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $this->data['timeline']['id'] . " AND post_id=" . $this->id . " AND type='like' AND active=1");
		    }
		    else
		    {
		    	$this->getConnection()->query("INSERT INTO " . DB_NOTIFICATIONS . " (timeline_id,active,notifier_id,post_id,text,time,type,url) VALUES (" . $this->data['timeline']['id'] . ",1," . $user['id'] . "," . $this->id . ",'$text'," . time() . ",'like','index.php?tab1=story&id=" . $this->data['post_id'] . "#comment_" . $this->id . "')");
		    }

		    return true;
		}
	}

	/* Template Methods */
	public function getTemplate() {

		if (! is_array($this->data)) {
			$this->getRows();
		}

		global $themeData;

		/* Basic Template Data */
		$this->getBasicTemplate();

		/* Control buttons */
		$themeData['comment_control_buttons'] = $this->getControlButtonsTemplate();

		/* Like activity */
		$themeData['comment_like_activity'] = $this->getLikeActivityTemplate();

		/* Like button */
		$themeData['comment_like_button'] = $this->getLikeButtonTemplate();

		/* Return template */
		$this->template = \miuan\UI::view('comment/content', 'comment_content_ui_editor', $this->conn, $this->data);
		return $this->template;
	}

	public function getBasicTemplate() {
		global $themeData;

		$themeData['comment_id'] = $this->data['id'];
		$themeData['comment_text'] = $this->data['text'];
		$themeData['comment_time'] = date('c', $this->data['time']);

		/* Timeline */
		$themeData['comment_timeline_id'] = $this->data['timeline']['id'];
		$themeData['comment_timeline_url'] = $this->data['timeline']['url'];
		$themeData['comment_timeline_username'] = $this->data['timeline']['username'];
		$themeData['comment_timeline_name'] = $this->data['timeline']['name'];
		$themeData['comment_timeline_thumbnail_url'] = $this->data['timeline']['thumbnail_url'];
		$themeData['comment_timeline_link'] = \miuan\UI::view('comment/timeline-link');
	}

	public function getControlButtonsTemplate() {
		global $themeData;

		if (isLogged())
		{
			$themeData['comment_remove_button'] = $this->getRemoveButtonTemplate();
			$themeData['comment_report_button'] = $this->getReportButtonTemplate();

			return \miuan\UI::view('comment/control-buttons');
		}
	}

	public function getRemoveButtonTemplate() {
		if (isLogged())
		{

			if ($this->data['admin'] == true)
			{
				return \miuan\UI::view('comment/remove-button');
			}
		}
	}

	public function getReportButtonTemplate() {
		if (isLogged()) {

			if ($this->data['admin'] != true && !$this->isReported())
			{
				return \miuan\UI::view('comment/report-button');
			}
		}
	}

	public function getLikeActivityTemplate() {
		global $themeData;

		$themeData['comment_num_likes'] = $this->numLikes();
		return \miuan\UI::view('comment/like-activity');
	}

	public function getLikeButtonTemplate() {
		if (isLogged())
		{
			if ($this->isLiked())
			{
	            return \miuan\UI::view('comment/unlike-button');
	        }
	        else
	        {
	            return \miuan\UI::view('comment/like-button');
	        }
		}
	}

	public function getLikesTemplate()
	{
		global $themeData;
		$i = 0;
		$listLikes = '';

        foreach ($this->getLikes() as $likerId)
        {
        	$likerObj = new \miuan\User();
        	$likerObj->setId($likerId);
        	$liker = $likerObj->getRows();

            $themeData['list_liker_id'] = $liker['id'];
            $themeData['list_liker_url'] = $liker['url'];
            $themeData['list_liker_username'] = $liker['username'];
            $themeData['list_liker_name'] = $liker['name'];
            $themeData['list_liker_thumbnail_url'] = $liker['thumbnail_url'];

            $themeData['list_liker_button'] = $likerObj->getFollowButton();

            $listLikes .= \miuan\UI::view('comment/list-view-likes-each');
            $i++;
        }

        if ($i < 1) {
            $listLikes .= \miuan\UI::view('comment/view-likes-none');
        }

        $themeData['list_likes'] = $listLikes;
        return \miuan\UI::view('comment/view-likes');
	}

	public function getRemoveTemplate() {
		return \miuan\UI::view('comment/view-remove');
	}
}