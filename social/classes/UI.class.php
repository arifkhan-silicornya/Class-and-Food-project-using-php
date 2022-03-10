<?php

namespace miuan;

class UI {
	private $filename;

	public static function view()
	{
		global $config;

		$params = func_get_args();
		$file = $params[0];
		$page = 'main/' . $config['theme'] . '/layout/' . $file . '.phtml';
		$contentOpen = fopen($page, 'r');
		$content = @fread($contentOpen, filesize($page));
		fclose($contentOpen);

		if (! empty($params[1]))
		{
			$uikey = $params[1];

			unset($params[0]);
			unset($params[1]);

			if (! isset($params[2]))
			{
				$params[2] = array();
			}

			if (! isset($params[3]))
			{
				$params[3] = array();
			}

			$content = \miuan\Addons::invoke(array($uikey, 'string', 'no_append'), $params[2], $params[3], $content);
		}

		$content = preg_replace_callback(
	        '/@([a-zA-Z0-9_]+)@/',

	        function ($matches)
	        {
	        	global $lang;
	        	$matches[1] = strtolower($matches[1]);
	        	return (isset($lang[$matches[1]]) ? $lang[$matches[1]] : "");
	        },

	        $content
	    );

	    $content = preg_replace_callback(
	        '/{{([A-Z0-9_]+)}}/',

	        function ($matches)
	        {
	        	global $themeData;
	        	$matches[1] = strtolower($matches[1]);
	        	return (isset($themeData[$matches[1]]) ? $themeData[$matches[1]] : "");
	        },

	        $content
	    );
		
		return $content;
	}
}