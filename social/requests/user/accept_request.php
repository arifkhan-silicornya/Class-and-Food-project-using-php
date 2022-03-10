<?php
userOnly();
$followerId = (int) $_POST['follower_id'];

if ($userObj->isFollowRequested($followerId))
{
    $query = $conn->query("UPDATE " . DB_FOLLOWERS . " SET active=1 WHERE follower_id=$followerId AND following_id=" . $user['id'] . " AND active=0");
    
    if ($query)
    {
        if ($config['friends'] == true)
        {
            $query_two = $conn->query("INSERT INTO " . DB_FOLLOWERS . " (active,follower_id,following_id,time) VALUES (1," . $user['id'] . ",$followerId," . time() . ")");
            
            registerNotification(array(
                'recipient_id' => $followerId,
                'type' => 'accepted_friend_request',
                'text' => $lang['accepted_friend_request'],
                'url' => 'index.php?tab1=timeline&id=' . $user['username']
            ));
        }

        $data = array(
            'status' => 200
        );
    }
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();