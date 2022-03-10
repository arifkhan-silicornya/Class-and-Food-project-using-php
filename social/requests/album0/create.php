<?php
if (isset($_FILES['photos']['name']))
{
    if (! empty($_POST['album_name']) && ! empty($_POST['album_descr']))
    {
        $albumName = $escapeObj->stringEscape($_POST['album_name']);
        $albumDescr = $escapeObj->stringEscape($_POST['album_descr']);

        $query = $conn->query("INSERT INTO " . DB_MEDIA . " (timeline_id,active,name,descr,type,temp) VALUES (" . $user['id'] . ",1,'$albumName','$albumDescr','album',0)");
        
        if ($query)
        {
            $albumId = $conn->insert_id;
            $photosCount = count($_FILES['photos']['name']);

            for ($i = 0; $i < $photosCount; $i++)
            {
                $photoData = registerMedia(array(
                    'tmp_name' => $_FILES['photos']['tmp_name'][$i],
                    'name' => $_FILES['photos']['name'][$i],
                    'size' => $_FILES['photos']['size'][$i]
                ), $albumId);
                
                if (! empty($photoData['id']))
                {
                    $query2 = $conn->query("INSERT INTO " . DB_POSTS . " (active,hidden,media_id,time,timeline_id) VALUES (1,1," . $photoData['id'] . "," . time() . "," . $user['id'] . ")");
                    
                    if ($query2)
                    {
                        $mediaPostId = $conn->insert_id;
                        
                        $conn->query("UPDATE " . DB_POSTS . " SET post_id=id WHERE id=$mediaPostId");
                        $conn->query("UPDATE " . DB_MEDIA . " SET post_id=$mediaPostId WHERE id=" . $photoData['id']);

                        $mediaPostObj = new \miuan\Story();
                        $mediaPostObj->setId($mediaPostId);
                        $mediaPost = $mediaPostObj->getRows();

                        $mediaPostObj->putFollow();
                    }
                }
            }

            $activityText = 'added ' . $photosCount . ' new photos to the album [album]' . $albumId . '[/album]';
            $query3 = $conn->query("INSERT INTO " . DB_POSTS . " (active,media_id,activity_text,time,timeline_id) VALUES (1,$albumId,'$activityText'," . time() . "," . $user['id'] . ")");
            
            if ($query3)
            {
                $postId = $conn->insert_id;
                $query4 = $conn->query("UPDATE " . DB_POSTS . " SET post_id=$postId WHERE id=$postId");
                
                if ($query4)
                {
                    $postObj = new \miuan\Story();
                    $postObj->setId($postId);
                    $post = $postObj->getRows();

                    $postObj->putFollow();

                    $data = array(
                        'status' => 200,
                        'url' => smoothLink('index.php?tab1=album&tab2=' . $albumId)
                    );
                }
            }
        }
    }
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();