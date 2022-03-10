<?php
if (updateTimeline($_POST))
{
    $timelineId = (int) $_POST['timeline_id'];
    $timelineObj = new \miuan\User($conn);
    $timelineObj->setId($timelineId);
    $timeline = $timelineObj->getRows();
    
    if (isset($timeline['id']))
    {
        $data = array(
            'status' => 200,
            'url' => $timeline['url']
        );
    }
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();