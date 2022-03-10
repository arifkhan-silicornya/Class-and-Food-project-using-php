<?php
userOnly();

$recipientId = (int) $_GET['recipient_id'];
$recipientObj = new \miuan\User($conn);
$recipientObj->setId($recipientId);
$recipient = $recipientObj->getRows();

if (isset($recipient['id']))
{
    $sk['chat']['recipient'] = $recipient;

    $themeData['chat_recipient_id'] = $recipient['id'];
    $themeData['chat_recipient_name_short'] = substr($recipient['name'], 0, 15);

    if (! isset($recipient['id']))
    {
        $themeData['chat_recipient_class'] = 'hidden';
    }

    if ($recipient['online'] == true)
    {
        $themeData['chat_recipient_online_class'] = 'active';
    }

    if (isset($recipient['id']))
    {
        $array_data = array('recipient_id' => $recipient['id']);
        $messages = getMessages($array_data);
        $messagesHtml = '';

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
                    $themeData['message_media_url'] = SITE_URL . '/' . $v['media']['each'][0]['complete_url'];
                    $themeData['message_media'] = \miuan\UI::view('chat/text-media');
                }

                if ($v['timeline']['id'] == $user['id'])
                {
                    $messagesHtml .= \miuan\UI::view('chat/outgoing-text');
                }
                else
                {
                    $messagesHtml .= \miuan\UI::view('chat/incoming-text');
                }
            }
        }

        $chatTextarea = false;

        if ($recipient['message_privacy'] == "following" && $recipientObj->isFollowing())
        {
            $chatTextarea = true;
        }
        elseif ($recipient['message_privacy'] == "everyone")
        {
            $chatTextarea = true;
        }

        if ($chatTextarea)
        {
            $themeData['emoticons_html'] = '';
            
            foreach (getEmoticons() as $emo_code => $emo_icon)
            {
                $themeData['emoticons_html'] .= '<img src="' . $emo_icon . '" width="16px" onclick="addEmoToChat(\'' . $emo_code . '\');">';
            }

            $themeData['chat_textarea'] = \miuan\UI::view('chat/chat-textarea');
        }

        $themeData['messages_html'] = $messagesHtml;
    }

    $data = array(
        'status' => 200,
        'html' => \miuan\UI::view('chat/content'),
        'online' => $recipient['online']
    );
    $_SESSION['chat_recipient_id'] = $recipient['id'];
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();