<?php
$albumId = (int) $_GET['album_id'];
$query = $conn->query("SELECT COUNT(id) AS count FROM " . DB_MEDIA . " WHERE id=$albumId AND timeline_id=" . $user['id'] . " AND type='album' AND temp=0 AND active=1");

if ($query)
{
    $albumObj = new \miuan\Media();
    $albumObj->setId($albumId);
    $photos = $albumObj->getRows();

    foreach ($photos['each'] as $photo)
    {
        $query2 = $conn->query("DELETE FROM " . DB_MEDIA . " WHERE id=" . $photo['id']);
        $query3 = $conn->query("DELETE FROM " . DB_POSTS . " WHERE media_id=" . $photo['id']);
        
        $dirimages = glob($photo['url'] . '*');

        foreach ($dirimages as $dirimg)
        {
            unlink($dirimg);
        }
    }

    $query4 = $conn->query("DELETE FROM " . DB_MEDIA . " WHERE id=$albumId");
    $query5 = $conn->query("DELETE FROM " . DB_POSTS . " WHERE media_id=$albumId");
    $data = array(
        'status' => 200,
        'location' => smoothLink('index.php?tab1=timeline&id=' . $user['username'])
    );
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();