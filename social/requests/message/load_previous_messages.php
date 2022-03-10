<?php

if (! isset ($_GET['recipient_id']))
{
    $_GET['recipient_id'] = 0;
}

if (! isset ($_GET['before_message_id']))
{
    $_GET['before_message_id'] = 0;
}

if (! isset ($_GET['timeline_id']))
{
    $_GET['timeline_id'] = 0;
}

$html = '';
$recipientId = (int) $_GET['recipient_id'];
$beforeMessageId = (int) $_GET['before_message_id'];
$timelineId = (int) $_GET['timeline_id'];

if ($timelineId < 1)
{
    $timelineId = $user['id'];
}

$messages = getMessages(array(
    'recipient_id' => $recipientId,
    'before_message_id' => $beforeMessageId,
    'timeline_id' => $timelineId
));

if (is_array($messages))
{
    foreach ($messages as $msg)
    {
        $themeData['list_message_id'] = $msg['id'];
        $themeData['list_message_text'] = $msg['text'];
        $themeData['list_message_time'] = date('c', $msg['time']);
        $themeData['list_message_owner'] = $msg['owner'];

        foreach ($msg['timeline'] as $key => $value)
        {
            if (! is_array($value))
            {
                $themeData['list_message_timeline_' . $key] = $value;
            }
        }

        foreach ($msg['media'] as $key => $value)
        {
            if (! is_array($value))
            {
                $themeData['list_message_media_' . $key] = $value;
            }
        }

        $themeData['list_message_media_html'] = '';
            
        if (! empty($msg['media']['id']))
        {
            $themeData['list_message_media_complete_url'] = $msg['media']['each'][0]['complete_url'];
            $themeData['list_message_media_html'] = \miuan\UI::view('messages/list-message-each-media');
        }

        if ($msg['owner'] == true)
        {
            $themeData['list_message_buttons'] = \miuan\UI::view('messages/list-message-each-buttons');
        }

        $html .= \miuan\UI::view('messages/list-message-each');
    }
    
    $data = array(
        'status' => 200,
        'html' => $html
    );
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();