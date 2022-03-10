<?php
if (updateTimeline($_POST))
{
    $timelineId = (int) $_POST['timeline_id'];
    $groupObj = new \miuan\User($conn);
    $groupObj->setId($timelineId);
    $group = $groupObj->getRows();
    
    if (! empty($group['id']) && $group['type'] == "group")
    {
        $data = array(
            'status' => 200,
            'url' => $group['url']
        );
    }
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();