<?php
$continue = false;
$processed = false;

if ($_POST['timeline_id'] == $user['id'])
{
    $timelineId = $user['id'];
    $timeline = $user;
    $timelineObj = $userObj;
    $continue = true;
}
else
{
    $timelineId = (int) $_POST['timeline_id'];
    $timelineObj = new \miuan\User($conn);
    $timelineObj->setId($timelineId);
    $timeline = $timelineObj->getRows();
}

if ($continue == false && isset($timeline['id']))
{
    if ($timelineObj->isAdmin())
    {
        $continue = true;
    }
}

if (isset($_FILES['image']['tmp_name']) && $continue == true)
{
    $image = $_FILES['image'];
    $avatar = registerMedia($image);
    
    if (isset($avatar['id']))
    {
        $query = $conn->query("UPDATE " . DB_ACCOUNTS . " SET avatar_id=" . $avatar['id'] . " WHERE id=$timelineId");
        
        if ($query)
        {
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