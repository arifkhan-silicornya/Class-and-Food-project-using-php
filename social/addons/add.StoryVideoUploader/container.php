<?php
function video_upload_option()
{
	global $user;
	$addon_data = json_decode(file_get_contents('addons/add.StoryVideoUploader/data.json'), true);

	if ($addon_data['verified_only'] == 1 && $user['verified'] == 0)
	{
		return "";
	}

	return '<div class="input-wrapper video-upload-wrapper" data-group="D">
	    <div class="float-left">
			<div class="video-upload-container">No video uploaded</div>
		</div>

		<div class="float-clear"></div>
	</div>';
}
\miuan\Addons::register('new_story_feature_option', 'video_upload_option');
