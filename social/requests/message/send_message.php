<?php
$array = array();
$array['type'] = 'message';
$array['timeline_id'] = (int) $_POST['timeline_id'];
$array['recipient_id'] = (int) $_POST['recipient_id'];
$continue = false;

if (isset($_FILES['photos']['name'])) {
    $array['photos'] = $_FILES['photos'];
    $continue = true;
}

if (! empty($_POST['text'])) {
    $array['text'] = $_POST['text'];
    $nbrText = str_replace("\n", "", trim($_POST['text']));

    if (! empty($nbrText))
    {
        $continue = true;
    }
}

if ($continue == true)
{
    $post_id = registerMessage($array);
    
    if (! empty($post_id))
    {
        $html = '';
        $array_data = array(
            'message_id' => $post_id,
            'timeline_id' => $array['timeline_id'],
            'recipient_id' => $array['recipient_id']
        );
        
        foreach (getMessages($array_data) as $msg)
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
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();