<?php
if (! empty($comment['id']))
{
	$data = array(
	    'status' => 200,
	    'html' => $commentObj->getRemoveTemplate()
	);

	header("Content-type: application/json; charset=utf-8");
	echo json_encode($data);
	$conn->close();
	exit();
}