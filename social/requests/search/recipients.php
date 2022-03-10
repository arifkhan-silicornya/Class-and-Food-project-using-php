<?php
userOnly();

$search_query = $escapeObj->stringEscape($_GET['q']);
$limit = 10;
$html = '';
$i = 0;

if (! empty($_GET['limit']))
{
    $limit = (int) $_GET['limit'];
}

foreach (getMessageRecipients(0, $search_query, false, $limit) as $eachRecipient)
{
    $themeData['list_recipient_id'] = $eachRecipient['id'];
    $themeData['list_recipient_name'] = $eachRecipient['name'];
    $themeData['list_recipient_thumbnail_url'] = $eachRecipient['thumbnail_url'];

    if ($eachRecipient['online'] == true) {
        $themeData['list_recipient_online_class'] = 'active';
    }

    $themeData['list_recipient_message_num'] = countMessages(0, $eachRecipient['id'], true);

    $html .= \miuan\UI::view('messages/recipient-list');
    $i++;
}

if (countMessageRecipients(0, $search_query, false) > $i)
{
    $html .= \miuan\UI::view('messages/view-more-recipients');
}

$data = array(
    'status' => 200,
    'html' => $html
);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();