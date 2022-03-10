<?php
if (! empty($comment['id']))
{
	$commentObj->putLike();

	$data = array(
	    'status' => 200,
	    'button_html' => $commentObj->getLikeButtonTemplate(),
	    'activity_html' => $commentObj->getLikeActivityTemplate()
	);

	header("Content-type: application/json; charset=utf-8");
	echo json_encode($data);
	$conn->close();
	exit();
}