<?php

namespace miuan;

class Escape
{
	use \SocialTrait\Escape;

	private $conn;
	private $string;

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

	protected function getConnection ()
	{
		return $this->conn;
	}

	public function createLinks ($content)
	{
		$link_regex = '/(http\:\/\/|https\:\/\/|www\.)([^\ ]+)/i';
	    preg_match_all($link_regex, $content, $matches);
	    
	    foreach ($matches[0] as $url)
	    {
	        $matchUrl = strip_tags($url);
	        $bbcode = '[a]' . urlencode($matchUrl) . '[/a]';
	        $content = str_replace($url, $bbcode, $content);
	    }

	    return $content;
	}

	public function createHashtags ($content)
	{
		$hashtag_regex = '/#([^`~!@$%^&*\#()\-+=\\|\/\.,<>?\'\":;{}\[\]* ]+)/i';
	    preg_match_all($hashtag_regex, $content, $matches);
	    
	    foreach ($matches[1] as $tag)
	    {
	        $hashdata = getHashtag($tag);
	        
	        if (is_array ($hashdata))
	        {
	            $matchSearch = '#' . $tag;
	            $matchPlace = '#[' . $hashdata['id'] . ']';
	            $content = str_replace($matchSearch, $matchPlace, $content);
	        }
	    }

	    return $content;
	}

	public function createMentions ($content)
	{
		$mention_regex = '/@([A-Za-z0-9_]+)/i';
		$mentions = array();
	    preg_match_all($mention_regex, $content, $matches);
	    
	    foreach ($matches[1] as $mention)
	    {
	        $mention = $this->postEscape($mention);
	        $userObj = new \miuan\User($this->getConnection());

	        if ($mentionId = getUserId($this->getConnection(), $mention))
	        {
	        	$userObj->setId($mentionId);
		        $user = $userObj->getRows();
		        
		        if (isset($user['id']))
		        {
		        	$matchSearch = '@' . $mention;
		        	$matchPlace = '@[' . $user['id'] . ']';

		            $content = str_replace($matchSearch, $matchPlace, $content);
		            $mentions[] = $user['id'];
		        }
	        }
	    }


	    return array(
	    	'content' => $content,
	    	'mentions' => $mentions
	    );
	}

	public function getEmoticons($content='')
	{
	    global $config, $emo;
	    $dir = str_replace(array('http://', 'https://'), '//', $config['site_url']);
	    $dir .= '/main/' . $config['theme'] . '/emoticons';
	    
	    foreach ($emo as $code => $img)
	    {
	        $code = $this->stringEscape($code);
	        $img = '<img src="' . $dir . '/' . $img . '" class="emoticon">';
	        $content = str_replace($code, $img, $content);
	    }
	    
	    
	    return $content;
	}

	public function getLinks($content)
	{
	    $link_search = '/\[a\](.*?)\[\/a\]/i';
        
        if (preg_match_all($link_search, $content, $matches))
        {
            foreach ($matches[1] as $match)
            {
                $match_decode = urldecode($match);
                $match_url = $match_decode;
                
                if (!preg_match("/http(|s)\:\/\//", $match_decode))
                {
                    $match_url = 'http://' . $match_url;
                }
                
                $content = str_replace('[a]' . $match . '[/a]', '<a href="' . strip_tags($match_url) . '" target="_blank" rel="nofollow" class="livepreview">' . $match_decode . '</a>', $content);
            }
        }
	    
	    return $content;
	}

	public function getHashtags($content)
	{
        $hashtag_regex = '/(#\[([0-9]+)\])/i';
        $match_i = 0;
        preg_match_all($hashtag_regex, $content, $matches);
        
        foreach ($matches[1] as $match)
        {
            $hashtag = $matches[1][$match_i];
            $hashkey = $matches[2][$match_i];
            $hashdata = getHashtag($hashkey, false);
            
            if (is_array($hashdata))
            {
                $hashlink = '<a href="' . smoothLink('index.php?tab1=hashtag&query=' . $hashdata['tag']) . '" data-href="?tab1=hashtag&query=' . $hashdata['tag'] . '">#' . $hashdata['tag'] . '</a>';
                $content = str_replace($hashtag, $hashlink, $content);
            }
            
            $match_i++;
        }
	    
	    return $content;
	}

	public function getMentions($content)
	{
        $mention_regex = '/@\[([0-9]+)\]/i';
        
        if (preg_match_all($mention_regex, $content, $matches))
        {
            foreach ($matches[1] as $match)
            {
                $match = $this->stringEscape($match);
                $timelineObj = new \miuan\User();
                $timelineObj->setId($match);
                $match_user = $timelineObj->getRows();
                
                $match_search = '@[' . $match . ']';
                $match_replace = '<a href="' . $match_user['url'] . '" data-href="?tab1=timeline&id=' . $match_user['username'] . '">' . $match_user['name'] . '</a>';
                
                if (isset($match_user['id']))
                {
                    $content = str_replace($match_search, $match_replace, $content);
                }
            }
        }
	    
	    return $content;
	}
}