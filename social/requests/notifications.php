<?php
userOnly();

$data = array(
    'status' => 200,
    'html' => ''
);

$notifications = getNotifications();

foreach ($notifications as $k => $v)
{
    $themeData['notif_url'] = $v['url'];
    $themeData['notif_url_raw'] = str_replace('index.php', '', $v['raw_url']);
    $themeData['notif_text'] = $v['text'];
    $themeData['notif_time'] = date('c', $v['time']);

    $themeData['notifier_avatar_url'] = $v['notifier']['avatar_url'];
    $themeData['notifier_name'] = $v['notifier']['name'];

    if ($v['seen'] == 0)
    {
        $themeData['notif_unread_class'] = 'unread';
    }

    $data['html'] .= \miuan\UI::view('header/notification-list');
    
    if ($v['seen'] == 0)
    {
        $conn->query("UPDATE " . DB_NOTIFICATIONS . " SET seen=" . time() . " WHERE id=" . $v['id']);
    }
}

header("Content-type: application/json; charset=utf-8");
echo json_encode($data);
$conn->close();
exit();