<?php
userOnly();

$html = '';
$recipientId = (int) $_GET['recipient_id'];
$recipientObj = new \miuan\User($conn);
$recipientObj->setId($recipientId);
$recipient = $recipientObj->getRows();

if (isset($recipient['id']))
{
    $messages_num = countMessages(0, $recipient['id'], true);
    
    if ($messages_num > 0)
    {
        $messages = getMessages(array('new' => true, 'recipient_id' => $recipient['id']));
        
        if (is_array($messages))
        {
            foreach ($messages as $k => $v)
            {
                $themeData['message_text'] = $v['text'];
                $themeData['message_time'] = getTimeAgo($v['time'], true);

                $themeData['message_user_url'] = $v['timeline']['url'];
                $themeData['message_user_avatar_url'] = $v['timeline']['avatar_url'];
                $themeData['message_user_name'] = $v['timeline']['name'];

                if (isset($v['media']['id']))
                {
                    $themeData['message_media_url'] = $v['media']['complete_url'];
                    $themeData['message_media'] = \miuan\UI::view('chat/text-media');
                }

                $html .= \miuan\UI::view('chat/incoming-text');
            }
        }
        
        $data = array(
            'status' => 200,
            'html' => $html
        );
    }
    
    $data['online'] = $recipient['online'];
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();