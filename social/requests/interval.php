<?php
userOnly();

$data['status'] = 200;
$data['notifications'] = countNotifications();

$data['messages'] = countMessages();
$data['follow_requests'] = $userObj->numFollowRequests();
$data['chat'] = false;

if (! empty($_GET['chat_recipient_id']) && is_numeric($_GET['chat_recipient_id']))
{
    $data['chat'] = true;
    $html = '';
    $recipientId = (int) $_GET['chat_recipient_id'];
    $recipientObj = new \miuan\User($conn);
    $recipientObj->setId($recipientId);
    $recipient = $recipientObj->getRows();
    
    if (isset($recipient['id']))
    {
        $data['chat_recipient_online'] = $recipient['online'];
        $messages_num = countMessages(0, $recipient['id'], true);
        
        if ($messages_num > 0)
        {
            $messages = getMessages(array(
                'new' => true,
                'recipient_id' => $recipient['id']
            ));
            
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
            
            $data['chat_messages'] = $html;
        }
    }
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();