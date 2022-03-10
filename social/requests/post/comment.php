<?php
$commentId = $storyObj->putComment($_POST['text'], $_POST['timeline_id']);

if ($commentId)
{
	$commentObj = new \miuan\Comment($conn);
	$commentObj->setId($commentId);

	$data = array(
	    'status' => 200,
	    'html' => $commentObj->getTemplate(),
	    'activity_html' => $storyObj->getCommentActivityTemplate()
	);
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();