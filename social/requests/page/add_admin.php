<?php
$pageId = (int) $_POST['page_id'];
$adminId = (int) $_POST['admin_id'];
$adminRole = $escapeObj->stringEscape($_POST['admin_role']);

if (registerPageAdmin($pageId, $adminId, $adminRole))
{
    $data = array(
        'status' => 200
    );
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();