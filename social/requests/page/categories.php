<?php
$categoryId = (int) $_GET['category_id'];

$data = array(
    'status' => 200,
    'content' => getPageCategories($categoryId)
);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();