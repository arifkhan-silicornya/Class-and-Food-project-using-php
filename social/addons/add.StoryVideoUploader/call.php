<?php
function footer_call_mediaElement_videoUpload ()
{
	return '<script>
	$("video").css("max-width", $(".story-wrapper").width());
	$(window).resize(function(){
		$("video").css("max-width", $(".story-wrapper").width());
	});
	</script>';
}
\miuan\Addons::register('body_end_add_content', 'footer_call_mediaElement_videoUpload');
