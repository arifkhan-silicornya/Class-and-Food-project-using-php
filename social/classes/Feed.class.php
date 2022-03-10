<?php

namespace miuan;

class Feed
{
	use \SocialTrait\Escape;

	private $conn;
	private $type = "all";
	private $afterId = 0;
	private $beforeId = 0;
	private $timelineId = 0;
    private $timelineObj;
	private $limit = 5;
	private $startRow = 0;
	private $excludeActivity = false;
	private $timeline = array();
    private $data;

	function __construct()
    {
        global $conn;
        $this->conn = $conn;
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

	public function getFeed()
    {
		$query = $this->getStartQuery();
	    
	    if ($this->timelineId > 0)
        {
            $timelineQuery = $this->getTimelineQuery();

            if (empty($timelineQuery))
            {
                $this->data = array();
                return $this->data;
            }

	        $query .= $timelineQuery;
	    }
        else
        {
	    	$query .= $this->getDefaultQuery();
	    }
	    
	    if ($this->startRow < 1)
        {
                $this->startRow = 0;
        }

	    if ($this->limit < 1)
        {
	        $this->limit = 5;
	    }
	    
	    $query .= $this->getEndQuery();
	    
	    if (! empty($query))
        {
	        $sql_query = $this->getConnection()->query($query);
	        
            if ($sql_query->num_rows == 0)
            {
                $this->data = array();
            }
            else
            {
                while ($sql_fetch = $sql_query->fetch_array(MYSQLI_ASSOC))
                {
                    $this->data[] = $sql_fetch['id'];
                }
            }
	    }
	    
	    return $this->data;
	}

	private function getStartQuery()
    {
		$query = "SELECT DISTINCT p.post_id AS id FROM " . DB_POSTS . " p";
	    return $query;
	}

    private function getEndQuery()
    {
        $partQuery = " AND p.id>0";
        
        if ($this->afterId > 0)
        {
            $partQuery = " AND p.id<" . $this->afterId;
        }
        elseif ($this->beforeId > 0)
        {
            $partQuery = " AND p.id>" . $this->beforeId . " AND p.post_id<>" . $this->beforeId;
        }

        $query = $partQuery;
        
        if ($this->startRow < 1)
        {
            $this->startRow = 0;
        }
        
        if ($this->limit < 1)
        {
            $this->limit = 5;
        }

        $query .= " AND p.active=1 ORDER BY p.id DESC LIMIT " . $this->startRow . "," . $this->limit;
        return $query;
    }

	private function getDefaultQuery()
    {
		if (! isLogged())
        {
            return false;
        }

        global $user;
        $query = '';

        switch ($this->type)
        {
            case 'texts':
                $query = " WHERE ((timeline_id IN (SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . " AND active=1) AND active=1) OR timeline_id=" . $user['id'] . ")
                    OR recipient_id IN (SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . "
                        AND following_id IN (SELECT id FROM " . DB_GROUPS . ")
                    ) AND active=1))
                    AND recipient_id NOT IN (SELECT id FROM " . DB_GROUPS . " WHERE group_privacy='secret')
                    AND hidden=0
                    AND google_map_name=''
                    AND media_id=0
                    AND soundcloud_uri=''
                    AND youtube_video_id=''";
            break;
            
            case 'photos':
                $query = " WHERE ((timeline_id IN (SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . " AND active=1) AND active=1) OR timeline_id=" . $user['id'] . ")
                    OR recipient_id IN (SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . "
                        AND following_id IN (SELECT id FROM " . DB_GROUPS . ")
                    ) AND active=1))
                    AND recipient_id NOT IN (SELECT id FROM " . DB_GROUPS . " WHERE group_privacy='secret')
                    AND hidden=0
                    AND media_id>0";
            break;
            
            case 'videos':
                $query = " WHERE ((timeline_id IN (SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . " AND active=1) AND active=1) OR timeline_id=" . $user['id'] . ")
                    OR recipient_id IN (SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . "
                        AND following_id IN (SELECT id FROM " . DB_GROUPS . ")
                    ) AND active=1))
                    AND recipient_id NOT IN (SELECT id FROM " . DB_GROUPS . " WHERE group_privacy='secret')
                    AND hidden=0
                    AND youtube_video_id<>''";
            break;
            
            case 'music':
                $query = " WHERE ((timeline_id IN (SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . " AND active=1) AND active=1) OR timeline_id=" . $user['id'] . ")
                    OR recipient_id IN (SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . "
                        AND following_id IN (SELECT id FROM " . DB_GROUPS . ")
                    ) AND active=1))
                    AND recipient_id NOT IN (SELECT id FROM " . DB_GROUPS . " WHERE group_privacy='secret')
                    AND hidden=0
                    AND soundcloud_uri<>''";
            break;
            
            case 'places':
                $query = " WHERE ((timeline_id IN (SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . " AND active=1) AND active=1) OR timeline_id=" . $user['id'] . ")
                    OR recipient_id IN (SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . "
                        AND following_id IN (SELECT id FROM " . DB_GROUPS . ")
                    ) AND active=1))
                    AND recipient_id NOT IN (SELECT id FROM " . DB_GROUPS . " WHERE group_privacy='secret')
                    AND hidden=0
                    AND google_map_name<>''";
            break;
            
            case 'likes':
                $query = " WHERE id IN (SELECT post_id FROM " . DB_POSTLIKES . ")
                    AND ((timeline_id IN (SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . " AND active=1) AND active=1) OR timeline_id=" . $user['id'] . ")
                    OR recipient_id IN (SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . "
                        AND following_id IN (SELECT id FROM " . DB_GROUPS . ")
                    ) AND active=1))
                    AND recipient_id NOT IN (SELECT id FROM " . DB_GROUPS . " WHERE group_privacy='secret')
                    AND hidden=0";
            break;
            
            case 'shares':
                $query = " WHERE ((timeline_id IN (SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . " AND active=1) AND active=1) OR timeline_id=" . $user['id'] . ")
                    OR recipient_id IN (SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . "
                        AND following_id IN (SELECT id FROM " . DB_GROUPS . ")
                    ) AND active=1))
                    AND recipient_id NOT IN (SELECT id FROM " . DB_GROUPS . " WHERE group_privacy='secret')
                    AND hidden=0";
            break;
            
            default:
                $query = " WHERE ((timeline_id IN (SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . " AND active=1) AND active=1) OR timeline_id=" . $user['id'] . ")
                    OR recipient_id IN (SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . "
                        AND following_id IN (SELECT id FROM " . DB_GROUPS . ")
                    ) AND active=1))
                    AND recipient_id NOT IN (SELECT id FROM " . DB_GROUPS . " WHERE group_privacy='secret')
                    AND hidden=0";
        }
        
        return $query;
	}

	private function getTimelineQuery()
    {
		$query = '';
        $this->timelineObj = new \miuan\User();
        $this->timelineObj->setId($this->timelineId);
		$this->timeline = $this->timelineObj->getRows();

        if ($this->timeline['type'] == "user")
        {
        	$query = $this->getTimelineUserQuery();
        }
        elseif ($this->timeline['type'] == "page")
        {
            $query = $this->getTimelinePageQuery();
        }
        elseif ($this->timeline['type'] == "group")
        {
            $query = $this->getTimelineGroupQuery();
        }

        return $query;
	}

	private function getTimelineUserQuery()
    {
        $query = '';

        switch ($this->type)
        {
            case 'texts':
                $query = " WHERE timeline_id=" . $this->timelineId . " AND recipient_id IN (0," . $this->timelineId . ") AND google_map_name='' AND media_id=0 AND soundcloud_uri='' AND youtube_video_id='' AND hidden=0";
            break;
            
            case 'photos':
                $query = " WHERE timeline_id=" . $this->timelineId . " AND recipient_id=0 AND media_id>0 AND hidden=0";
            break;
            
            case 'videos':
                $query = " WHERE timeline_id=" . $this->timelineId . " AND recipient_id=0 AND youtube_video_id<>'' AND hidden=0";
            break;
            
            case 'music':
                $query = " WHERE timeline_id=" . $this->timelineId . " AND recipient_id=0 AND soundcloud_uri<>'' AND hidden=0";
            break;
            
            case 'places':
                $query = " WHERE timeline_id=" . $this->timelineId . " AND recipient_id=0 AND google_map_name<>'' AND hidden=0";
            break;
            
            case 'likes':
                $query = " WHERE timeline_id=" . $this->timelineId . " AND recipient_id=0 AND hidden=0 AND id IN (SELECT post_id FROM " . DB_POSTLIKES . ")";
            break;
            
            case 'shares':
                $query = " WHERE timeline_id=" . $this->timelineId . " AND recipient_id=0 AND hidden=0";
            break;
            
            case 'timeline_post_by_others':
                $query = " WHERE recipient_id=" . $this->timelineId . " AND hidden=0";
            break;
            
            default:
                $query = " WHERE (p.timeline_id=" . $this->timelineId . " OR p.recipient_id=" . $this->timelineId . ") AND p.recipient_id NOT IN (SELECT id FROM " . DB_GROUPS . " WHERE group_privacy='secret') AND hidden=0";
        }

        return $query;
	}

	private function getTimelinePageQuery()
    {
		$query = '';

		switch ($this->type)
        {
            case 'texts':
                $query = " WHERE timeline_id=" . $this->timelineId . " AND google_map_name='' AND media_id=0 AND soundcloud_uri='' AND youtube_video_id='' AND hidden=0";
            break;
            
            case 'photos':
                $query = " WHERE timeline_id=" . $this->timelineId . " AND media_id>0 AND hidden=0";
            break;
            
            case 'videos':
                $query = " WHERE timeline_id=" . $this->timelineId . " AND youtube_video_id<>'' AND hidden=0";
            break;
            
            case 'music':
                $query = " WHERE timeline_id=" . $this->timelineId . " AND soundcloud_uri<>'' AND hidden=0";
            break;
            
            case 'places':
                $query = " WHERE timeline_id=" . $this->timelineId . " AND google_map_name<>'' AND hidden=0";
            break;
            
            case 'timeline_post_by_others':
                $query = " WHERE recipient_id=" . $this->timelineId . " AND hidden=0";
            break;
            
            default:
                $query = " WHERE (timeline_id=" . $this->timelineId . " OR recipient_id=" . $this->timelineId . ") AND hidden=0";
        }

        return $query;
	}

	private function getTimelineGroupQuery()
    {
		$query = '';

		switch ($this->type)
        {
            case 'texts':
                $query = " WHERE recipient_id=" . $this->timelineId . " AND google_map_name='' AND media_id=0 AND soundcloud_uri='' AND youtube_video_id='' AND hidden=0";
            break;
            
            case 'photos':
                $query = " WHERE recipient_id=" . $this->timelineId . " AND media_id>0 AND hidden=0";
            break;
            
            case 'videos':
                $query = " WHERE recipient_id=" . $this->timelineId . " AND youtube_video_id<>'' AND hidden=0";
            break;
            
            case 'music':
                $query = " WHERE recipient_id=" . $this->timelineId . " AND soundcloud_uri<>'' AND hidden=0";
            break;
            
            case 'places':
                $query = " WHERE recipient_id=" . $this->timelineId . " AND google_map_name<>'' AND hidden=0";
            break;
            
            default:
                $query = " WHERE recipient_id=" . $this->timelineId . " AND hidden=0";
        }

        return $query;
	}

	public function setType($t) {
		$this->type = $this->postEscape($t, 'all');
	}

	public function setAfterId($id) {
		$this->afterId = (int) $id;
	}

	public function setBeforeId($id) {
		$this->beforeId = (int) $id;
	}

	public function setTimelineId($id) {
		$this->timelineId = (int) $id;
	}

	public function setLimit($l) {
		$this->limit = (int) $l;
	}
	
	public function setStart($l) {
		$this->startRow = (int) $l;
	}

	public function setExclude($b) {
		$this->excludeActivity = (bool) $b;
	}

    public function getTemplate() {

        if (! is_array($this->data)) {
            $this->getFeed();
        }

        global $themeData;
        $storyList = '';

        foreach ($this->data as $storyId)
        {
            $storyObj = new \miuan\Story();
            $storyObj->setConnection($this->getConnection());
            $storyObj->setId($storyId);
            
            if ($this->timelineId > 0)
            {
                $storyObj->setProfileId($this->timelineId);
            }

            $storyList .= $storyObj->getTemplate();
        }

        $themeData['story_timeline_id'] = $this->timelineId;
        $themeData['story_list'] = $storyList;
        return \miuan\UI::view('feed/content');
    }
}