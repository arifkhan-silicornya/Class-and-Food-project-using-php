<?php
$data = array(
    'status' => 200,
    'html' => $storyObj->getComments()
);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();