<?php
$reaction = "";

if (! empty($_GET['reaction']))
{
	$reaction = $escapeObj->stringEscape($_GET['reaction']);
}

$storyObj->putReaction($reaction);

$data = array(
    'status' => 200,
    'button_html' => $storyObj->getReactButtonTemplate(),
    'activity_html' => $storyObj->getReactionActivityTemplate()
);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();