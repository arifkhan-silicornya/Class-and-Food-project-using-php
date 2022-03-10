<?php
$pageId = (int) $_POST['page_id'];
$adminId = (int) $_POST['admin_id'];

if (deletePageAdmin($pageId, $adminId))
{
    $data = array(
        'status' => 200
    );
    
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();