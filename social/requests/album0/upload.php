<?php
if (isset($_FILES['photos']['name']))
{
    $albumId = (int) $_POST['album_id'];
    
    if ($albumId > 0)
    {
        $query = $conn->query("SELECT COUNT(id) AS count FROM " . DB_MEDIA . " WHERE id=$albumId AND timeline_id=" . $user['id'] . " AND type='album' AND temp=0 AND active=1");
        
        if ($query)
        {
            $fetch = $query->fetch_array(MYSQLI_ASSOC);
            
            if ($fetch['count'] == 1)
            {
                $photosCount = count($_FILES['photos']['name']);
                $html = '';

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

                        $themeData['list_photo_story_id'] = $photoData['id'];
                        $themeData['list_photo_url'] = $config['site_url'] . '/' . $photoData['url'] . '_100x100.' . $photoData['extension'];
                        $themeData['list_photo_buttons'] = \miuan\UI::view('album/list-photo-each-buttons');

                        $html .= \miuan\UI::view('album/list-photo-each');
                    }
                }

                $data = array(
                    'status' => 200,
                    'html' => $html
                );

                $query3 = $conn->query("DELETE FROM " . DB_POSTS . " WHERE media_id=$albumId AND timeline_id=" . $user['id']);
                $activityText = 'added ' . $photosCount . ' new photos to the album [album]' . $albumId . '[/album]';
                $query4 = $conn->query("INSERT INTO " . DB_POSTS . " (active,media_id,activity_text,time,timeline_id) VALUES (1,$albumId,'$activityText'," . time() . "," . $user['id'] . ")");
                
                if ($query4)
                {
                    $postId = $conn->insert_id;
                    $query5 = $conn->query("UPDATE " . DB_POSTS . " SET post_id=$postId WHERE id=$postId");
                    
                    $postObj = new \miuan\Story();
                    $postObj->setId($postId);
                    $post = $postObj->getRows();

                    $postObj->putFollow();
                }
            }
        }
    }
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();