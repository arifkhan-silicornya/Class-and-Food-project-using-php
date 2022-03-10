<?php
if (isset($_FILES['image']['tmp_name']))
{
    $coverImage = $_FILES['image'];
    $continue = false;

    $timelineId = (int) $_POST['timeline_id'];
    $timelineObj = new \miuan\User($conn);
    $timelineObj->setId($timelineId);
    $timeline = $timelineObj->getRows();
    
    if (isset($timeline['id']))
    {
        if ($timelineObj->isAdmin())
        {
            $continue = true;
        }
    }
    
    if ($continue == true)
    {
        $coverData = registerCoverImage($coverImage);
        
        if (isset($coverData['id']))
        {
            $query = $conn->query("UPDATE " . DB_ACCOUNTS . " SET cover_id=" . $coverData['id'] . ",cover_position=0 WHERE id=" . $timelineId);
            
            if ($query)
            {
                unset($_SESSION['tempche']['user'][$timelineId]);
                $data = array(
                    'status' => 200,
                    'cover_url' => $config['site_url'] . '/' . $coverData['cover_url'],
                    'actual_cover_url' => $config['site_url'] . '/' . $coverData['url']. '.' . $coverData['extension']
                );
            }
        }
    }
    
    header("Content-type: application/json; charset=utf-8");
    echo json_encode($data);
    $conn->close();
    exit();
}