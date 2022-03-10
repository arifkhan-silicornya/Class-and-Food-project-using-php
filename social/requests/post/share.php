<?php
$storyObj->putShare();
$data = array(
    'status' => 200,
    'button_html' => $storyObj->getShareButtonTemplate(),
    'activity_html' => $storyObj->getShareActivityTemplate()
);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();