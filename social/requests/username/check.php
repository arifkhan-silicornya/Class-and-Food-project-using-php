<?php
$timelineId = (int) $_GET['timeline_id'];

if (($status = getUsernameStatus($_GET['q'], $timelineId)))
{
    $data = array(
        'status' => $status
    );
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();