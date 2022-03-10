<?php
userOnly();

if (empty($_GET['q']))
{
    $_GET['q'] = '';
}

$searchQuery = $escapeObj->stringEscape($_GET['q']);
$html = '';

foreach (getOnlines(0, $searchQuery) as $k => $v)
{
    $themeData['list_online_id'] = $v['id'];
    $themeData['list_online_name'] = $v['name'];
    $themeData['list_online_thumbnail_url'] = $v['thumbnail_url'];
    $themeData['list_online_name_short'] = substr($v['name'], 0, 15);
    $themeData['list_online_class'] = '';
    $themeData['list_online_num_messages'] = 0;
    $themeData['list_online_num_messages_html'] = '';

    if ($v['online'] == true)
    {
        $themeData['list_online_class'] = 'active';
    }

    if (($themeData['list_online_num_messages'] = countMessages(0, $v['id'], true)) > 0)
    {
        $themeData['list_online_num_messages_html'] = \miuan\UI::view('chat/list-num-messages-each');
    }

    $html .= \miuan\UI::view('chat/online-column');
}

if (empty($html))
{
    if ($config['friends'] == true)
    {
        $themeData['no_onlines'] = $lang['no_friends_online'];
    }
    else
    {
        $themeData['no_onlines'] = $lang['no_followers_online'];
    }

    $html = \miuan\UI::view('chat/no-onlines');
}

$data = array(
    'status' => 200,
    'html' => $html
);

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();