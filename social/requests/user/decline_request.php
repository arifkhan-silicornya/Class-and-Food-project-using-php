<?php
userOnly();
$followerId = (int) $_POST['follower_id'];

if ($userObj->isFollowRequested($followerId))
{
    $query = $conn->query("DELETE FROM " . DB_FOLLOWERS . " WHERE follower_id=$followerId AND following_id=" . $user['id'] . " AND active=0");
    
    if ($query)
    {
        $data = array(
            'status' => 200
        );
    }
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();