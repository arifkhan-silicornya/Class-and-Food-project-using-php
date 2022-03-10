<?php
function video_upload_launchericon()
{
	global $user;
	$addon_data = json_decode(file_get_contents('addons/add.StoryVideoUploader/data.json'), true);

	if ($addon_data['verified_only'] == 1 && $user['verified'] == 0)
	{
		return "";
	}

	return '<span class="option" onclick="javascript:$(\'.story-publisher-box\').find(\'input.video-upload-input\').click();">
		<i class="fa fa-file-video-o"></i>
	</span>

	<input class="video-upload-input" type="file" name=\'video_upload\' multiple="yes" accept=".mp4" onchange="viewVideoUploadDisplayer(this);" style="height:1px;width:1px;overflow:hidden;margin-left:-999px;display:none;">

	<script>
	function viewVideoUploadDisplayer(input)
	{
		video = input.files[0];
		video_size = ' . $addon_data['max_upload_limit'] * 1024 * 1024 . ';

		if (video.size > video_size)
		{
			alert("File size is too large. Maximum file upload limit is ' . $addon_data['max_upload_limit'] . ' MB");
			$(".video-upload-input").val("");
		}

		if (video.name.length > 4 && video.size < video_size)
		{
			parent_wrapper = $(\'.story-publisher-box\');
	    	input_wrapper = parent_wrapper.find(\'.video-upload-wrapper\');
	    	group_id = input_wrapper.attr(\'data-group\');

	    	parent_wrapper.find(\'.video-upload-container\').html(\'<i class="fa fa-file-audio-o"></i> \' + video.name);

	    	$(\'.input-wrapper[data-group=\' + group_id + \']\').slideUp();
	    	input_wrapper.slideDown();

	    	allowPost();
		}
	}
	</script>';
}
\miuan\Addons::register('new_story_feature_launchericon', 'video_upload_launchericon');
