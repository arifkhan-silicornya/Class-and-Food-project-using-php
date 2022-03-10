<?php
$albumId = (int) $_GET['album_id'];
$query = $conn->query("SELECT COUNT(id) AS count FROM " . DB_MEDIA . " WHERE id=$albumId AND timeline_id=" . $user['id'] . " AND type='album' AND temp=0 AND active=1");

if ($query)
{
    $themeData['album_id'] = $albumId;
    $html = \miuan\UI::view('window/delete-album');
    
    if (!empty($html))
    {
        $data = array(
            'status' => 200,
            'html' => $html
        );
    }
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();