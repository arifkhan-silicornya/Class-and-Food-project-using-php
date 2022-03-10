<?php
$storyObj->putFollow();

$data = array(
    'status' => 200,
    'button_html' => $storyObj->getFollowButtonTemplate(),
    'activity_html' => $storyObj->getFollowActivityTemplate()
);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();