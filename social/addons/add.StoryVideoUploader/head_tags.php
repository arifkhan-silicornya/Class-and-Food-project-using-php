<?php
function video_upload_css()
{
	global $user;
	$addon_data = json_decode(file_get_contents('addons/add.StoryVideoUploader/data.json'), true);

	if ($addon_data['verified_only'] == 1 && $user['verified'] == 0)
	{
		return "";
	}

	return '<style>
	.video-upload-container {
	display: block;
	color: #898f9c;
	padding: 5px 10px;
	}
	</style>';
}
\miuan\Addons::register('head_tags_add_content', 'video_upload_css');
