<?php
function story_upload_video ($conn, $storyId, $file)
{
	global $user;
	$addon_data = json_decode(file_get_contents('addons/add.StoryVideoUploader/data.json'), true);

	if ($addon_data['verified_only'] == 1 && $user['verified'] == 0)
	{
		return "";
	}

	ini_set('post_max_size', '64M');
	ini_set('upload_max_filesize', '64M');

	if (! isset($file['video_upload']))
	{
		return "";
	}

	$video = $file['video_upload'];

	if ( is_numeric($storyId) )
	{
		if ( is_uploaded_file($video['tmp_name']) )
	    {
			$escapeObj = new \miuan\Escape();
			$video['name'] = $escapeObj->stringEscape($video['name']);
			$name = md5($video['name'] . time());
			$ext = strtolower(substr($video['name'], strrpos($video['name'], '.') + 1, strlen($video['name']) - strrpos($video['name'], '.')));

			if ($video['size'] > 1024 && $video['size'] < ($addon_data['max_upload_limit'] * 1024 * 1024))
			{
				if ( preg_match('/(mp4)/', $ext) )
				{
					$dir = 'video_uploads';

					if ( !file_exists($dir) )
					{
						mkdir($dir, 0777, true);
					}

					$url = $dir . '/' . $name . '.' . $ext;

					if ( move_uploaded_file($video['tmp_name'], $url) )
					{
						$query = $conn->query("INSERT INTO story_video_uploads (story_id,url) VALUES ($storyId,'$url')");

						if ( $query )
						{
							return $conn->insert_id;
						}
					}
				}
			}
		}
	}
}
\miuan\Addons::register('new_story_insert_datafile', 'story_upload_video');
