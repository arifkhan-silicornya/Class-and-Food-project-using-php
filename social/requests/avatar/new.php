<?php
$continue = false;

if ($_POST['timeline_id'] == $user['id'])
{
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
        $query = $conn->query("UPDATE " . DB_ACCOUNTS . " SET avatar_id=" . $avatar['id'] . " WHERE id=" . $timeline['id']);
        
        if ($query)
        {
            unset($_SESSION['tempche']['user'][$timeline['id']]);
            $data = array(
                'status' => 200,
                'avatar_url' => $config['site_url'] . '/' . $avatar['url'] . '_100x100.' . $avatar['extension']
            );
        }
    }
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();