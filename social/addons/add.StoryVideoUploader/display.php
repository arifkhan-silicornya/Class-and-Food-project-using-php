<?php
function story_display_video ($conn, $story)
{
	$query = $conn->query("SELECT * FROM story_video_uploads WHERE story_id=" . $story['id']);
	
	if ($query->num_rows == 1)
	{
		$fetch = $query->fetch_array(MYSQLI_ASSOC);
		return '<div align="center">
			<video id="story-' . $story['id'] . '-video-upload" class="story-video-upload-html" src="' . $fetch['url'] . '" controls="yes" preload="no">
				Your browser does not support video playing.
			</video>
		</div>
		<script>$("video#story-' . $story['id'] . '-video-upload").css("max-width", $(".story-wrapper").width());</script>';
	}
}
\miuan\Addons::register('story_display_addon_data', 'story_display_video');