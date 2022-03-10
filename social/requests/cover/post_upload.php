<?php
if (isset($_FILES['image']['tmp_name']))
{
    $coverImage = $_FILES['image'];
    $continue = false;
    $processed = false;
    
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
            $query = $conn->query("UPDATE " . DB_ACCOUNTS . " SET cover_id=" . $coverData['id'] . ",cover_position=0 WHERE id=$timelineId");
            
            if ($query)
            {
                unset($_SESSION['tempche']['user'][$timelineId]);
                $processed = true;
            }
        }
    }
    
    if (! empty($_POST['redirect_url']))
    {
        $redirect_url = $escapeObj->stringEscape($_POST['redirect_url']);
        header('Location: ' . $redirect_url);
    }
    else
    {
        if ($processed == true)
        {
            header('Location: ' . smoothLink('index.php?tab1=timeline&id=' . $timeline['username']));
        }
        else
        {
            header('Location: ' . smoothLink('index.php?tab1=settings&tab2=avatar'));
        }
    }
}