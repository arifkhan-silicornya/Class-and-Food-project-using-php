<?php
if (deleteGroupAdmin($_POST['group_id'], $_POST['admin_id']))
{
    $data = array(
        'status' => 200
    );
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();