<?php
$storyObj->putRemove();
$data = array(
    'status' => 200,
    'post_type' => $story['type']
);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();