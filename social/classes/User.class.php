<?php

namespace miuan;

class User
{
	use \SocialTrait\AddOn;

	private $id;
	private $conn;
	public $data;
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
		$query1 = $this->getConnection()->query("SELECT * FROM " . DB_ACCOUNTS . " WHERE id=" . $this->id . " AND active=1");

		if ($query1->num_rows == 1)
		{
			$account_data = $query1->fetch_array(MYSQLI_ASSOC);

			if ($account_data['type'] === "user")
			{
				$user_data = $this->getData();
			}
			elseif ($account_data['type'] === "page")
			{
				$user_data = $this->getPageData();
			}
			elseif ($account_data['type'] === "group")
			{
				$user_data = $this->getGroupData();

			}

			$this->data = array_merge($account_data, $user_data);
			$this->data['url'] = smoothLink('index.php?tab1=timeline&id=' . $this->data['username']);

			if (empty ($this->data['language']))
			{
				$this->data['language'] = "english";
			}

			// Get first and last names
			$this->getNames();

			// Get avatar
			$this->getAvatar();

			// Get cover
			$this->getCover();

			// Get verified result
			$this->getVerified();

			// Get online status
			$this->getOnline();

			// Invoke plugin
			//$this->data = $this->invoke('user_data_endeditor', $this->data);

			// Caching
			/*$_SESSION['tempche']['user'][$this->id] = $this->data;
			$_SESSION['tempche']['user'][$this->id]['expire_time'] = time() + (60 * 5);*/

			return $this->data;
		}
	}

	public function getById($id) {
		 $this->setId($id);
		 return $this->getRows();
	}

	public function isFollowing($fid=0)
	{
		if (! isLogged()) {
			return false;
		}

		$fid = (int) $fid;

		if ($fid < 1)
		{
			global $user;
			$fid = $user['id'];
		}

		$query = $this->getConnection()->query("SELECT id FROM ". DB_FOLLOWERS ." WHERE follower_id=" . $this->id . " AND following_id=$fid AND active=1");
		
		if ($query->num_rows > 0)
		{
			return true;
		}
	}

	public function isFollowedBy($fid=0)
	{
		if (! isLogged())
		{
			return false;
		}

		$fid = (int) $fid;

		if ($fid < 1)
		{
			global $user;
			$fid = $user['id'];
		}

		$query = $this->getConnection()->query("SELECT id FROM ". DB_FOLLOWERS ." WHERE follower_id=$fid AND following_id=" . $this->id . " AND active=1");
		
		if ($query->num_rows > 0)
		{
			return true;
		}
	}

	public function isFollowRequested($fid=0)
	{
		if (! isLogged())
		{
			return false;
		}

		$fid = (int) $fid;

		if ($fid < 1)
		{
			global $user;
			$fid = $user['id'];
		}
		
		$query = $this->getConnection()->query("SELECT id FROM " . DB_FOLLOWERS . " WHERE follower_id=$fid AND following_id=" . $this->id . " AND active=0");
		
		if ($query->num_rows > 0) {
			return true;
		}
	}

	public function isAdmin($adminId=0)
	{
		if (! isLogged())
		{
			return false;
		}
		
		$adminId = (int) $adminId;
		
		if ($this->data['type'] == "user")
		{
			if ($adminId < 1)
			{
				global $user;
				$adminId = $user['id'];
			}

			if ($adminId == $this->id)
			{
				return true;
			}
		}
		elseif ($this->data['type'] == "page")
		{
			return $this->isPageAdmin($adminId);
		}
		elseif ($this->data['type'] == "group")
		{
			return $this->isGroupAdmin($adminId);
		}
	}

	public function isPageAdmin($adminId=0)
	{
		if (! isLogged())
		{
			return false;
		}
		
		global $conn, $user;
		$adminId = (int) $adminId;

		if ($adminId < 1)
		{
			$adminId = $user['id'];
		}
		
		$query = $conn->query("SELECT id,role FROM " . DB_PAGE_ADMINS . " WHERE admin_id=$adminId AND page_id=" . $this->id . " AND active=1");
		
		if ($query->num_rows == 1)
		{
			$fetch = $query->fetch_array(MYSQLI_ASSOC);
			return $fetch['role'];
		}
	}

	public function isGroupAdmin($adminId=0) {
		if (! isLogged()) {
			return false;
		}
		
		global $conn, $user;
		$adminId = (int) $adminId;

		if ($adminId < 1) {
			$adminId = $user['id'];
		}
		
		$query = $conn->query("SELECT id FROM " . DB_GROUP_ADMINS . " WHERE admin_id=$adminId AND group_id=" . $this->id . " AND active=1");
		
		if ($query->num_rows == 1) {
			return true;
		}
	}

	public function numFollowRequests()
	{
		$query = $this->getConnection()->query("SELECT COUNT(id) AS count FROM " . DB_ACCOUNTS . "
			WHERE id IN (SELECT follower_id FROM " . DB_FOLLOWERS . " WHERE following_id=" . $this->id . " AND follower_id<>" . $this->id . " AND active=0) AND active=1");
		$fetch = $query->fetch_array(MYSQLI_ASSOC);
		
		return $fetch['count'];
	}

	public function numFollowing() {
		$query = $this->getConnection()->query("SELECT COUNT(id) AS count FROM " . DB_ACCOUNTS . "
			WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $this->id . " AND following_id<>" . $this->id . " AND active=1) AND type='user' AND active=1");
		$fetch = $query->fetch_array(MYSQLI_ASSOC);
		
		return $fetch['count'];
	}

	public function numFollowers()
	{
		$query = $this->getConnection()->query("SELECT COUNT(id) AS count FROM " . DB_ACCOUNTS . "
			WHERE id IN (SELECT follower_id FROM " . DB_FOLLOWERS . " WHERE following_id=" . $this->id . " AND follower_id<>" . $this->id . " AND active=1) AND active=1");
		$fetch = $query->fetch_array(MYSQLI_ASSOC);
		
		return $fetch['count'];
	}

	public function numPageLikes()
	{
		$query = $this->getConnection()->query("SELECT COUNT(id) AS count FROM " . DB_ACCOUNTS . "
			WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $this->id . " AND following_id<>" . $this->id . " AND active=1) AND type='page' AND active=1");
		$fetch = $query->fetch_array(MYSQLI_ASSOC);
		
		return $fetch['count'];
	}

	public function numGroupsJoined()
	{
		$query = $this->getConnection()->query("SELECT COUNT(id) AS count FROM " . DB_ACCOUNTS . "
			WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $this->id . " AND following_id<>" . $this->id . " AND active=1) AND type='group' AND active=1");
		$fetch = $query->fetch_array(MYSQLI_ASSOC);
		
		return $fetch['count'];
	}

	public function numPageAdmins()
	{
		$query = $this->getConnection()->query("SELECT COUNT(DISTINCT admin_id) AS count FROM " . DB_PAGE_ADMINS . "
			WHERE page_id=" . $this->id . " AND active=1");
		$fetch = $query->fetch_array(MYSQLI_ASSOC);
		
		return $fetch['count'];
	}

	public function numGroupAdmins()
	{
		$query = $this->getConnection()->query("SELECT COUNT(DISTINCT admin_id) AS count FROM " . DB_GROUP_ADMINS . "
			WHERE group_id=" . $this->id . " AND active=1");
		$fetch = $query->fetch_array(MYSQLI_ASSOC);
		
		return $fetch['count'];
	}

	public function numStories()
	{
		$where1 = "timeline_id=" . $this->id . " AND recipient_id=0";
		
		if ($this->data['type'] == "group") {
			$where1 = "recipient_id=" . $this->id;
		}
		
		$query = $this->getConnection()->query("SELECT COUNT(id) AS count FROM " . DB_POSTS . " WHERE $where1 AND hidden=0 AND active=1");
		$fetch = $query->fetch_array(MYSQLI_ASSOC);
		
		return $fetch['count'];
	}

	public function numMessages($new=false)
	{
		$queryText = "SELECT COUNT(DISTINCT timeline_id) AS count FROM " . DB_MESSAGES . " WHERE active=1 AND recipient_id=" . $this->id;
		
		if ($new = true)
		{
			$queryText .= " AND seen=0";
		}
		
		$query = $this->getConnection()->query($queryText);
		$fetch = $query->fetch_array(MYSQLI_ASSOC);
		
		return $fetch['count'];
	}

	public function setId($id)
	{
		$this->id = (int) $id;
	}

	private function getVerified() 
	{
		$this->data['verified'] = ($this->data['verified'] == 1) ? true : false;
	}

	private function getAvatar()
	{
		if ($this->data['avatar_id'] > 0)
		{
			$mediaObj = new \miuan\Media();
			$this->data['avatar'] = $mediaObj->getById($this->data['avatar_id']);
			$this->data['thumbnail_url'] =  SITE_URL . '/' . $this->data['avatar']['each'][0]['url'] . '_thumb.' . $this->data['avatar']['each'][0]['extension'];
			$this->data['avatar_url'] =  SITE_URL . '/' . $this->data['avatar']['each'][0]['url'] . '_100x100.' . $this->data['avatar']['each'][0]['extension'];
		}
	}

	private function getCover()
	{
		if ($this->data['cover_id'] > 0)
		{
			$mediaObj = new \miuan\Media();
			$this->data['cover'] = $mediaObj->getById($this->data['cover_id']);
			$this->data['actual_cover_url'] =  SITE_URL . '/' . $this->data['cover']['each'][0]['url'] . '.' . $this->data['cover']['each'][0]['extension'];
			$this->data['cover_url'] =  SITE_URL . '/' . $this->data['cover']['each'][0]['url'] . '_cover.' . $this->data['cover']['each'][0]['extension'];
		}
		else
		{
			if ($this->data['type'] == "page")
			{
				$this->data['actual_cover_url'] = $this->data['cover_url'] =  THEME_URL . '/images/default-cover-page.png';
			}
			elseif ($this->data['type'] == "group")
			{
				$this->data['actual_cover_url'] = $this->data['cover_url'] =  THEME_URL . '/images/default-cover-group.png';
			}
			else
			{
				$this->data['actual_cover_url'] = $this->data['cover_url'] =  THEME_URL . '/images/default-cover-user.png';
			}
		}
	}

	private function getData() {
		$query = $this->getConnection()->query("SELECT * FROM " . DB_USERS . " WHERE id=" . $this->id);
		
		if ($query->num_rows === 1) {
			$fetch = $query->fetch_array(MYSQLI_ASSOC);
			
			if (! empty($fetch['birthday'])) {
				$fetch['birth'] = explode('-', $fetch['birthday']);
				$fetch['birth'] = array(
					'date' => $fetch['birth'][0],
					'month' => $fetch['birth'][1],
					'year' => $fetch['birth'][2]
				);
			}
			
			if ($this->data['avatar_id'] == 0) {
				$fetch['thumbnail_url'] = $fetch['avatar_url'] = THEME_URL . '/images/default-male-avatar.png';
				
				if (! empty($fetch['gender'])) {
					
					if ($fetch['gender'] == "female") {
						$fetch['thumbnail_url'] = $fetch['avatar_url'] = THEME_URL . '/images/default-female-avatar.png';
					}
				}
			}
			
			return $fetch;
		}
	}

	private function getPageData() {
		$query = $this->getConnection()->query("SELECT * FROM " . DB_PAGES . " WHERE id=" . $this->id);
		
		if ($query->num_rows === 1) {
			$fetch = $query->fetch_array(MYSQLI_ASSOC);
			
			if ($this->data['avatar_id'] == 0) {
				$fetch['thumbnail_url'] = $fetch['avatar_url'] = THEME_URL . '/images/default-page-avatar.png';
			}
			
			return $fetch;
		}
	}

	private function getGroupData() {
		$query = $this->getConnection()->query("SELECT * FROM " . DB_GROUPS . " WHERE id=" . $this->id);
		
		if ($query->num_rows === 1) {
			$fetch = $query->fetch_array(MYSQLI_ASSOC);
			$fetch['thumbnail_url'] = $fetch['avatar_url'] = THEME_URL . '/images/default-group-avatar.png';
			
			return $fetch;
		}
	}

	private function getNames() {
		$nameBreak = explode(' ', $this->data['name']);
		$this->data['first_name'] = $nameBreak[0];
		$this->data['last_name'] = $nameBreak[count($nameBreak)-1];
	}

	private function getOnline() {
		$this->data['online'] = (isLogged() && $this->data['last_logged'] > (time()-15)) ? true : false;
	}

	public function getFollowRequests($searchQ='')
	{
		$get = array();
		$queryText = "SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT follower_id FROM " . DB_FOLLOWERS . " WHERE follower_id<>" . $this->id . " AND following_id=" . $this->id . " AND active=0) AND type='user' AND active=1";

		if (! empty($searchQ))
		{
			$queryText .= " AND name LIKE '%$searchQ%'";
		}

		$queryText .= " ORDER BY name ASC";
		$query = $this->getConnection()->query($queryText);
		
		while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
		{
			$get[] = $fetch['id'];
		}
		
		return $get;
	}

	public function getFollowings($searchQ='')
	{
		$get = array();
		$queryText = "SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $this->id . " AND following_id<>" . $this->id . " AND active=1) AND type='user' AND active=1";

		if (! empty($searchQ))
		{
			$queryText .= " AND name LIKE '%$searchQ%'";
		}

		$queryText .= " ORDER BY name ASC";
		$query = $this->getConnection()->query($queryText);
		
		while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
		{
			$get[] = $fetch['id'];
		}
		
		return $get;
	}

	public function getFollowers($searchQ='')
	{
		$get = array();
		$queryText = "SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT follower_id FROM " . DB_FOLLOWERS . " WHERE follower_id<>" . $this->id . " AND following_id=" . $this->id . " AND active=1) AND type='user' AND active=1";
		
		if (! empty($searchQ))
		{
			$queryText .= " AND name LIKE '%$searchQ%'";
		}

		$queryText .= " ORDER BY name ASC";
		$query = $this->getConnection()->query($queryText);
		
		while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
		{
			$get[] = $fetch['id'];
		}
		
		return $get;
	}

	public function getLikedPages($searchQ='')
	{
		$get = array();
		$queryText = "SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $this->id . " AND following_id<>" . $this->id . " AND active=1) AND type='page' AND active=1";
		
		if (! empty($searchQ))
		{
			$queryText .= " AND name LIKE '%$searchQ%'";
		}

		$queryText .= " ORDER BY name ASC";
		$query = $this->getConnection()->query($queryText);
		
		while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
		{
			$get[] = $fetch['id'];
		}
		
		return $get;
	}

	public function getGroupsJoined($searchQ='')
	{
		$get = array();
		$queryText = "SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $this->id . " AND following_id<>" . $this->id . " AND active=1) AND type='group' AND active=1";
		
		if (! empty($searchQ))
		{
			$queryText .= " AND name LIKE '%$searchQ%'";
		}

		$queryText .= " ORDER BY name ASC";
		$query = $this->getConnection()->query($queryText);
		
		while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
		{
			$get[] = $fetch['id'];
		}
		
		return $get;
	}

	public function getPageAdmins($searchQ='')
	{
		$get = false;
		$queryText = "SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT admin_id FROM " . DB_PAGE_ADMINS . " WHERE page_id=" . $this->id . " AND active=1) AND active=1";
		
		if (! empty($searchQ))
		{
			$queryText .= " AND name LIKE '%$searchQ%'";
		}

		$query = $this->getConnection()->query($queryText);
		
		if ($query->num_rows > 0)
		{
			$get = array();

			while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
			{
				$get[] = $fetch['id'];
			}
		}
		
		return $get;
	}

	public function getGroupAdmins($searchQ='')
	{
		$get = array();
		$queryText = "SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT admin_id FROM " . DB_GROUP_ADMINS . " WHERE group_id=" . $this->id . " AND active=1) AND active=1";
		
		if (! empty($searchQ))
		{
			$queryText .= " AND name LIKE '%$searchQ%'";
		}

		$query = $this->getConnection()->query($queryText);
		
		while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
		{
			$get[] = $fetch['id'];
		}
		
		return $get;
	}

	public function getMessageRecipients($searchQuery='', $new=false)
	{
	    $searchQuery = $this->escapeObj->stringEscape($searchQuery);
	    $get = array();
	    $excludes = array();
	    $excludesNum = 0;
	    
	    if (! empty($searchQuery))
	    {
	        $queryText = "SELECT DISTINCT id FROM " . DB_ACCOUNTS . " WHERE (id IN (SELECT timeline_id FROM " . DB_MESSAGES . " WHERE recipient_id=" . $this->id . " AND active=1";
	        
	        if ($new == true)
	        {
	            $queryText .= " AND seen=0";
	        }
	        
	        $queryText .= " ORDER BY id DESC)";
	        
	        if ($new == false)
	        {
	            $queryText .= " OR id IN (SELECT recipient_id FROM " . DB_MESSAGES . " WHERE timeline_id=" . $this->id . " AND active=1 ORDER BY id DESC)";
	        }
	        
	        $queryText .= ") AND id<>" . $this->id . " AND active=1 AND name LIKE '%$searchQuery%'";
	    }
	    else
	    {
	        $queryText = "SELECT DISTINCT id FROM " . DB_ACCOUNTS . " WHERE (id IN (SELECT timeline_id FROM " . DB_MESSAGES . " WHERE recipient_id=" . $this->id . " AND active=1";
	        
	        if ($new == true)
	        {
	            $queryText .= " AND seen=0";
	        }
	        
	        $queryText .= " ORDER BY id DESC)";
	        
	        if ($new == false)
	        {
	            $queryText .= " OR id IN (SELECT recipient_id FROM " . DB_MESSAGES . " WHERE timeline_id=" . $this->id . " AND active=1 ORDER BY id DESC)";
	        }
	        
	        $queryText .= ") AND active=1";
	    }

	    $query = $this->getConnection()->query($queryText);
	    
	    if ($query->num_rows > 0)
	    {
	        while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
	        {
	            $timelineObj = new \miuan\User();
	            $timelineObj->setId($fetch['id']);
	            $get[] = $timelineObj->getRows();
	            $excludes[] = $fetch['id'];
	            $excludesNum++;
	        }
	    }
	    
	    $excludeQueryString = 0;
	    $exclude_i = 0;
	    
	    if ($excludesNum > 0)
	    {
	        $excludeQueryString = '';
	        
	        foreach ($excludes as $exclude)
	        {
	            $exclude_i++;
	            $excludeQueryString .= $exclude;
	            
	            if ($exclude_i != $excludesNum)
	            {
	                $excludeQueryString .= ',';
	            }
	        }
	    }
	    
	    $query2Text = "SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $this->id . " AND following_id NOT IN (" . $this->id . ",$excludeQueryString) AND following_id IN (SELECT id FROM " . DB_USERS . ") AND active=1) AND active=1";
	    
	    if (! empty($searchQuery))
	    {
	        $query2Text .= " AND name LIKE '%$searchQuery%'";
	    }
	    
	    $query2 = $this->getConnection()->query($query2Text);
	    
	    while ($fetch2 = $query2->fetch_array(MYSQLI_ASSOC))
	    {
	        $timelineObj = new \miuan\User();
	        $timelineObj->setId($fetch2['id']);
	        $get[] = $timelineObj->getRows();
	    }
	    
	    return $get;
	}

	public function getAlbums($limit=0)
	{
		$limit = (int) $limit;
		$get = array();
		$queryText = "SELECT id,name,descr FROM " . DB_MEDIA . " WHERE timeline_id=" . $this->id . " AND type='album' AND temp=0 AND active=1";

		if ($limit > 0)
		{
			$queryText .= " LIMIT $limit";
		}

		$query = $this->getConnection()->query($queryText);

		while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
		{
			$get[] = $fetch;
		}

		return $get;
	}

	public function putFollow($followingId=0)
	{
		if (! isLogged())
		{
			return false;
		}
		
		global $config, $lang, $user;
		
		$followingId = (int) $followingId;
		
		if ($followingId < 1)
	    {
	        $followingId = $user['id'];
	        $userObj = new \miuan\User($this->getConnection());
	    	$userObj->setId($followingId);
	    	$following = $userObj->getRows();
	    }
	    else
	    {
	        $followingObj = new \miuan\User();
	        $followingObj->setId($followingId);
	        $following = $followingObj->getRows();
	    }
		
		if (! isset($following['id']))
		{
			return false;
		}
		
		if ($this->isFollowedBy($followingId))
		{
			return false;
		}

		$active = 1;
		$canFollow = true;
		
		if ($this->data['type'] == "user" && $this->data['follow_privacy'] == "following" && ! $this->isFollowing())
		{
			$canFollow = false;
		}
		
		if ($this->data['type'] == "user" && $this->data['confirm_followers'] == 1)
		{
			$active = 0;
		}

		if ($config['friends'] == true)
		{
			$active = 0;
		}

		if ($this->data['type'] == "page")
		{
			$active = 1;
		}

		if ($this->data['type'] == "group")
		{
			if ($this->data['group_privacy'] == "open")
			{
				$active = 1;
			}
			elseif ($this->data['group_privacy'] == "closed")
			{
				if ($this->isGroupAdmin())
				{
					$active = 1;
				}
				else
				{
					$active = 0;
				}
			}
			elseif ($this->data['group_privacy'] == "secret")
			{
				if ($this->isGroupAdmin())
				{
					$active = 1;
				}
				else
				{
					return false;
				}
			}
		}
		
		if ($canFollow == true)
		{
			$query = $this->getConnection()->query("INSERT INTO " . DB_FOLLOWERS . " (active,follower_id,following_id,time) VALUES ($active,$followingId," . $this->id . "," . time() . ")");
			
			if ($query)
			{
				if ($following['type'] == "user")
				{
					if ($this->data['type'] == "user")
					{
						if ($active == 1)
						{
							$this->putNotification('follow', $followingId);

							if ($this->data['mailnotif_follow'] == true)
							{
								global $themeData;
							    $themeData['followers_url'] = smoothLink('index.php?tab1=timeline&tab2=followers&id=' . $this->data['username']);
							    $themeData['mail_recipient_name'] = $this->data['name'];
							    $themeData['mail_generator_url'] = $following['url'];
							    $themeData['mail_generator_name'] = $following['name'];
							    
							    $subject = $config['site_name'];
								$subject .= " | ";
							    $subject .= str_replace("{user}", $following['name'] . " (@" . $following['username'] . ")", $lang['new_follower_email_subject']);

							    $message = \miuan\UI::view('emails/notifications/new-follower');
							    send_mail($this->data['email'], $subject, $message);
							}
						}
						elseif ($config['friends'] == true && $this->data['mailnotif_friendrequests'] == true)
						{
							global $themeData;
						    $themeData['friend_requests_url'] = smoothLink('index.php?tab1=timeline&tab2=requests&id=' . $this->data['username']);
						    $themeData['mail_recipient_name'] = $this->data['name'];
						    $themeData['mail_generator_url'] = $following['url'];
						    $themeData['mail_generator_name'] = $following['name'];
						    
						    $subject = $config['site_name'];
							$subject .= " | ";
						    $subject .= str_replace("{user}", $following['name'] . " (@" . $following['username'] . ")", $lang['new_friend_request_email_subject']);

						    $message = \miuan\UI::view('emails/notifications/new-friend-request');
						    
						    send_mail($this->data['email'], $subject, $message);
						}
					}
					elseif ($this->data['type'] == "page")
					{
						global $themeData;
						$themeData['page_url'] = $this->data['url'];
						$themeData['page_name'] = $this->data['name'];
						$pageAdmins = $this->getPageAdmins();

						if (is_array($pageAdmins))
						{
							foreach ($this->getPageAdmins() as $adminId)
							{
								if ($adminId != $followingId)
								{
									$pageAdminObj = new \miuan\User();
									$pageAdminObj->setId($adminId);
									$pageAdmin = $pageAdminObj->getRows();

									$this->putNotification('pagelike', $followingId, $adminId);

									if ($pageAdmin['mailnotif_pagelike'] == true)
									{
										$subject = $config['site_name'];
										$subject .= " | ";
										$subject .= str_replace("{user}", $following['name'] . " (@" . $following['username'] . ")", $lang['new_pagelike_email_subject']);

										$themeData['mail_recipient_name'] = $pageAdmin['name'];
							    		$themeData['mail_generator_url'] = $following['url'];
							    		$themeData['mail_generator_name'] = $following['name'];

										$message = \miuan\UI::view('emails/notifications/new-page-like');
							    		send_mail($pageAdmin['email'], $subject, $message);
									}
								}
							}
						}
					}
					elseif ($this->data['type'] == "group")
					{
						global $themeData;
						$themeData['group_url'] = $this->data['url'];
						$themeData['group_name'] = $this->data['name'];

						foreach ($this->getGroupAdmins() as $adminId)
						{
							if ($adminId != $followingId)
							{
								$groupAdminObj = new \miuan\User();
								$groupAdminObj->setId($adminId);
								$groupAdmin = $groupAdminObj->getRows();

								if ($active == 1)
						    	{
									$this->putNotification('groupjoin', $followingId, $adminId);
								}
								else
								{
									$this->putNotification('grouprequest', $followingId, $adminId);
								}

								if ($groupAdmin['mailnotif_groupjoined'] == true)
								{
									$subject = $config['site_name'];
									$subject .= " | ";
									$subject .= str_replace("{user}", $following['name'] . " (@" . $following['username'] . ")", $lang['new_groupmember_email_subject']);

									$themeData['mail_recipient_name'] = $groupAdmin['name'];
						    		$themeData['mail_generator_url'] = $following['url'];
						    		$themeData['mail_generator_name'] = $following['name'];

						    		if ($active == 1)
						    		{
						    			$message = \miuan\UI::view('emails/notifications/new-group-member');
						    		}
						    		else
						    		{
						    			$message = \miuan\UI::view('emails/notifications/new-group-request');
						    			
						    			$subject = $config['site_name'];
										$subject .= " | ";
										$subject .= str_replace("{user}", $following['name'] . " (@" . $following['username'] . ")", $lang['new_grouprequest_email_subject']);
						    		}
									
						    		send_mail($groupAdmin['email'], $subject, $message);
								}
							}
						}
					}
				}
				
				return true;
			}
		}
	}

	public function putNotification($a='')
    {
        if (! isLogged())
        {
            return false;
        }
        
        $lang = array();
		$langQuery = $this->getConnection()->query("SELECT keyword,text FROM " . DB_LANGUAGES . " WHERE type='" . $this->data['language'] . "'");
		
		while($langFetch = $langQuery->fetch_array(MYSQLI_ASSOC))
		{
			$lang[$langFetch['keyword']] = $langFetch['text'];
		}

        global $user;

        if ($a == "follow")
        {
        	$followingId = (int) func_get_arg(1);

	        if ($followingId < 1)
	        {
	        	return false;
	        }

	        $count = $this->numFollowers();
	        $text = '';
	        
	        if ($count > 1)
	        {
	            $text .= str_replace('{count}', ($count-1), $lang['following_you_plural']);
	        }
	        else
	        {
	            $text .= $lang['following_you_singular'];
	        }
	        
	        $query = $this->getConnection()->query("SELECT id FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $this->id . " AND notifier_id=$followingId AND post_id=0 AND type='following' AND active=1");
	        
	        if ($query->num_rows > 0)
	        {
	            $this->getConnection()->query("DELETE FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $followingId . " AND notifier_id=$followingId AND post_id=0 AND type='following' AND active=1");
	        }

	        $this->getConnection()->query("INSERT INTO " . DB_NOTIFICATIONS . " (timeline_id,active,notifier_id,post_id,text,time,type,url) VALUES (" . $this->id . ",1," . $followingId . ",0,'$text'," . time() . ",'following','index.php?tab1=timeline&tab2=followers&id=" . $this->id . "')");
	        return true;
        }
        elseif ($a == "pagelike")
        {
        	$followingId = (int) func_get_arg(1);
        	$adminId = (int) func_get_arg(2);

	        if ($followingId < 1)
	        {
	        	return false;
	        }

	        if ($adminId < 1)
	        {
	        	return false;
	        }

	        $followingObj = new \miuan\User();
	        $followingObj->setId($followingId);
	        $following = $followingObj->getRows();

	        $adminObj = new \miuan\User();
	        $adminObj->setId($adminId);
	        $admin = $adminObj->getRows();

	        $text = $lang['liked_your_page'];
	        $text = str_replace('{user}', $following['name'], $text);
	        $text = str_replace('{page}', $this->data['name'], $text);

	        $query = $this->getConnection()->query("SELECT id FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=$adminId AND notifier_id=$followingId AND post_id=0 AND type='pagelike' AND active=1");
	        
	        if ($query->num_rows > 0)
	        {
	            $this->getConnection()->query("DELETE FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=$adminId AND notifier_id=$followingId AND post_id=0 AND type='pagelike' AND active=1");
	        }

	        $this->getConnection()->query("INSERT INTO " . DB_NOTIFICATIONS . " (timeline_id,active,notifier_id,post_id,text,time,type,url) VALUES ($adminId,1,$followingId,0,'$text'," . time() . ",'pagelike','index.php?tab1=timeline&id=" . $this->id . "')");
	        return true;
        }
        elseif ($a == "groupjoin")
        {
        	$followingId = (int) func_get_arg(1);
        	$adminId = (int) func_get_arg(2);

	        if ($followingId < 1)
	        {
	        	return false;
	        }

	        if ($adminId < 1)
	        {
	        	return false;
	        }

	        $followingObj = new \miuan\User();
	        $followingObj->setId($followingId);
	        $following = $followingObj->getRows();

	        $adminObj = new \miuan\User();
	        $adminObj->setId($adminObj);
	        $admin = $adminObj->getRows();

	        $text = $lang['joined_your_group'];
	        $text = str_replace('{user}', $following['name'], $text);
	        $text = str_replace('{group}', $this->data['name'], $text);

	        $query = $this->getConnection()->query("SELECT id FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=$adminId AND notifier_id=$followingId AND post_id=0 AND type='groupjoin' AND active=1");
	        
	        if ($query->num_rows > 0)
	        {
	            $this->getConnection()->query("DELETE FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=$adminId AND notifier_id=$followingId AND post_id=0 AND type='groupjoin' AND active=1");
	        }

	        $this->getConnection()->query("INSERT INTO " . DB_NOTIFICATIONS . " (timeline_id,active,notifier_id,post_id,text,time,type,url) VALUES ($adminId,1,$followingId,0,'$text'," . time() . ",'groupjoin','index.php?tab1=timeline&id=" . $this->id . "')");
	        return true;
        }
        elseif ($a == "grouprequest")
        {
        	$followingId = (int) func_get_arg(1);
        	$adminId = (int) func_get_arg(2);

	        if ($followingId < 1)
	        {
	        	return false;
	        }

	        if ($adminId < 1)
	        {
	        	return false;
	        }

	        $followingObj = new \miuan\User();
	        $followingObj->setId($followingId);
	        $following = $followingObj->getRows();

	        $adminObj = new \miuan\User();
	        $adminObj->setId($adminObj);
	        $admin = $adminObj->getRows();

	        $text = $lang['requested_to_join_your_group'];
	        $text = str_replace('{user}', $following['name'], $text);
	        $text = str_replace('{group}', $this->data['name'], $text);

	        $query = $this->getConnection()->query("SELECT id FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=$adminId AND notifier_id=$followingId AND post_id=0 AND type='grouprequest' AND active=1");
	        
	        if ($query->num_rows > 0)
	        {
	            $this->getConnection()->query("DELETE FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=$adminId AND notifier_id=$followingId AND post_id=0 AND type='grouprequest' AND active=1");
	        }

	        $this->getConnection()->query("INSERT INTO " . DB_NOTIFICATIONS . " (timeline_id,active,notifier_id,post_id,text,time,type,url) VALUES ($adminId,1,$followingId,0,'$text'," . time() . ",'grouprequest','index.php?tab1=timeline&id=" . $this->id . "')");
	        return true;
        }
    }

    public function removeFollow($fid=0)
	{
	    if (! isLogged())
	    {
	        return false;
	    }
	    
	    global $config;
	    $fid = (int) $fid;

	    if ($fid < 1)
	    {
	        global $user, $userObj;
	        $fid = $user['id'];
	        $followingObj = $userObj;
	        $following = $user;
	    }
	    else
	    {
	        $followingObj = new \miuan\User();
	        $followingObj->setId($fid);
	        $following = $followingObj->getRows();
	    }

	    $active = 1;
	    
	    if (! isset($following['id']))
	    {
	        return false;
	    }
	    
	    if ($this->data['type'] == "user" && $this->data['confirm_followers'] == 1)
	    {
	        $active = 0;
	    }
	    elseif ($this->data['type'] == "group" && $this->data['group_privacy'] == "closed")
	    {
	        $active = 0;
	    }
	    
	    $query = $this->getConnection()->query("DELETE FROM " . DB_FOLLOWERS . " WHERE follower_id=$fid AND following_id=" . $this->id);

	    if ($config['friends'] == true)
	    {
	        $query2 = $this->getConnection()->query("DELETE FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $this->id . " AND following_id=$fid");
	    }
	    
	    if ($this->data['type'] == "group" && $this->isGroupAdmin())
	    {
	        if ($this->numGroupAdmins() > 1)
	        {
	            $query3 = $this->getConnection()->query("DELETE FROM " . DB_GROUP_ADMINS . " WHERE admin_id=$fid AND group_id=" . $this->id);
	        }
	    }
	    
	    return true;
	}

	/* Template methods */
	public function getFollowButton()
	{
		if (! isLogged())
		{
			return false;
		}
		
		global $user, $config, $themeData;
		$themeData['follow_id'] = $this->id;

		if ($this->id == $user['id'])
		{
			return false;
		}
		
		if ($config['friends'] == true)
		{
			switch ($this->data['type'])
			{
				case 'user':
					$follow_button = 'global/buttons/add_as_friend';
					$unfollow_button = 'global/buttons/unfriend';
					$request_button = 'global/buttons/request-sent';
				break;
				
				case 'page':
					$follow_button = 'global/buttons/like';
					$unfollow_button = 'global/buttons/unlike';
					$request_button = 'global/buttons/request-sent';
				break;
				
				case 'group':
					$follow_button = 'global/buttons/join';
					$unfollow_button = 'global/buttons/leave';
					$request_button = 'global/buttons/request-sent';
				break;
			}
		}
		else
		{
			switch ($this->data['type'])
			{
				case 'user':
					$follow_button = 'global/buttons/follow';
					$unfollow_button = 'global/buttons/unfollow';
					$request_button = 'global/buttons/request-sent';
				break;
				
				case 'page':
					$follow_button = 'global/buttons/like';
					$unfollow_button = 'global/buttons/unlike';
					$request_button = 'global/buttons/request-sent';
				break;
				
				case 'group':
					$follow_button = 'global/buttons/join';
					$unfollow_button = 'global/buttons/leave';
					$request_button = 'global/buttons/request-sent';
				break;
			}
		}
		
		if ($this->isFollowedBy())
		{
			return \miuan\UI::view($unfollow_button);
		}
		else
		{
			if ($this->isFollowRequested())
			{
				return \miuan\UI::view($request_button);
			}
			else
			{
				if ($this->data['type'] == "user")
				{
					if ($this->data['follow_privacy'] == "following")
					{
						if ($this->isFollowedBy())
						{
							return \miuan\UI::view($follow_button);
						}
					}
					elseif ($this->data['follow_privacy'] == "everyone")
					{
						return \miuan\UI::view($follow_button);
					}
				}
				elseif ($this->data['type'] == "page")
				{
					return \miuan\UI::view($follow_button);
				}
				elseif ($this->data['type'] == "group")
				{
					return \miuan\UI::view($follow_button);
				}
			}
		}
	}

	public function getAlbumsTemplate()
	{
		global $themeData;
		$listAlbums = '';
		
		foreach ($this->getAlbums() as $album)
		{
			$themeData['list_album_id'] = $album['id'];
			$themeData['list_album_url'] = smoothLink('index.php?tab1=album&tab2=' . $album['id']);
			$themeData['list_album_name'] = $album['name'];

			$listAlbums .= \miuan\UI::view('timeline/user/list-album-each');
		}

		if (empty($listAlbums))
		{
			$themeData['list_albums'] = '<div class="list-column">No albums to show</div>';
		}
		else
		{
			$themeData['list_albums'] = $listAlbums;
		}
		
		return \miuan\UI::view('timeline/user/sidebar-albums');
	}
}
