<?php
$messageId = (int) $_POST['message_id'];
$query = $conn->query("SELECT id,timeline_id FROM " . DB_MESSAGES . " WHERE id=$messageId AND active=1");

if ($query->num_rows == 1)
{
    $fetch = $query->fetch_array(MYSQLI_ASSOC);

    $timelineObj = new \miuan\User($conn);
    $timelineObj->setId($fetch['timeline_id']);
    $timeline = $timelineObj->getRows();

    if ($timelineObj->isAdmin())
    {
        $query2 = $conn->query("DELETE FROM " . DB_MESSAGES . " WHERE id=$messageId AND active=1");
        
        if ($query2)
        {
            $data = array(
                'status' => 200
            );
        }
    }
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();