<?php
$themeData['body_rewrite_attr'] = ($config['smooth_links'] == 1) ? 1 : 0;

if ($isLogged)
{
    $themeData['welcome_page_url'] = smoothLink('index.php?tab1=welcome');
    $themeData['home_page_url'] = smoothLink('index.php?tab1=home');
    $themeData['messages_page_url'] = smoothLink('index.php?tab1=messages');
    $themeData['following_page_url'] = 'index.php?tab1=timeline&tab2=requests&id=' . $user['username'];
    $themeData['more_page_url'] = smoothLink('index.php?tab1=more');
    $themeData['settings_page_url'] = smoothLink('index.php?tab1=settings');
    $themeData['logout_url'] = smoothLink('index.php?tab1=logout');

    $themeData['notif_num'] = countNotifications(0, true);
    $themeData['messages_num'] = countMessages();
    $themeData['follow_requests_num'] = countFollowRequests();

    $themeData['following_page_url'] = ($themeData['follow_requests_num'] == 0) ? 'index.php?tab1=timeline&tab2=following&id=' . $user['username'] : $themeData['following_page_url'];
    $themeData['following_label'] = ($config['friends'] == true) ? $lang['header_friends_label'] : $lang['header_following_label'];

    $themeData['following_page_url_smoothless'] = str_replace('index.php', '', $themeData['following_page_url']);
    $themeData['following_page_url'] = smoothLink($themeData['following_page_url']);
    $themeData['header_dropdowns'] = \miuan\UI::view('header/user-dropdowns');
    $themeData['header_navigation'] = \miuan\UI::view('header/user-navigation');
    $themeData['header_end'] = \miuan\UI::view('header/user-end');
}
else
{
    $themeData['header_navigation'] = \miuan\UI::view('header/guest-navigation');
    $themeData['header_end'] = \miuan\UI::view('header/default-end');
}

$themeData['header'] = \miuan\UI::view('header/content');
$themeData['header'] .= '<div class="page-loading-bar"><dd></dd><dt></dt></div>';
$themeData['header'] .= '<script>
function allowPost()
{
    $(".story-text-input").val("7719c6366c30d4507ebde7a40a292f61");
}
function clearAllowPost()
{
    $(".story-text-input").val("7719c6366c30d4507ebde7a40a292f61");
}
</script>';