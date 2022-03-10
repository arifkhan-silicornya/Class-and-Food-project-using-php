<?php
if (! empty($comment['id']))
{
	$commentObj->putReport();
	$data = array(
	    'status' => 200
	);

	header("Content-type: application/json; charset=utf-8");
	echo json_encode($data);
	$conn->close();
	exit();
}