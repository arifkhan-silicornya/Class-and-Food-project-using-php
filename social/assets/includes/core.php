<?php


$version = '2.1.0';
$api_version = '1.0';
$themeData = array();

if (! defined('PHP_VERSION_ID'))
{
    $phpversion = explode('.', PHP_VERSION);
    define('PHP_VERSION_ID', ($phpversion[0] * 10000 + $phpversion[1] * 100 + $phpversion[2]));
}

if (PHP_VERSION_ID < 50400)
{
    exit("requires atleast PHP version 5.4.0 to work. Your PHP version is: " . PHP_VERSION . ". PHP 5.4.0 was released on March <strong>2012</strong>. It's about time you make the upgrade. Please upgrade your PHP version to 5.4+.");
}

if (! function_exists('mysqli_connect'))
{
    exit("requires MySQLi Extension to work.");
}

if (! extension_loaded('gd') && ! extension_loaded('gd2'))
{
    exit("requires GD Library to process images.");
}

error_reporting(0);
set_time_limit(0);
date_default_timezone_set('Asia/Dhaka');
session_start();

// Includes
require('assets/includes/config.php');
require('assets/includes/tables.php');

/* API Version */
$themeData['api_version'] = $api_version;

// Connect to SQL Server
$conn = new mysqli($sql_host, $sql_user, $sql_pass, $sql_name);
$conn->set_charset("utf8");

// Check connection
if ($conn->connect_errno)
{
    exit($conn->connect_errno);
}

require_once('classes/autoload.php');
require_once('addons/autoload.php');
require_once('connect.php');

if (! isset($_SESSION['reset_time']))
{
    $_SESSION['reset_time'] = time();
}

if ($config['reset_time'] > $_SESSION['reset_time'])
{
    session_destroy();
    header("Location: " . $config['site_url']);
}

$escapeObj = new \miuan\Escape();

/* ----------------------------- */
/* Log In Check */
function isLogged()
{
    if (isset($_SESSION['user_id']) && isset($_SESSION['user_pass']))
    {
        $userId = (int) $_SESSION['user_id'];
        $userPass = $_SESSION['user_pass'];

        if (isset($_SESSION['_cache_']['user_data'][$userId]))
        {
            $cche_usrdata = $_SESSION['_cache_']['user_data'][$userId];

            if (is_array($cche_usrdata))
            {
                if ($cche_usrdata['password'] == $userPass)
                {
                    return true;
                }
            }
        }

        global $conn;
        $query = $conn->query("SELECT COUNT(id) AS count FROM " . DB_ACCOUNTS . " WHERE id=$userId AND password='$userPass' AND type='user' AND active=1");
        $fetch = $query->fetch_array(MYSQLI_ASSOC);

        return $fetch['count'];
    }
}

/* Send Mails */
function send_mail($to, $subject, $message)
{
    if (! filter_var($to, FILTER_VALIDATE_EMAIL))
    {
        return false;
    }

    global $config;

    $headers = "From: " . $config['email'] . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    mail($to, $subject, $message, $headers);
}

/* Smooth Link */
function smoothLink($url='')
{
    global $config;

    $urls = array(
        '/^index\.php\?tab1=timeline&tab2=([^\/]+)&tab3=([^\/]+)&recipient_id=([^\/]+)&id=([^\/]+)$/i',
        '/^index\.php\?tab1=timeline&tab2=([^\/]+)&tab3=([^\/]+)&id=([^\/]+)$/i',
        '/^index\.php\?tab1=timeline&tab2=([^\/]+)&id=([^\/]+)$/i',
        '/^index\.php\?tab1=timeline&id=([^\/]+)$/i',
        '/^index\.php\?tab1=messages&recipient_id=([A-Za-z0-9_]+)$/i',
        '/^index\.php\?tab1=story&id=([0-9]+)$/i',
        '/^index\.php\?tab1=welcome&tab2=forgot_password$/i',
        '/^index\.php\?tab1=welcome&tab2=password_reset&id=([A-Za-z0-9_]+)$/i',
        '/^index\.php\?tab1=([^\/]+)&query=([^\/]+)$/i',
        '/^index\.php\?tab1=([^\/]+)&tab2=([^\/]+)&tab3=([^\/]+)$/i',
        '/^index\.php\?tab1=([^\/]+)&tab2=([^\/]+)$/i',
        '/^index\.php\?tab1=([^\/]+)$/i'
    );

    $mods = array(
        $config['site_url'] . '/@$4/$1/$2/$3',
        $config['site_url'] . '/@$3/$1/$2',
        $config['site_url'] . '/@$2/$1',
        $config['site_url'] . '/@$1',
        $config['site_url'] . '/messages/$1',
        $config['site_url'] . '/story/$1',
        $config['site_url'] . '/forgot-password',
        $config['site_url'] . '/password-reset/$1',
        $config['site_url'] . '/$1/$2',
        $config['site_url'] . '/$1/$2/$3',
        $config['site_url'] . '/$1/$2',
        $config['site_url'] . '/$1'
    );

    if ($config['smooth_links'] == 1)
    {
        $url = preg_replace($urls, $mods, $url);
    }
    else
    {
        $url = $config['site_url'] . '/' . $url;
    }

    return $url;
}

/* Get months */
function getMonths()
{
    global $lang;

    $months[1] = array('january', $lang['january']);
    $months[2] = array('february', $lang['february']);
    $months[3] = array('march', $lang['march']);
    $months[4] = array('april', $lang['april']);
    $months[5] = array('may', $lang['may']);
    $months[6] = array('june', $lang['june']);
    $months[7] = array('july', $lang['july']);
    $months[8] = array('august', $lang['august']);
    $months[9] = array('september', $lang['september']);
    $months[10] = array('october', $lang['october']);
    $months[11] = array('november', $lang['november']);
    $months[12] = array('december', $lang['december']);

    return $months;
}

/* Create captcha */
function createCaptcha()
{
    $image = '';
    $image = @imagecreatetruecolor(80, 30);
    $background_color = @imagecolorallocate($image, 78, 86, 101);
    $text_color = @imagecolorallocate($image, 255, 255, 255);
    $pixel_color = @imagecolorallocate($image, 60, 75, 114);
    @imagefilledrectangle($image, 0, 0, 80, 30, $background_color);

    for ($i = 0; $i < 1000; $i++)
    {
        @imagesetpixel($image, rand() % 80, rand() % 30, $pixel_color);
    }

    $key = generateKey(6, 6, false, false, true);
    $_SESSION['captcha_key'] = $key;
    @imagestring($image, 7, 13, 8, $key, $text_color);
    $images = glob('photos/captcha_*.png');

    if (is_array($images))
    {
        foreach ($images as $image_to_delete)
        {
            @unlink($image_to_delete);
        }
    }

    $image_url = 'photos/captcha_' . time() . '_' . mt_rand(1, 9999) . '.png';
    @imagepng($image, $image_url);

    $get = array(
        'image' => $image_url
    );
    return $get;
}

/* Create random key */
function generateKey($minlength=5, $maxlength=5, $uselower=true, $useupper=true, $usenumbers=true, $usespecial=false)
{
    $charset = '';

    if ($uselower)
    {
        $charset .= "abcdefghijklmnopqrstuvwxyz";
    }

    if ($useupper)
    {
        $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    }

    if ($usenumbers)
    {
        $charset .= "123456789";
    }

    if ($usespecial)
    {
        $charset .= "~@#$%^*()_+-={}|][";
    }

    if ($minlength > $maxlength)
    {
        $length = mt_rand($maxlength, $minlength);
    }
    else
    {
        $length = mt_rand($minlength, $maxlength);
    }

    $key = '';

    for ($i = 0; $i < $length; $i++)
    {
        $key .= $charset[(mt_rand(0, strlen($charset) - 1))];
    }

    return $key;
}

/* Get languages */
function getLanguages()
{
    global $conn, $config;
    $get = array();
    $language_i = 0;
    $languages_html = array();

    $langQuery = $conn->query("SELECT DISTINCT type FROM " . DB_LANGUAGES);

    while ($langFetch = $langQuery->fetch_array(MYSQLI_ASSOC))
    {
        $language = $langFetch['type'];
        $language = str_replace('languages/', '', $language);
        $language = preg_replace('/([A-Za-z]+)\.php/i', '$1', $language);
        $language_i++;

        if ($config['smooth_links'] == 1)
        {
            $language_url = '?lang=' . $language;
        }
        else
        {
            $query_string = $_SERVER['QUERY_STRING'];
            $query_string = preg_replace('/(\&|)lang\=([A-Za-z0-9_]+)/i', '', $query_string);
            $language_url = 'index.php?' . $query_string . '&lang=' . $language;
            $escapeObj = new \miuan\Escape();
            $language_url = $escapeObj->stringEscape(strip_tags($language_url));
        }

        $languages_html[] = '<a href="' . $language_url . '">' . ucwords(str_replace('_', ' ', $language)) . '</a>';
    }

    $languagesHtml = implode(' - ', $languages_html);

    return $languagesHtml;
}

/* Get user Id */
function getUserId(\mysqli $conn, $u=0)
{
    if (is_numeric($u))
    {
        return (int) $u;
    }
    $escapeObj = new \miuan\Escape();
    $u = $escapeObj->stringEscape($u);

    if (filter_var($u, FILTER_VALIDATE_EMAIL))
    {
        $query = $conn->query("SELECT id FROM accounts WHERE email='$u'");
    }
    else
    {
        $query = $conn->query("SELECT id FROM accounts WHERE username='$u'");
    }

    if ($query->num_rows == 1)
    {
        $fetch = $query->fetch_array(MYSQLI_ASSOC);
        return $fetch['id'];
    }

    return false;
}

/* Get chat */
function SK_getChat()
{
    if (! isLogged())
    {
        return false;
    }

    if (isset($_GET['tab1']) && $_GET['tab1'] == "messages")
    {
        return false;
    }

    if (! isset($_SESSION['chat_recipient_id']) or $_SESSION['chat_recipient_id'] < 1)
    {
        return false;
    }

    $chatRecipientId = (int) $_SESSION['chat_recipient_id'];
    $chatRecipientObj = new \miuan\User();
    $chatRecipientObj->setId($chatRecipientId);
    $chatRecipient = $chatRecipientObj->getRows();

    if (empty($chatRecipient['id']))
    {
        return false;
    }

    return $chatRecipient;
}

/* Get announcements */
function getAnnouncements() {
    global $conn, $user, $themeData;
    $listAnnouncements = '';

    $query = $conn->query("SELECT * FROM " . DB_ANNOUNCEMENTS . " WHERE id NOT IN (SELECT announcement_id FROM " . DB_ANNOUNCEMENT_VIEWS . " WHERE account_id=" . $user['id'] . ") ORDER BY id DESC");

    if ($query->num_rows > 0)
    {
        while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
        {
            $themeData['list_announcement_text'] = $fetch['text'];
            $listAnnouncements .= \miuan\UI::view('announcements/list-each');
        }

        $themeData['list_announcements'] = $listAnnouncements;
        return \miuan\UI::view('announcements/content', 'announcements_ui_editor');
    }
}

/* Story postbox */
function getStoryPostBox($timelineId=0, $recipientId=0, $placeholder='') /* Publisher, Wall Owner */
{
    if (! isLogged())
    {
        return false;
    }

    global $themeData, $lang, $config;
    $continue = true;
    $timelineId = (int) $timelineId;
    $recipientId = (int) $recipientId;

    if ($timelineId < 1)
    {
        global $user;
        $timelineId = $user['id'];
    }

    $timelineObj = new \miuan\User();
    $timelineObj->setId($timelineId);
    $timeline = $timelineObj->getRows();

    if (! $timelineObj->isAdmin())
    {
        return false;
    }

    $themeData['publisher_id'] = $timeline['id'];

    if ($recipientId < 1)
    {
        $recipientId = 0;
    }

    if ($timelineId == $recipientId)
    {
        $recipientId = 0;
    }

    if ($recipientId > 0)
    {
        $recipientObj = new \miuan\User();
        $recipientObj->setId($recipientId);
        $recipient = $recipientObj->getRows();

        if (! isset($recipient['id']))
        {
            return false;
        }

        if ($recipient['type'] == "user")
        {
            if ($recipient['timeline_post_privacy'] == "following")
            {
                if (! $recipientObj->isFollowedBy($timelineId))
                {
                    $continue = false;
                }
            }
            elseif ($recipient['timeline_post_privacy'] == "none")
            {
                $continue = false;
            }
        }
        elseif ($recipient['type'] == "page")
        {
            if ($recipient['timeline_post_privacy'] != "everyone")
            {
                if (! $recipientObj->isPageAdmin())
                {
                    $continue = false;
                }
            }
        }
        elseif ($recipient['type'] == "group")
        {
            if ($recipient['timeline_post_privacy'] == "members")
            {
                $continue = false;

                if ($recipientObj->isFollowedBy() or $recipientObj->isGroupAdmin())
                {
                    $continue = true;
                }
            }
            elseif ($recipient['timeline_post_privacy'] == "admins")
            {
                if (! $recipientObj->isGroupAdmin())
                {
                    $continue = false;
                }
            }
        }

        $themeData['recipient_id'] = $recipient['id'];
    }

    if (empty($placeholder))
    {
        $placeholder = $lang['post_textarea_label'];
        $themeData['postbox_placeholder'] = $placeholder;
    }

    $emoticons = getEmoticons();
    $emoticonLists = '';

    if (is_array($emoticons)) {

        foreach ($emoticons as $emo_code => $emo_icon) {
            $emoticonLists .= '<img src="' . $emo_icon . '" width="16px" onclick="addEmoToInput(\'' . $emo_code . '\',\'.story-publisher-box textarea\');">';
        }
    }
    $themeData['list_emoticons'] = $emoticonLists;
    $themeData['create_album_url'] = smoothLink('index.php?tab1=album&tab2=create');

    $themeData['friends_label'] = $lang['friends_label'];

    if ($config['friends'] != true)
    {
        $themeData['friends_label'] = $lang['people_i_follow'];
    }

    if ($recipientId == 0 && $timeline['type'] == "user")
    {
        $themeData['privacy_selector'] = \miuan\UI::view('story/publisher-box/privacy-selector');
    }

    /* Wrappers */
    $themeData['textarea_wrapper'] = \miuan\UI::view('story/publisher-box/wrappers/textarea');
    $themeData['photos_wrapper'] = \miuan\UI::view('story/publisher-box/wrappers/photos');
    $themeData['googlemaps_wrapper'] = \miuan\UI::view('story/publisher-box/wrappers/googlemaps');
    $themeData['emoticons_wrapper'] = \miuan\UI::view('story/publisher-box/wrappers/emoticons');
    $themeData['all_wrappers'] = \miuan\UI::view('story/publisher-box/wrappers/all');
    $themeData['all_wrappers'] .= \miuan\Addons::invoke(array('new_story_feature_option', 'string'));

    /* Launcher Icons */
    $themeData['photos_launcher_icon'] = \miuan\UI::view('story/publisher-box/launcher-icons/photos');
    $themeData['googlemaps_launcher_icon'] = \miuan\UI::view('story/publisher-box/launcher-icons/googlemaps');
    $themeData['emoticons_launcher_icon'] = \miuan\UI::view('story/publisher-box/launcher-icons/emoticons');
    $themeData['all_launcher_icons'] = \miuan\UI::view('story/publisher-box/launcher-icons/all');
    $themeData['all_launcher_icons'] .= \miuan\Addons::invoke(array('new_story_feature_launchericon', 'string'));

    if ($continue == true)
    {
        return \miuan\UI::view('story/publisher-box/content', 'story_publisher_ui_editor');
    }
}

/* Get follow suggestions */
function getFollowSuggestionsData($searchQuery='', $limit=5, $type='all')
{
    if (! isLogged())
    {
        return array();
    }

    $limit = (int) $limit;
    $get = array();
    $type = (! preg_match('/(user|page|group)/i', $type)) ? 'all' : $type;

    if ($limit < 1)
    {
        $limit = 5;
    }

    global $conn, $user;

    $queryText = "SELECT id FROM " . DB_ACCOUNTS . "
    WHERE id NOT IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . ")
    AND id<>" . $user['id'];

    if ($type == "user")
    {
        $queryText .= " AND id IN (SELECT id FROM " . DB_USERS . " WHERE follow_privacy='everyone')";
    }
    elseif ($type == "page")
    {
        $queryText .= " AND id IN (SELECT id FROM " . DB_PAGES . ")";
    }
    elseif ($type == "group")
    {
        $queryText .= " AND id IN (SELECT id FROM " . DB_GROUPS . " WHERE group_privacy IN ('open','closed'))";
    }
    else
    {
        $queryText .= " AND (id IN (SELECT id FROM " . DB_USERS . " WHERE follow_privacy='everyone')
        OR id IN (SELECT id FROM " . DB_PAGES . ")
        OR id IN (SELECT id FROM " . DB_GROUPS . " WHERE group_privacy IN ('open','closed')))";
    }

    $queryText .= " AND active=1";

    if (! empty($searchQuery))
    {
        $escapeObj = new \miuan\Escape();
        $searchQuery = $escapeObj->stringEscape($searchQuery);
        $queryText .= " AND name LIKE '%$searchQuery%'";
    }

    $queryText .= " ORDER BY RAND() LIMIT $limit";
    $query = $conn->query($queryText);

    while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
    {
        $get[] = $fetch['id'];
    }

    return $get;
}

function getFollowSuggestions($searchQuery='', $limit=5, $type='all')
{
    global $lang;

    $type = (! preg_match('/(user|page|group)/i', $type)) ? 'all' : $type;

    if (! isLogged())
    {
        return array();
    }

    global $themeData;
    $suggestionsHtml = '';

    foreach (getFollowSuggestionsData($searchQuery, $limit, $type) as $k => $v)
    {
        $timelineObj = new \miuan\User();
        $timelineObj->setId($v);
        $timeline = $timelineObj->getRows();

        $themeData['list_suggestion_id'] = $timeline['id'];
        $themeData['list_suggestion_url'] = $timeline['url'];
        $themeData['list_suggestion_username'] = $timeline['username'];
        $themeData['list_suggestion_name'] = substr($timeline['name'], 0, 13);
        $themeData['list_suggestion_thumbnail_url'] = $timeline['thumbnail_url'];
        $themeData['list_suggestion_info'] = '';

        if ($timeline['type'] == "user")
        {
            if (! empty($timeline['current_city']))
            {
                $themeData['list_suggestion_info'] = $timeline['current_city'];
            }
        }
        elseif ($timeline['type'] == "page")
        {
            $category = getPageCategoryData($timeline['category_id']);
            $themeData['list_suggestion_info'] = $category['name'];
        }
        elseif ($timeline['type'] == "group")
        {
            $themeData['list_suggestion_info'] = ucwords($timeline['group_privacy']) . ' Group';

        }

        $themeData['follow_id'] = $timeline['id'];
        $themeData['list_suggestion_button'] = $timelineObj->getFollowButton();

        $suggestionsHtml .= \miuan\UI::view('suggestions/follow-suggestions-each');
    }

    $themeData['list_suggestions'] = $suggestionsHtml;
    $themeData['list_suggestions_type'] = $type;

    if ($type == "user")
    {
        $themeData['list_suggestions_header_title'] = $lang['user_follow_suggestions_label'];
    }
    elseif ($type == "page") {
        $themeData['list_suggestions_header_title'] = $lang['page_like_suggestions_label'];
    }
    elseif ($type == "group") {
        $themeData['list_suggestions_header_title'] = $lang['group_join_suggestions_label'];
    }
    else
    {
        $themeData['list_suggestions_header_title'] = $lang['follow_suggestions_label'];
    }

    return \miuan\UI::view('suggestions/follow-suggestions-content', 'suggestions_ui_editor');
}

/* Get trendings */
function getTrendings($type='latest', $limit=5)
{
    global $conn, $themeData;

    $limit = (int) $limit;
    $oldestUnix = time() - (60 * 60 * 24 * 1);

    if ($limit < 1)
    {
        $limit = 5;
    }

    if (empty($type))
    {
        return false;
    }

    if ($type == "latest")
    {
        $query = "SELECT * FROM " . DB_HASHTAGS . " WHERE last_trend_time>$oldestUnix ORDER BY last_trend_time DESC LIMIT $limit";
    }
    elseif ($type == "popular")
    {
        $query = "SELECT * FROM " . DB_HASHTAGS . " WHERE last_trend_time>$oldestUnix ORDER BY trend_use_num DESC LIMIT $limit";
    }

    $query = $conn->query($query);
    $trendingsHtml = '';

    if ($query->num_rows > 0)
    {
        while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
        {
            $fetch['url'] = smoothLink('index.php?tab1=hashtag&query=' . $fetch['tag']);
            $themeData['list_trend_id'] = $fetch['id'];
            $themeData['list_trend_url'] = $fetch['url'];
            $themeData['list_trend_tag'] = $fetch['tag'];

            $trendingsHtml .= \miuan\UI::view('trendings/list-each');
        }

        $themeData['list_trendings'] = $trendingsHtml;
        return \miuan\UI::view('trendings/content', 'trendings_ui_editor');
    }
}

/* Notifications */
function countNotifications($timelineId=0, $unread=true)
{
    if (! isLogged())
    {
        return false;
    }

    global $conn;
    $timelineId = (int) $timelineId;

    if ($timelineId < 1)
    {
        global $user;
        $timelineId = $user['id'];
        $timeline = $user;
    }
    else
    {
        global $user;
        $timelineObj = new \miuan\User();
        $timelineObj->setId($timelineId);
        $timeline = $timelineObj->getRows();
    }

    $queryText = "SELECT COUNT(id) AS count FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $timeline['id'] . " AND active=1";

    if ($unread == true)
    {
        $queryText .= " AND seen=0";
    }

    $queryText .= " ORDER BY id DESC";

    $query = $conn->query($queryText);
    $fetch = $query->fetch_array(MYSQLI_ASSOC);

    return $fetch['count'];
}

function getNotifications($timelineId=0, $unread=false, $all=false)
{
    if (! isLogged())
    {
        return array();
    }

    $get = array();
    $timelineId = (int) $timelineId;

    if ($timelineId < 1)
    {
        global $user, $userObj;
        $timelineId = $user['id'];
        $timelineObj = $userObj;
        $timeline = $user;
    }
    else
    {
        $timelineObj = new \miuan\User();
        $timelineObj->setId($timelineId);
        $timeline = $timelineObj->getRows();
    }

    if (! $timelineObj->isAdmin())
    {
        return array();
    }

    $new_notif = countNotifications();

    if ($new_notif > 0)
    {
        $queryText = "SELECT id,notifier_id,post_id,seen,text,time,timestamp,timeline_id,url FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $timelineId . " AND active=1 AND seen=0 ORDER BY id DESC";
    }
    else
    {
        $queryText = "SELECT id,notifier_id,post_id,seen,text,time,timestamp,timeline_id,url FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $timelineId . " AND active=1";

        if ($unread)
        {
            $queryText .= " AND seen=0";
        }

        $queryText .= " ORDER BY id DESC LIMIT 20";
    }

    if ($all)
    {
        $queryText = "SELECT id,notifier_id,post_id,seen,text,time,timestamp,timeline_id,url FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $timelineId . " AND active=1 AND seen=0 ORDER BY id DESC LIMIT 20";
    }

    global $conn;
    $query = $conn->query($queryText);

    if ($query->num_rows > 0)
    {
        while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
        {
            $notifierObj = new \miuan\User();
            $notifierObj->setId($fetch['notifier_id']);
            $fetch['notifier'] = $notifierObj->getRows();

            $fetch['raw_url'] = $fetch['url'];
            $fetch['url'] = smoothLink($fetch['url']);

            $fetch['text'] = preg_replace(
                '/\[b(| weight\=)(|[0-9]+)\](.*?)\[\/b\]/i',
                '<strong style="font-weight: $2;">$3</strong>',
                $fetch['text']
            );
            $get[] = $fetch;
        }
    }

    $conn->query("DELETE FROM " . DB_NOTIFICATIONS . " WHERE time<" . (time() - (60 * 60 * 24 * 2)) . " AND seen>0");
    return $get;
}

/* Count messages */
function countMessages($timelineId=0, $recipientId=0, $new=true)
{
    if (! isLogged())
    {
        return false;
    }

    global $conn, $user;
    $timelineId = (int) $timelineId;
    $recipientId = (int) $recipientId;

    if ($timelineId < 1)
    {
        $timelineId = $user['id'];
    }

    $timelineObj = new \miuan\User();
    $timelineObj->setId($timelineId);
    $timeline = $timelineObj->getRows();

    if (empty($timeline['id']))
    {
        return false;
    }

    if (! $timelineObj->isAdmin()) {
        return false;
    }

    if ($recipientId > 0)
    {
        if ($new)
        {
            $queryText = "SELECT COUNT(id) AS count FROM " . DB_MESSAGES . " WHERE active=1 AND timeline_id=$recipientId AND recipient_id=$timelineId";
        }
        else
        {
            $queryText = "SELECT COUNT(id) AS count FROM " . DB_MESSAGES . " WHERE active=1 AND ((timeline_id=$recipientId AND recipient_id=$timelineId) OR (timeline_id=$timelineId AND recipient_id=$recipientId))";
        }
    }
    else
    {
        $queryText = "SELECT COUNT(DISTINCT timeline_id) AS count FROM " . DB_MESSAGES . " WHERE active=1 AND recipient_id=$timelineId";
    }

    if ($new)
    {
        $queryText .= " AND seen=0";
    }

    $query = $conn->query($queryText);
    $fetch = $query->fetch_array(MYSQLI_ASSOC);

    return $fetch['count'];
}

/* Count follow requests */
function countFollowRequests($timelineId=0)
{
    if (! isLogged())
    {
        return false;
    }

    global $conn, $user;
    $timelineId = (int) $timelineId;

    if ($timelineId < 1)
    {
        $timelineId = $user['id'];
        $timeline = $user;
    }
    else
    {
        $timelineObj = new \miuan\User();
        $timelineObj->setId($timelineId);
        $timeline = $timelineObj->getRows();
    }

    $query = $conn->query("SELECT COUNT(id) AS count FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT follower_id FROM " . DB_FOLLOWERS . " WHERE following_id=$timelineId AND follower_id<>$timelineId AND active=0) AND active=1");
    $fetch = $query->fetch_array(MYSQLI_ASSOC);

    return $fetch['count'];
}

/* Get emoticons */
function getEmoticons()
{
    global $config, $emo;
    $emoticon = array();

    if (! isset($emo) or ! is_array($emo))
    {
        return false;
    }

    foreach ($emo as $code => $img)
    {
        $emoticon[addslashes($code)] = $config['theme_url'] . '/emoticons/' . $img;
    }

    return array_unique($emoticon);
}

function getManagedPages()
{
    if (! isLogged())
    {
        return array();
    }

    global $conn, $user;
    $get = array();

    $query = $conn->query("SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT page_id FROM " . DB_PAGE_ADMINS . " WHERE admin_id=" . $user['id'] . " AND page_id IN (SELECT id FROM " . DB_PAGES .") AND active=1) AND type='page' AND active=1");

    while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
    {
        $timelineObj = new \miuan\User();
        $timelineObj->setId($fetch['id']);
        $get[] = $timelineObj->getRows();
    }

    return $get;
}

function getManagedGroups()
{
    if (! isLogged())
    {
        return array();
    }

    global $conn, $user;
    $get = array();

    $query = $conn->query("SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT group_id FROM " . DB_GROUP_ADMINS . " WHERE admin_id=" . $user['id'] . " AND group_id IN (SELECT id FROM " . DB_GROUPS .") AND active=1) AND type='group' AND active=1");

    while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
    {
        $timelineObj = new \miuan\User();
        $timelineObj->setId($fetch['id']);
        $get[] = $timelineObj->getRows();
    }

    return $get;
}

/* Get page categories */
function getPageCategories($catId=0, $check_only=false) {
    if (! isLogged()) {
        return array();
    }

    global $conn;
    $get = array();
    $catId = (int) $catId;

    if ($check_only == true)
    {
        $query = $conn->query("SELECT id FROM " . DB_PAGE_CATEGORIES . " WHERE id=$catId AND active=1");
        return $query->num_rows;
    }
    else
    {
        $query = $conn->query("SELECT id,category_id,name FROM " . DB_PAGE_CATEGORIES . " WHERE category_id=$catId AND active=1");

        while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
        {
            $get[] = $fetch;
        }
    }

    return $get;
}

/* Get page category data */
function getPageCategoryData($catId=0)
{
    global $conn, $lang;
    $catId = (int) $catId;
    $query = $conn->query("SELECT * FROM " . DB_PAGE_CATEGORIES . " WHERE id=$catId AND active=1");

    if ($query->num_rows == 1)
    {
        $fetch = $query->fetch_array(MYSQLI_ASSOC);
        $fetch['key'] = $fetch['name'];
        $fetch['name'] = $lang[$fetch['name']];
        return $fetch;
    }
}

/* Validate username */
function validateUsername($u)
{
    if (strlen($u) > 3 && ! is_numeric($u) && preg_match('/^[A-Za-z0-9_]+$/', $u))
    {
        return true;
    }
}

/* Get username status */
function getUsernameStatus($query='', $timelineId=0)
{
    $escapeObj = new \miuan\Escape();
    $query = $escapeObj->stringEscape($query);
    $timelineId = (int) $timelineId;

    if (! validateUsername($query))
    {
        return 406;
    }

    if (strlen($query) < 4)
    {
        return 410;
    }

    /*if ($timelineId < 1)
    {
        if (isLogged())
        {
            global $user;
            $timelineId = $user['id'];
        }
    }*/

    if (isLogged())
    {
        if ($timelineId < 1)
        {
            global $user, $userObj;
            $timelineId = $user['id'];
            $timelineObj = $userObj;
            $timeline = $user;

            if ($query == $user['username'])
            {
                return 201;
            }
        }
        else
        {
            $timelineId = (int) $timelineId;
            $timelineObj = new \miuan\User();
            $timelineObj->setId($timelineId);
            $timeline = $timelineObj->getRows();
        }

        if (empty($timeline['id']))
        {
            return false;
        }

        if (! $timelineObj->isAdmin())
        {
            return false;
        }

        if ($query == $timeline['username'])
        {
            return 201;
        }
    }

    global $conn;
    $query = $conn->query("SELECT id FROM " . DB_ACCOUNTS . " WHERE username='$query'");

    if ($query->num_rows == 0)
    {
        return 200;
    }
    else
    {
        return 410;
    }
}

/* Register Media */
function registerMedia($upload, $album_id=0)
{
    if (! isLogged()) {
        return false;
    }

    global $conn, $user;

    if (! file_exists('photos/' . date('Y')))
    {
        mkdir('photos/' . date('Y'), 0777, true);
    }

    if (! file_exists('photos/' . date('Y') . '/' . date('m')))
    {
        mkdir('photos/' . date('Y') . '/' . date('m'), 0777, true);
    }

    $photo_dir = 'photos/' . date('Y') . '/' . date('m');

    if (is_uploaded_file($upload['tmp_name']))
    {
        $escapeObj = new \miuan\Escape();
        $upload['name'] = $escapeObj->stringEscape($upload['name']);
        $name = preg_replace('/([^A-Za-z0-9_\-\.]+)/i', '', $upload['name']);
        $ext = strtolower(substr($upload['name'], strrpos($upload['name'], '.') + 1, strlen($upload['name']) - strrpos($upload['name'], '.')));

        if ($upload['size'] > 1024)
        {
            if (preg_match('/(jpg|jpeg|png|gif)/', $ext))
            {
                list($width, $height) = getimagesize($upload['tmp_name']);

                $query = $conn->query("INSERT INTO " . DB_MEDIA . " (extension,name,type) VALUES ('$ext','$name','photo')");

                if ($query)
                {
                    $sql_id = $conn->insert_id;
                    $original_file_name = $photo_dir . '/' . generateKey() . '_' . $sql_id . '_' . md5($sql_id);
                    $original_file = $original_file_name . '.' . $ext;

                    if (move_uploaded_file($upload['tmp_name'], $original_file))
                    {
                        @fixOrientation($original_file);

                        $min_size = $width;

                        if ($width > $height)
                        {
                            $min_size = $height;
                        }

                        $min_size = floor($min_size);

                        if ($min_size > 920)
                        {
                            $min_size = 920;
                        }

                        $imageSizes = array(
                            'thumb' => array(
                                'type' => 'crop',
                                'width' => 64,
                                'height' => 64,
                                'name' => $original_file_name . '_thumb'
                            ),
                            '100x100' => array(
                                'type' => 'crop',
                                'width' => $min_size,
                                'height' => $min_size,
                                'name' => $original_file_name . '_100x100'
                            ),
                            '100x75' => array(
                                'type' => 'crop',
                                'width' => $min_size,
                                'height' => floor($min_size * 0.75),
                                'name' => $original_file_name . '_100x75'
                            )
                        );

                        foreach ($imageSizes as $ratio => $data)
                        {
                            $save_file = $data['name'] . '.' . $ext;
                            processMedia($data['type'], $original_file, $save_file, $data['width'], $data['height']);
                        }

                        processMedia('resize', $original_file, $original_file, $min_size, 0);

                        $conn->query("UPDATE " . DB_MEDIA . " SET timeline_id=" . $user['id'] . ",album_id=$album_id,url='$original_file_name',temp=0,active=1 WHERE id=$sql_id");

                        $get = array(
                            'id' => $sql_id,
                            'active' => 1,
                            'extension' => $ext,
                            'name' => $name,
                            'url' => $original_file_name
                        );

                        return $get;
                    }
                }
            }
        }
    }
}

/* Fix Orientation */
function fixOrientation($path)
{
    if (file_exists ($path))
    {
        if (strrpos($path, '.'))
        {
            $ext = substr($path, strrpos($path,'.') + 1, strlen($path) - strrpos($path, '.'));

            if (in_array($ext, array('jpeg', 'jpg')))
            {
                $fxt = true;
            }
        }
    }

    if (! isset($fxt))
    {
        return false;
    }

    $image = imagecreatefromjpeg($path);
    $exif = exif_read_data($path);

    if (!empty($exif['Orientation']))
    {
        switch ($exif['Orientation'])
        {
            case 3:
                $image = imagerotate($image, 180, 0);
                break;

            case 6:
                $image = imagerotate($image, -90, 0);
                break;

            case 8:
                $image = imagerotate($image, 90, 0);
                break;
        }
    }

    imagejpeg($image, $path);
    return true;
}

/* Process Images */
function processMedia($run, $photo_src, $save_src, $width=0, $height=0, $quality=80)
{

    if (! is_numeric($quality) or $quality < 0 or $quality > 100)
    {
        $quality = 80;
    }

    if (file_exists ($photo_src))
    {
        if (strrpos($photo_src, '.'))
        {
            $ext = substr($photo_src, strrpos($photo_src,'.') + 1, strlen($photo_src) - strrpos($photo_src, '.'));
            $fxt = (in_array($ext, array('jpeg', 'png', 'gif'))) ? $ext : "jpeg";
        }
        else
        {
            $ext = $fxt = 0;
        }

        if (preg_match('/(jpg|jpeg|png|gif)/', $ext))
        {
            if ($fxt == "gif")
            {
                copy($photo_src, $save_src);
                return true;
            }

            list($photo_width, $photo_height) = getimagesize($photo_src);
            $create_from = "imagecreatefrom" . $fxt;
            $photo_source = $create_from($photo_src);

            if ($run == "crop")
            {
                if ($width > 0 && $height > 0)
                {
                    $crop_width = $photo_width;
                    $crop_height = $photo_height;
                    $k_w = 1;
                    $k_h = 1;
                    $dst_x = 0;
                    $dst_y = 0;
                    $src_x = 0;
                    $src_y = 0;

                    if ($width == 0 or $width > $photo_width)
                    {
                        $width = $photo_width;
                    }

                    if ($height == 0 or $height > $photo_height)
                    {
                        $height = $photo_height;
                    }

                    $crop_width = $width;
                    $crop_height = $height;

                    if ($crop_width > $photo_width)
                    {
                        $dst_x = ($crop_width - $photo_width) / 2;
                    }

                    if ($crop_height > $photo_height)
                    {
                        $dst_y = ($crop_height - $photo_height) / 2;
                    }

                    if ($crop_width < $photo_width || $crop_height < $photo_height)
                    {
                        $k_w = $crop_width / $photo_width;
                        $k_h = $crop_height / $photo_height;

                        if ($crop_height > $photo_height)
                        {
                            $src_x  = ($photo_width - $crop_width) / 2;
                        }
                        elseif ($crop_width > $photo_width)
                        {
                            $src_y  = ($photo_height - $crop_height) / 2;
                        }
                        else
                        {
                            if ($k_h > $k_w)
                            {
                                $src_x = round(($photo_width - ($crop_width / $k_h)) / 2);
                            }
                            else
                            {
                                $src_y = round(($photo_height - ($crop_height / $k_w)) / 2);
                            }
                        }
                    }

                    $crop_image = @imagecreatetruecolor($crop_width, $crop_height);

                    if ($ext == "png")
                    {
                        @imagesavealpha($crop_image, true);
                        @imagefill($crop_image, 0, 0, @imagecolorallocatealpha($crop_image, 0, 0, 0, 127));
                    }

                    @imagecopyresampled($crop_image, $photo_source ,$dst_x, $dst_y, $src_x, $src_y, $crop_width - 2 * $dst_x, $crop_height - 2 * $dst_y, $photo_width - 2 * $src_x, $photo_height - 2 * $src_y);

                    @imageinterlace($crop_image, true);

                    if ($fxt == "jpeg")
                    {
                        @imagejpeg($crop_image, $save_src, $quality);
                    }
                    elseif ($fxt == "png")
                    {
                        @imagepng($crop_image, $save_src);
                    }
                    elseif ($fxt == "gif")
                    {
                        @imagegif($crop_image, $save_src);
                    }

                    @imagedestroy($crop_image);
                }
            }
            elseif ($run == "resize")
            {
                if ($width == 0 && $height == 0)
                {
                    return false;
                }

                if ($width > 0 && $height == 0)
                {
                    $resize_width = $width;
                    $resize_ratio = $resize_width / $photo_width;
                    $resize_height = floor($photo_height * $resize_ratio);
                }
                elseif ($width == 0 && $height > 0)
                {
                    $resize_height = $height;
                    $resize_ratio = $resize_height / $photo_height;
                    $resize_width = floor($photo_width * $resize_ratio);
                }
                elseif ($width > 0 && $height > 0)
                {
                    $resize_width = $width;
                    $resize_height = $height;
                }

                if ($resize_width > 0 && $resize_height > 0)
                {
                    $resize_image = @imagecreatetruecolor($resize_width, $resize_height);

                    if ($ext == "png")
                    {
                        @imagesavealpha($resize_image, true);
                        @imagefill($resize_image, 0, 0, @imagecolorallocatealpha($resize_image, 0, 0, 0, 127));
                    }

                    @imagecopyresampled($resize_image, $photo_source, 0, 0, 0, 0, $resize_width, $resize_height, $photo_width, $photo_height);
                    @imageinterlace($resize_image, true);

                    if ($fxt == "jpeg")
                    {
                        @imagejpeg($resize_image, $save_src, $quality);
                    }
                    elseif ($fxt == "png")
                    {
                        @imagepng($resize_image, $save_src);
                    }
                    elseif ($fxt == "gif")
                    {
                        @imagegif($resize_image, $save_src);
                    }

                    @imagedestroy($resize_image);
                }
            }
            elseif ($run == "scale")
            {
                if ($width == 0)
                {
                    $width = 100;
                }

                if ($height == 0)
                {
                    $height = 100;
                }

                $scale_width = $photo_width * ($width / 100);
                $scale_height = $photo_height * ($height / 100);
                $scale_image = @imagecreatetruecolor($scale_width, $scale_height);

                if ($ext == "png")
                {
                    @imagesavealpha($scale_image, true);
                    @imagefill($scale_image, 0, 0, imagecolorallocatealpha($scale_image, 0, 0, 0, 127));
                }

                @imagecopyresampled($scale_image, $photo_source, 0, 0, 0, 0, $scale_width, $scale_height, $photo_width, $photo_height);
                @imageinterlace($scale_image, true);

                if ($fxt == "jpeg")
                {
                    @imagejpeg($scale_image, $save_src, $quality);
                }
                elseif ($fxt == "png")
                {
                    @imagepng($scale_image, $save_src);
                }
                elseif ($fxt == "gif")
                {
                    @imagegif($scale_image, $save_src);
                }

                @imagedestroy($scale_image);
            }
        }
    }
}

/* Register cover */
function registerCoverImage($upload, $pos=0)
{
    if (! isLogged())
    {
        return false;
    }

    global $conn;

    if (! file_exists('photos/' . date('Y')))
    {
        mkdir('photos/' . date('Y'), 0777, true);
    }

    if (! file_exists('photos/' . date('Y') . '/' . date('m')))
    {
        mkdir('photos/' . date('Y') . '/' . date('m'), 0777, true);
    }

    $photo_dir = 'photos/' . date('Y') . '/' . date('m');

    if (is_uploaded_file($upload['tmp_name']))
    {
        $escapeObj = new \miuan\Escape();
        $upload['name'] = $escapeObj->stringEscape($upload['name']);
        $name = preg_replace('/([^A-Za-z0-9_\-\.]+)/i', '', $upload['name']);
        $ext = strtolower(substr($upload['name'], strrpos($upload['name'], '.') + 1, strlen($upload['name']) - strrpos($upload['name'], '.')));

        if ($upload['size'] > 1024)
        {
            if (preg_match('/(jpg|jpeg|png)/', $ext))
            {
                list($width, $height) = getimagesize($upload['tmp_name']);

                $query = $conn->query("INSERT INTO " . DB_MEDIA . " (extension,name,type) VALUES ('$ext','$name','photo')");

                if ($query)
                {
                    $sql_id = $conn->insert_id;
                    $original_file_name = $photo_dir . '/' . generateKey() . '_' . $sql_id . '_' . md5($sql_id);
                    $original_file = $original_file_name . '.' . $ext;

                    if (move_uploaded_file($upload['tmp_name'], $original_file))
                    {
                        processMedia('resize', $original_file, $original_file, $width, 0, 100);

                        $img = $original_file;
                        $cover_img_url = $original_file_name . '_cover.' . $ext;
                        $dst_x = 0;
                        $dst_y = 0;
                        $src_x = 0;
                        $src_y = 0;
                        $dst_w = $width;
                        $dst_h = $dst_w * (0.3);
                        $src_w = $width;
                        $src_h = $dst_h;

                        if (! empty($pos) && is_numeric($pos) && $pos < $width)
                        {
                            $pos = $escapeObj->stringEscape($pos);
                            $src_y = $width * $pos;
                        }

                        $cover_img = imagecreatetruecolor($dst_w, $dst_h);

                        if ($ext == "png")
                        {
                            $image = imagecreatefrompng($img);
                        }
                        else
                        {
                            $image = imagecreatefromjpeg($img);
                        }

                        imagecopyresampled($cover_img, $image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
                        imagejpeg($cover_img, $cover_img_url, 100);

                        $conn->query("UPDATE " . DB_MEDIA . " SET url='$original_file_name',temp=0,active=1 WHERE id=$sql_id");

                        $get = array(
                            'id' => $sql_id,
                            'active' => 1,
                            'extension' => $ext,
                            'name' => $name,
                            'url' => $original_file_name,
                            'cover_url' => $original_file_name . '_cover.' . $ext
                        );

                        return $get;
                    }
                }
            }
        }
    }
}

function createCover($cover_id=0, $pos=0)
{
    if (! isLogged()) {
        return false;
    }

    global $conn;
    $cover_id = (int) $cover_id;

    $query = $conn->query("SELECT * FROM " . DB_MEDIA . " WHERE id=$cover_id");

    if ($query->num_rows == 1)
    {
        $cover = $query->fetch_array(MYSQLI_ASSOC);
        $img = $cover['url'] . '.' . $cover['extension'];
        $cover_img_url = $cover['url'] . '_cover.' . $cover['extension'];

        list($width, $height) = getimagesize($img);
        $dst_x = 0;
        $dst_y = 0;
        $src_x = 0;
        $src_y = 0;
        $dst_w = $width;
        $dst_h = $dst_w * (0.3);
        $src_w = $width;
        $src_h = $dst_h;

        if (!empty($pos) && is_numeric($pos) && $pos < $width)
        {
            $escapeObj = new \miuan\Escape();
            $pos = $escapeObj->stringEscape($pos);
            $src_y = $width * $pos;
        }

        $cover_img = imagecreatetruecolor($dst_w, $dst_h);

        if ($cover['extension'] == "png")
        {
            $image = imagecreatefrompng($img);
        }
        else
        {
            $image = imagecreatefromjpeg($img);
        }

        imagecopyresampled($cover_img, $image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
        imagejpeg($cover_img, $cover_img_url, 100);
        return $cover_img_url;
    }
}

/* Update Timeline */
function updateTimeline($data=array())
{
    if (! isLogged())
    {
        return false;
    }

    global $conn;
    $timelineId = 0;

    if (isset($data['timeline_id']))
    {
        $timelineId = (int) $data['timeline_id'];
    }

    if ($timelineId < 1)
    {
        global $user, $userObj;
        $timelineId = $user['id'];
        $timelineObj = $userObj;
        $timeline = $user;
    }
    else
    {
        $timelineObj = new \miuan\User();
        $timelineObj->setId($timelineId);
        $timeline = $timelineObj->getRows();

        if (! isset ($timeline['id']))
        {
            return false;
        }
    }

    if (! $timelineObj->isAdmin())
    {
        return false;
    }

    $update_query_one = "UPDATE " . DB_ACCOUNTS . " SET ";
    $escapeObj = new \miuan\Escape();

    if (! empty($data['name']))
    {
        $name = $escapeObj->stringEscape($data['name']);
        $update_query_one .= "name='$name',";
    }

    if (! empty($data['username']))
    {
        $username = $escapeObj->stringEscape($data['username']);

        if (validateUsername($username) && getUsernameStatus($username, $timelineId) == 200)
        {
            $update_query_one .= "username='$username',";
        }
        elseif (getUsernameStatus($username, $timelineId) == 201)
        {
            // do nothing!
        }
        else
        {
            return false;
        }
    }

    if (! empty($data['about']))
    {
        $about = $escapeObj->postEscape($data['about']);
        $update_query_one .= "about='$about',";
    }

    if ($timeline['type'] == "user")
    {
        if (! empty($data['email']))
        {
            $email = $escapeObj->stringEscape($data['email']);
            $update_query_one .= "email='$email',";
        }

        if (isset($data['timezone']))
        {
            $timezone = $escapeObj->stringEscape($data['timezone']);
            $timezones = getTimezones();

            if (! empty($timezones[$timezone]))
            {
                $update_query_one .= "timezone='$timezone',";
            }
        }

        if (! empty($data['new_password']) && ! empty($data['current_password']))
        {
            $updatePass = false;
            $passwordQuery = $conn->query("SELECT password FROM " . DB_ACCOUNTS . " WHERE id=" . $timelineId);

            if ($passwordQuery->num_rows == 1)
            {
                $passwordFetch = $passwordQuery->fetch_array(MYSQLI_ASSOC);

                if (md5(trim($data['current_password'])) == $passwordFetch['password'])
                {
                    $updatePass = true;
                }
            }

            if ($updatePass)
            {
                $newPassword = md5(trim($escapeObj->stringEscape($data['new_password'])));
                $update_query_one .= "password='$newPassword',";
            }
            else
            {
                return false;
            }
        }
    }

    if (isset($data['avatar']['name']))
    {
        $avatar = $data['avatar'];
        $avatarData = registerMedia($avatar);

        if (isset($avatarData['id']))
        {
            $update_query_one .= "avatar_id=" . $avatarData['id'] . ",";
        }
    }

    if (isset($data['cover']['name']))
    {
        $cover = $data['cover'];
        $coverData = registerMedia($cover);

        if (isset($coverData['id']))
        {
            $update_query_one .= "cover_id=" . $coverData['id'] . ",";
        }
    }

    $update_query_one .= "active=1 WHERE id=" . $timelineId;
    $sql_query_one = $conn->query($update_query_one);

    if (! $sql_query_one)
    {
        return false;
    }

    unset($_SESSION['tempche']['user'][$timelineId]);

    if ($timeline['type'] == "user")
    {
        $update_query_two = "UPDATE " . DB_USERS . " SET ";

        if (isset($data['birthday']) && is_array($data['birthday']))
        {
            $birthday = $escapeObj->stringEscape(implode('-', $data['birthday']));
            $update_query_two .= "birthday='$birthday',";
        }

        if (! empty($data['gender']))
        {
            $data['gender'] = $escapeObj->stringEscape($data['gender']);

            if (preg_match('/(male|female)/', $data['gender']))
            {
                $update_query_two .= "gender='" . $data['gender'] . "',";
            }
            else
            {
                return false;
            }
        }

        if (isset($data['current_city']))
        {
            $location = $escapeObj->stringEscape($data['current_city']);
            $update_query_two .= "current_city='$location',";
        }

        if (isset($data['hometown']))
        {
            $hometown = $escapeObj->stringEscape($data['hometown']);
            $update_query_two .= "hometown='$hometown',";
        }

        if (isset($data['confirm_followers']) && preg_match('/(0|1)/', $data['confirm_followers']))
        {
            $confirmFollowers = (int) $data['confirm_followers'];
            $update_query_two .= "confirm_followers=$confirmFollowers,";
        }

        if (isset($data['follow_privacy']) && preg_match('/(everyone|following)/', $data['follow_privacy']))
        {
            $followPrivacy = $data['follow_privacy'];
            $update_query_two .= "follow_privacy='$followPrivacy',";
        }

        if (isset($data['comment_privacy']) && preg_match('/(everyone|following)/', $data['comment_privacy']))
        {
            $commentPrivacy = $data['comment_privacy'];
            $update_query_two .= "comment_privacy='$commentPrivacy',";
        }

        if (isset($data['message_privacy']) && preg_match('/(everyone|following)/', $data['message_privacy']))
        {
            $messagePrivacy = $data['message_privacy'];
            $update_query_two .= "message_privacy='$messagePrivacy',";
        }

        if (isset($data['timeline_post_privacy']) && preg_match('/(everyone|following|none)/', $data['timeline_post_privacy']))
        {
            $timelinePostPrivacy = $data['timeline_post_privacy'];
            $update_query_two .= "timeline_post_privacy='$timelinePostPrivacy',";
        }

        if (isset($data['post_privacy']) && preg_match('/(everyone|following)/', $data['post_privacy'])) {
            $postPrivacy = $data['post_privacy'];
            $update_query_two .= "post_privacy='$postPrivacy',";
        }

        if (isset($data['mailnotif_settings']))
        {
            if (isset($data['mailnotif_follow']))
            {
                $mailnotifFollow = (int) $data['mailnotif_follow'];
                $update_query_two .= "mailnotif_follow=$mailnotifFollow,";
            }
            else
            {
                $update_query_two .= "mailnotif_follow=0,";
            }

            if (isset($data['mailnotif_friendrequests']))
            {
                $mailnotifFriendrequests = (int) $data['mailnotif_friendrequests'];
                $update_query_two .= "mailnotif_friendrequests=$mailnotifFriendrequests,";
            }
            else
            {
                $update_query_two .= "mailnotif_friendrequests=0,";
            }

            if (isset($data['mailnotif_comment']))
            {
                $mailnotifComment = (int) $data['mailnotif_comment'];
                $update_query_two .= "mailnotif_comment=$mailnotifComment,";
            }
            else
            {
                $update_query_two .= "mailnotif_comment=0,";
            }

            if (isset($data['mailnotif_postlike']))
            {
                $mailnotifPostlike = (int) $data['mailnotif_postlike'];
                $update_query_two .= "mailnotif_postlike=$mailnotifPostlike,";
            }
            else
            {
                $update_query_two .= "mailnotif_postlike=0,";
            }

            if (isset($data['mailnotif_postshare']))
            {
                $mailnotifPostShare = (int) $data['mailnotif_postshare'];
                $update_query_two .= "mailnotif_postshare=$mailnotifPostShare,";
            }
            else
            {
                $update_query_two .= "mailnotif_postshare=0,";
            }

            if (isset($data['mailnotif_groupjoined']))
            {
                $mailnotifGroupJoined = (int) $data['mailnotif_groupjoined'];
                $update_query_two .= "mailnotif_groupjoined=$mailnotifGroupJoined,";
            }
            else
            {
                $update_query_two .= "mailnotif_groupjoined=0,";
            }

            if (isset($data['mailnotif_pagelike']))
            {
                $mailnotifPagelike = (int) $data['mailnotif_pagelike'];
                $update_query_two .= "mailnotif_pagelike=$mailnotifPagelike,";
            }
            else
            {
                $update_query_two .= "mailnotif_pagelike=0,";
            }

            if (isset($data['mailnotif_message']))
            {
                $mailnotifMessage = (int) $data['mailnotif_message'];
                $update_query_two .= "mailnotif_message=$mailnotifMessage,";
            }
            else
            {
                $update_query_two .= "mailnotif_message=0,";
            }

            if (isset($data['mailnotif_timelinepost']))
            {
                $mailnotifTimelinepost = (int) $data['mailnotif_timelinepost'];
                $update_query_two .= "mailnotif_timelinepost=$mailnotifTimelinepost,";
            }
            else
            {
                $update_query_two .= "mailnotif_timelinepost=0,";
            }
        }

        $update_query_two .= "id=id WHERE id=" . $timeline['id'];
        $sql_query_two = $conn->query($update_query_two);

        if ($sql_query_two)
        {
            return true;
        }
    }
    elseif ($timeline['type'] == "page")
    {
        $update_query_two = "UPDATE " . DB_PAGES . " SET ";

        if (isset($data['timeline_post_privacy']) && preg_match('/(everyone|none)/', $data['timeline_post_privacy']))
        {
            $timelinePostPrivacy = $data['timeline_post_privacy'];
            $update_query_two .= "timeline_post_privacy='$timelinePostPrivacy',";
        }

        if (isset($data['message_privacy']) && preg_match('/(everyone|none)/', $data['message_privacy']))
        {
            $messagePrivacy = $data['message_privacy'];
            $update_query_two .= "message_privacy='$messagePrivacy',";
        }

        if (! empty($data['address']))
        {
            $address = $escapeObj->stringEscape($data['address']);
            $update_query_two .= "address='$address',";
        }

        if (! empty($data['awards']))
        {
            $awards = $escapeObj->stringEscape($data['awards']);
            $update_query_two .= "awards='$awards',";
        }

        if (! empty($data['phone']))
        {
            $phone = $escapeObj->stringEscape($data['phone']);
            $update_query_two .= "phone='$phone',";
        }

        if (! empty($data['products']))
        {
            $products = $escapeObj->stringEscape($data['products']);
            $update_query_two .= "products='$products',";
        }

        if (! empty($data['website']))
        {
            $website = $escapeObj->stringEscape($data['website']);
            $update_query_two .= "website='$website',";
        }

        $update_query_two .= "id=id WHERE id=" . $timeline['id'];
        $sql_query_two = $conn->query($update_query_two);

        if ($sql_query_two)
        {
            return true;
        }
    }
    elseif ($timeline['type'] == "group")
    {
        $update_query_two = "UPDATE ". DB_GROUPS ." SET ";

        if (! empty($data['group_privacy']) && preg_match('/(open|closed|secret)/', $data['group_privacy']))
        {
            $groupPrivacy = $escapeObj->stringEscape($data['group_privacy']);
            $update_query_two .= "group_privacy='$groupPrivacy',";
        }

        if (!empty($data['add_privacy']) && preg_match('/(members|admins)/', $data['add_privacy']))
        {
            $addPrivacy = $escapeObj->stringEscape($data['add_privacy']);
            $update_query_two .= "add_privacy='$addPrivacy',";
        }

        if (! empty($data['timeline_post_privacy']))
        {
            $timelinePostPrivacy = $escapeObj->stringEscape($data['timeline_post_privacy']);
            $update_query_two .= "timeline_post_privacy='$timelinePostPrivacy',";
        }

        $update_query_two .= "id=id WHERE id=" . $timeline['id'];
        $sql_query_two = $conn->query($update_query_two);

        if ($sql_query_two) {
            return true;
        }
    }
}

/* Hashtags */
function getHashtag($tag='', $update=true)
{
    global $conn;
    $create = false;
    $escapeObj = new \miuan\Escape();
    $tag = $escapeObj->stringEscape($tag);

    if (empty($tag))
    {
        return false;
    }

    if (is_numeric($tag))
    {
        $query = $conn->query("SELECT * FROM " . DB_HASHTAGS . " WHERE id=$tag");
    }
    else
    {
        $query = $conn->query("SELECT * FROM " . DB_HASHTAGS . " WHERE tag='$tag'");
        $create = true;
    }

    if ($query->num_rows == 1)
    {
        $fetch = $query->fetch_array(MYSQLI_ASSOC);

        $trendNum = $fetch['trend_use_num'] + 1;
        $conn->query("UPDATE " . DB_HASHTAGS . " SET trend_use_num=$trendNum WHERE id=" . $fetch['id']);

        if ($update == true)
        {
            $conn->query("UPDATE " . DB_HASHTAGS . " SET last_trend_time=". time() . " WHERE id=" . $fetch['id']);
        }

        return $fetch;
    }
    elseif ($query->num_rows == 0)
    {
        if ($create == true)
        {
            $hash = md5($tag);
            $query2 = $conn->query("INSERT INTO " . DB_HASHTAGS . " (hash,tag,last_trend_time) VALUES ('$hash','$tag'," . time() . ")");

            if ($query2)
            {
                $sqlId = $conn->insert_id;
                $get = array(
                    'id' => $sqlId,
                    'hash' => $hash,
                    'tag' => $tag,
                    'last_trend_time' => time(),
                    'trend_use_num' => 0
                );

                return $get;
            }
        }
    }
}

function getHashtagSearch($tag='', $limit=4)
{
    global $conn;
    $get = array();
    $escapeObj = new \miuan\Escape();
    $tag = $escapeObj->stringEscape($tag);
    $limit = (int) $limit;

    if (empty($tag))
    {
        return false;
    }

    $tag = str_replace('#', '', $tag);

    if ($limit < 1)
    {
        $limit = 5;
    }

    if (is_numeric($tag))
    {
        $query = $conn->query("SELECT * FROM " . DB_HASHTAGS . " WHERE id=$tag LIMIT $limit");
    }
    else
    {
        $query = $conn->query("SELECT * FROM " . DB_HASHTAGS . " WHERE tag LIKE _utf8'%$tag%' collate utf8_general_ci LIMIT $limit");
    }

    if ($query->num_rows > 0)
    {
        while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
        {
            $get[] = $fetch;
        }

        return $get;
    }
}

function getHashtagSearchTemplate($a, $b)
{
    global $themeData;
    $results = getHashtagSearch($a, $b);
    $template = '';

    if (is_array($results))
    {
        foreach ($results as $k => $v)
        {
            $themeData['search_hash'] = $v['hash'];
            $themeData['search_tag'] = $v['tag'];
            $themeData['search_url'] = smoothLink('index.php?tab1=hashtag&query=' . $v['tag']);

            $template .= \miuan\UI::view('header/hashtag-result');
        }
    }

    return $template;
}

/* Search */
function getSearch($searchQuery='', $fromRow=0, $limit=10)
{
    global $conn;
    $get = array();
    $escapeObj = new \miuan\Escape();
    $searchQuery = $escapeObj->stringEscape($searchQuery);
    $fromRow = (int) $fromRow;
    $limit = (int) $limit;

    if (empty($searchQuery))
    {
        return false;
    }

    if ($fromRow < 0)
    {
        return false;
    }

    if ($limit < 1) {
        return false;
    }

    $query = $conn->query("SELECT id FROM " . DB_ACCOUNTS . "
        WHERE name LIKE _utf8'%$searchQuery%' collate utf8_general_ci
        AND (id IN (SELECT id FROM " . DB_USERS . ") OR id IN (SELECT id FROM " . DB_PAGES . ") OR id IN (SELECT id FROM " . DB_GROUPS . " WHERE group_privacy IN ('open','closed')))
        AND type IN ('user','page','group') AND active=1
        ORDER BY name ASC
        LIMIT $fromRow,$limit");

    if ($query->num_rows > 0)
    {
        while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
        {
            $get[] = $fetch['id'];
        }

        return $get;
    }
}

function getSearchTemplate($a, $b, $c)
{
    global $themeData, $lang;
    $results = getSearch($a, $b, $c);
    $template = '';

    if (is_array($results))
    {
        foreach ($results as $k => $v)
        {
            $timelineObj = new \miuan\User();
            $timelineObj->setId($v);
            $timeline = $timelineObj->getRows();

            $themeData['search_user_id'] = $timeline['id'];
            $themeData['search_user_url'] = $timeline['url'];
            $themeData['search_user_username'] = $timeline['username'];
            $themeData['search_user_thumbnail_url'] = $timeline['thumbnail_url'];
            $themeData['search_user_name'] = $timeline['name'];

            if ($timeline['type'] == "user")
            {
                if (! empty($timeline['current_city']))
                {
                    $themeData['search_user_info'] = $timeline['current_city'];
                }
                else
                {
                    $themeData['search_user_info'] = $lang['gender_' . $timeline['gender'] . '_label'];
                }
            }
            elseif ($timeline['type'] == "page")
            {
                $category = getPageCategoryData($timeline['category_id']);
                $themeData['search_user_info'] = $category['name'];
            }
            elseif ($timeline['type'] == "group")
            {
                $themeData['search_user_info'] = $lang[$timeline['group_privacy'] . '_group'];
            }

            $template .= \miuan\UI::view('header/search-result');
        }
    }

    return $template;
}

/* Timezones */
function getTimezones()
{
    $timezones = null;

    if ($timezones === null)
    {
        $timezones = array();
        $offsets = array();
        $now = new DateTime();

        foreach (DateTimeZone::listIdentifiers() as $timezone)
        {
            $now->setTimezone(new DateTimeZone($timezone));
            $offsets[] = $offset = $now->getOffset();
            $timezones[$timezone] = '(' . convertToGMT($offset) . ') ' . rearrangeTimezoneName($timezone);
        }

        array_multisort($offsets, $timezones);
    }

    unset($timezones['UTC']);
    return $timezones;
}

function convertToGMT($offset)
{
    $hours = intval($offset / 3600);
    $minutes = abs(intval($offset % 3600 / 60));
    return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
}

function rearrangeTimezoneName($name)
{
    $name = str_replace('/', ', ', $name);
    $name = str_replace('_', ' ', $name);
    $name = str_replace('St ', 'St. ', $name);
    return $name;
}

/* Is valid password reset token */
function isValidPasswordResetToken($string)
{
    $stringExp = explode('_', $string);
    $id = (int) $stringExp[0];
    $escapeObj = new \miuan\Escape();
    $password = $escapeObj->stringEscape($stringExp[1]);

    if ($id < 1)
    {
        return false;
    }

    global $conn;
    $query = $conn->query("SELECT id FROM " . DB_ACCOUNTS . " WHERE id=$id AND password='$password' AND active=1");

    if ($query->num_rows == 1)
    {
        return array(
            'id' => $id,
            'password' => $password
        );
    }
    else
    {
        return false;
    }
}

/* Get onlines */
function getOnlines($timelineId=0, $search_query='')
{
    if (! isLogged())
    {
        return array();
    }

    global $conn;
    $get = array();
    $excludes = array();
    $timelineId = (int) $timelineId;

    if ($timelineId < 1) {
        global $user;
        $timelineId = $user['id'];
    }

    $queryText = "SELECT id FROM " . DB_ACCOUNTS . "
    WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=$timelineId AND active=1)
    AND type='user' AND last_logged>" . (time()-15) . " AND active=1";

    if (! empty($search_query))
    {
        $escapeObj = new \miuan\Escape();
        $search_query = $escapeObj->stringEscape($search_query);
        $queryText .= " AND name LIKE '%$search_query%'";
    }

    $queryText .= " ORDER BY last_logged DESC";
    $query = $conn->query($queryText);

    while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
    {
        $timelineObj = new \miuan\User();
        $timelineObj->setId($fetch['id']);
        $get[] = $timelineObj->getRows();
        $excludes[] = $fetch['id'];
    }

    $exclude_query_string = 0;
    $exclude_i = 0;
    $excludes_num = count($excludes);

    if ($excludes_num > 0) {
        $exclude_query_string = '';

        foreach ($excludes as $exclude) {
            $exclude_i++;
            $exclude_query_string .= $exclude;

            if ($exclude_i != $excludes_num) {
                $exclude_query_string .= ',';
            }
        }
    }

    $query2Text = "SELECT DISTINCT id FROM " . DB_ACCOUNTS . " WHERE id NOT IN ($exclude_query_string) AND id IN (SELECT timeline_id FROM " . DB_MESSAGES . " WHERE recipient_id=$timelineId AND active=1 AND seen=0 ORDER BY id DESC) AND active=1";

    if (! empty($query2Text))
    {
        $query2Text .= " AND name LIKE '%$search_query%'";
    }

    $query2 = $conn->query($query2Text);

    while ($fetch2 = $query2->fetch_array(MYSQLI_ASSOC))
    {
        $timelineObj = new \miuan\User();
        $timelineObj->setId($fetch2['id']);
        $get[] = $timelineObj->getRows();
    }

    return $get;
}

function countOnlines($timelineId=0)
{
    if (! isLogged())
    {
        return false;
    }

    global $conn;
    $data = array();
    $timelineId = (int) $timelineId;

    if ($timelineId < 1)
    {
        global $user;
        $timelineId = $user['id'];
    }

    $query = $conn->query("SELECT COUNT(id) AS count FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=$timelineId AND following_id<>$timelineId AND active=1) AND type='user' AND last_logged>" . (time()-15) . " AND active=1 ORDER BY last_logged DESC");
    $fetch = $query->fetch_array(MYSQLI_ASSOC);

    return $fetch['count'];
}

/* Get message recipients */
function countMessageRecipients($timelineId=0, $searchQuery='', $new=false)
{
    if (! isLogged())
    {
        return 0;
    }

    global $conn;
    $get = 0;
    $excludes = array();
    $timelineId = (int) $timelineId;
    $escapeObj = new \miuan\Escape();
    $searchQuery = $escapeObj->stringEscape($searchQuery);

    if ($timelineId < 1)
    {
        global $user;
        $timelineId = $user['id'];
    }

    if (! empty($searchQuery))
    {
        $query = $conn->query("SELECT COUNT(id) AS count FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=$timelineId AND following_id NOT IN (SELECT id FROM " . DB_GROUPS . ") AND active=1) AND active=1 AND name LIKE '%$searchQuery%'");
        $fetch = $query->fetch_array(MYSQLI_ASSOC);

        return $fetch['count'];
    }
    else
    {
        $get = 0;
        $excludes = array(0);

        $queryText = "SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT timeline_id FROM " . DB_MESSAGES . " WHERE recipient_id=$timelineId AND active=1 AND seen=0 ORDER BY seen ASC, id DESC) AND active=1";
        $query = $conn->query($queryText);
        $get = $query->num_rows;

        while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
        {
            $excludes[] = $fetch['id'];
        }

        $excludeQuery = implode(',', $excludes);

        if (! $new)
        {
            $queryText = "SELECT COUNT(id) AS count FROM " . DB_ACCOUNTS . " WHERE id NOT IN ($excludeQuery) AND (id IN (SELECT timeline_id FROM " . DB_MESSAGES . " WHERE recipient_id=$timelineId AND active=1 AND seen>0) OR id IN (SELECT recipient_id FROM " . DB_MESSAGES . " WHERE timeline_id=$timelineId AND active=1)) AND active=1 ORDER BY id DESC";
            $query = $conn->query($queryText);
            $fetch = $query->fetch_array(MYSQLI_ASSOC);

            $get = $fetch['count'] + $get;
        }

        if ($get < 1)
        {
            $queryText = "SELECT COUNT(id) AS count FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=$timelineId AND active=1) AND active=1 ORDER BY id DESC";
            $query = $conn->query($queryText);
            $fetch = $query->fetch_array(MYSQLI_ASSOC);

            $get = $fetch['count'];
        }

        return $get;
    }

    return 0;
}

function getMessageRecipients($timelineId=0, $searchQuery='', $new=false, $limit=10)
{
    if (! isLogged())
    {
        return array();
    }

    global $conn;
    $get = array();
    $excludes = array();
    $timelineId = (int) $timelineId;
    $limit = (int) $limit;
    $escapeObj = new \miuan\Escape();
    $searchQuery = $escapeObj->stringEscape($searchQuery);

    if ($timelineId < 1)
    {
        global $user;
        $timelineId = $user['id'];
    }

    if ($limit < 1)
    {
        $limit = 10;
    }

    if (! empty($searchQuery))
    {
        $query = $conn->query("SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=$timelineId AND following_id NOT IN (SELECT id FROM " . DB_GROUPS . ") AND active=1) AND active=1 AND name LIKE '%$searchQuery%' LIMIT $limit");

        while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
        {
            $timelineObj = new \miuan\User();
            $timelineObj->setId($fetch['id']);
            $get[] = $timelineObj->getRows();
        }

        return $get;
    }
    else
    {
        $excludes = array(0);

        $queryText = "SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT timeline_id FROM " . DB_MESSAGES . " WHERE recipient_id=$timelineId AND active=1 AND seen=0 ORDER BY seen ASC, id DESC) AND active=1";
        $query = $conn->query($queryText);

        while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
        {
            $timelineObj = new \miuan\User();
            $timelineObj->setId($fetch['id']);
            $get[] = $timelineObj->getRows();
            $excludes[] = $fetch['id'];
        }

        $excludeQuery = implode(',', $excludes);

        if (! $new)
        {
            $queryText = "SELECT id FROM " . DB_ACCOUNTS . " WHERE id NOT IN ($excludeQuery) AND (id IN (SELECT timeline_id FROM " . DB_MESSAGES . " WHERE recipient_id=$timelineId AND active=1 AND seen>0) OR id IN (SELECT recipient_id FROM " . DB_MESSAGES . " WHERE timeline_id=$timelineId AND active=1)) AND active=1 ORDER BY id DESC LIMIT $limit";
            $query = $conn->query($queryText);

            while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
            {
                $timelineObj = new \miuan\User();
                $timelineObj->setId($fetch['id']);
                $get[] = $timelineObj->getRows();
            }
        }

        if (! isset($get[0]))
        {
            $queryText = "SELECT id FROM " . DB_ACCOUNTS . " WHERE id IN (SELECT following_id FROM " . DB_FOLLOWERS . " WHERE follower_id=$timelineId AND active=1) AND active=1 ORDER BY id DESC LIMIT $limit";
            $query = $conn->query($queryText);

            while ($fetch = $query->fetch_array(MYSQLI_ASSOC))
            {
                $timelineObj = new \miuan\User();
                $timelineObj->setId($fetch['id']);
                $get[] = $timelineObj->getRows();
            }
        }

        return $get;
    }

    return array();
}

function getMessages($data=array())
{
    if (! isLogged())
    {
        return false;
    }

    global $conn;
    $get = array();

    if (empty($data['recipient_id']) or !is_numeric($data['recipient_id']))
    {
        return false;
    }

    $recipientId = (int) $data['recipient_id'];
    $recipientObj = new \miuan\User();
    $recipientObj->setId($recipientId);
    $recipient = $recipientObj->getRows();

    if (! isset($recipient['id']))
    {
        return false;
    }

    $queryText = "SELECT id,active,media_id,recipient_id,seen,text,time,timeline_id FROM " . DB_MESSAGES . " WHERE active=1";

    if (! empty($data['message_id']) && is_numeric($data['message_id']))
    {
        $messageId = (int) $data['message_id'];
        $queryText .= " AND id=$messageId";
    }
    elseif (! empty($data['before_message_id']) && is_numeric($data['before_message_id']))
    {
        $beforeMessageId = (int) $data['before_message_id'];
        $queryText .= " AND id<$beforeMessageId";
    }

    if (empty($data['timeline_id']) or $data['timeline_id'] < 1)
    {
        global $user, $userObj;
        $timelineId = $user['id'];
        $timelineObj = $userObj;
        $timeline = $user;
    }
    else
    {
        $timelineId = (int) $data['timeline_id'];
        $timelineObj = new \miuan\User();
        $timelineObj->setId($timelineId);
        $timeline = $timelineObj->getRows();
    }

    if (! isset($timeline['id']))
    {
        return false;
    }

    if (! $timelineObj->isAdmin())
    {
        return false;
    }

    if ($timelineId == $recipientId)
    {
        return false;
    }

    if (isset($data['new']) && $data['new'] == true)
    {
        $queryText .= " AND seen=0 AND timeline_id=" . $recipientId . " AND recipient_id=" . $timelineId;
    }
    else
    {
        $queryText .= " AND ((timeline_id=" . $timelineId . " AND recipient_id=" . $recipientId . ") OR (timeline_id=" . $recipientId . " AND recipient_id=" . $timelineId . "))";
    }

    $query = $conn->query($queryText);
    $queryLimitFrom = $query->num_rows - 5;

    if ($queryLimitFrom < 1)
    {
        $queryLimitFrom = 0;
    }

    $queryText .= " ORDER BY id ASC LIMIT $queryLimitFrom,5";
    $query2 = $conn->query($queryText);

    if ($query2->num_rows == 0)
    {
        return false;
    }

    $escapeObj = new \miuan\Escape();

    while ($fetch2 = $query2->fetch_array(MYSQLI_ASSOC))
    {
        $timelineObj = new \miuan\User();
        $timelineObj->setId($fetch2['timeline_id']);

        $fetch2['account'] = $fetch2['timeline'] = $timelineObj->getRows();
        $fetch2['owner'] = false;

        if ($timelineObj->isAdmin())
        {
            $fetch2['owner'] = true;
        }

        $fetch2['text'] = $escapeObj->getEmoticons($fetch2['text']);
        $fetch2['text'] = $escapeObj->getLinks($fetch2['text']);
        $fetch2['text'] = $escapeObj->getHashtags($fetch2['text']);
        $fetch2['text'] = $escapeObj->getMentions($fetch2['text']);
        $fetch2['media'] = array();

        if (! empty($fetch2['media_id']))
        {
            $mediaObj = new \miuan\Media();
            $mediaObj->setId($fetch2['media_id']);
            $fetch2['media'] = $mediaObj->getRows();
        }

        if ($fetch2['recipient_id'] == $timelineId && $fetch2['seen'] == 0)
        {
            $conn->query("UPDATE " . DB_MESSAGES . " SET seen=" . time() . " WHERE id=" . $fetch2['id']);
        }

        $get[] = $fetch2;
    }

    return $get;
}

function getTimeAgo($unix, $details=false)
{
    global $time;

    if ($details == true)
    {
        if (date('Y', $unix) == date('Y'))
        {
            if (date('dM', $unix) == date('dM'))
            {
                return date('h:i A', $unix);
            }
            else
            {
                return date('d M - h:i A', $unix);
            }
        }
        else
        {
            return date('d M Y - h:i A', $unix);
        }
    }
    else
    {
        $interval = 'Just now';

        if ($unix > $time)
        {
            $diff = $unix - $time;
            $prefix = 'after';
            $math = 'round';
        }
        else
        {
            $diff = $time - $unix;
            $prefix = 'before';
            $math = 'floor';
        }

        if ($diff >= 120)
        {
            $reminder = $math($diff / 60);
            $suffix = 'min';

            if ($diff >= (60 * 60))
            {
                $reminder = $math($diff / (60 * 60));
                $suffix = 'hr';

                if ($diff >= (60 * 60 * 24))
                {
                    $reminder = $math($diff / (60 * 60 * 24));
                    $suffix = 'day';

                    if ($diff >= (60 * 60 * 24 * 7))
                    {
                        $reminder = $math($diff / (60 * 60 * 24 * 7));
                        $suffix = 'week';

                        if ($diff > (60 * 60 * 24 * 31))
                        {
                            $reminder = $math($diff / (60 * 60 * 24 * 31));
                            $suffix = 'month';

                            if ($diff > (60 * 60 * 24 * 30 * 12))
                            {
                                $reminder = $math($diff / (60 * 60 * 24 * 30 * 12));
                                $suffix = 'yr';
                            }
                        }
                    }
                }
            }

            $interval = $reminder . ' ' . $suffix;

            if ($reminder != 1)
            {
                $interval .= 's';
            }

            if ($prefix == "after")
            {
                $interval = 'after ' . $interval;
            }
        }

        return $interval;
    }
}

/* Send Chat Message */
function registerChatMessage($data=array())
{
    if (! isLogged()) {
        return false;
    }

    global $conn, $config, $lang, $user, $userObj;
    $post_ability = false;
    $other_media = false;

    $text = '';
    $media_id = 0;
    $soundcloud_uri = '';
    $soundcloud_title = '';
    $youtube_video_id = '';
    $youtube_title = '';
    $google_map_name = '';
    $recipient_id = 0;
    $type1 = $data['type'];
    $type2 = 'none';

    if (!empty($data['text']))
    {
        $text = $data['text'];

        if ($config['message_character_limit'] > 0)
        {
            if (strlen($data['text']) > $config['message_character_limit'])
            {
                return false;
            }
        }

        $escapeObj = new \miuan\Escape();

        // Links
        $text = $escapeObj->createLinks($text);

        // Hashtags
        $text = $escapeObj->createHashtags($text);

        // Mentions
        $mentions = $escapeObj->createMentions($text);
        $text = $mentions['content'];

        $text = $escapeObj->postEscape($text);

        $post_ability = true;
    }

    if (!empty($data['recipient_id']) && is_numeric($data['recipient_id']) && $data['recipient_id'] > 0)
    {
        $recipientId = (int) $data['recipient_id'];
    }

    if ($recipientId > 0)
    {
        $recipientObj = new \miuan\User();
        $recipientObj->setId($recipientId);
        $recipient = $recipientObj->getRows();

        if (empty($recipient['id']))
        {
            return false;
        }

        if ($user['id'] == $recipientId)
        {
            return false;
        }

        if ($recipient['type'] == "user")
        {
            if ($recipient['message_privacy'] != "everyone" && ! $recipientObj->isFollowing())
            {
                return false;
            }
        }
        elseif ($recipient['type'] == "page")
        {
            if ($recipient['message_privacy'] != "everyone")
            {
                return false;
            }
        }
        elseif ($recipient['type'] == "group")
        {
            return false;
        }
    }

    if (isset($data['photos']['name']))
    {
        $photoCount = count($data['photos']['name']);

        if ($photoCount == 1)
        {
            $photo_param = array(
                'tmp_name' => $data['photos']['tmp_name'][0],
                'name' => $data['photos']['name'][0],
                'size' => $data['photos']['size'][0]
            );
            $photo_data = registerMedia($photo_param);

            if (isset($photo_data['id']))
            {
                $media_id = $photo_data['id'];
                $other_media = true;
                $post_ability = true;
            }
        }
        else
        {
            $query = $conn->query("INSERT INTO " . DB_MEDIA . " (timeline_id,active,name,type) VALUES ($timelineId,1,'temp_" . generateKey() . "','album')");

            if ($query)
            {
                $mediaId = $conn->insert_id;

                for ($i = 0; $i < $photoCount; $i++)
                {
                    $photo_param = array(
                        'tmp_name' => $data['photos']['tmp_name'][$i],
                        'name' => $data['photos']['name'][$i],
                        'size' => $data['photos']['size'][$i]
                    );
                    $photo_data = registerMedia($photo_param, $media_id);

                    if (! empty($photo_data['id']))
                    {
                        $query2 = $conn->query("INSERT INTO " . DB_MESSAGES . " (active,media_id,time,timeline_id,recipient_id) VALUES (1," . $photo_data['id'] . "," . time() . "," . $timelineId . ",$recipientId)");

                        if ($query2)
                        {
                            $mediaPostId = $conn->insert_id;

                            $conn->query("UPDATE " . DB_MEDIA . " SET post_id=$mediaPostId WHERE id=" . $photo_data['id']);

                            $mediaPostObj = new \miuan\Story();
                            $mediaPostObj->setId($mediaPostId);
                            $mediaPost = $mediaPostObj->getRows();

                            $mediaPostObj->putFollow();
                        }
                    }
                }

                $other_media = true;
                $post_ability = true;
            }
        }
    }

    if ($post_ability)
    {
        $query = $conn->query("INSERT INTO " . DB_MESSAGES . " (active,media_id,text,time,timeline_id,recipient_id) VALUES (1,$media_id,'$text'," . time() . "," . $user['id'] . ",$recipientId)");
        return $conn->insert_id;
    }
}

/* Register notifications */
function registerNotification($data=array())
{
    if (! isLogged())
    {
        return false;
    }

    global $conn, $lang;
    $escapeObj = new \miuan\Escape();

    if (! isset($data['recipient_id']) or ! is_numeric($data['recipient_id']))
    {
        return false;
    }

    if (empty($data['post_id']))
    {
        $data['post_id'] = 0;
    }

    if (! is_numeric($data['post_id']))
    {
        return false;
    }

    $recipientId = (int) $data['recipient_id'];
    $postId = (int) $data['post_id'];

    if (empty($data['notifier_id']))
    {
        global $user, $userObj;
        $notifierId = $user['id'];
        $notifierObj = $userObj;
        $notifier = $user;
    }
    else
    {
        $notifierId = (int) $data['notifier_id'];
        $notifierObj = new \miuan\User();
        $notifierObj->setId($notifierId);
        $notifier = $notifierObj->getRows();
    }

    if (! $notifierObj->isAdmin())
    {
        return false;
    }

    if ($recipientId == $notifierId)
    {
        return false;
    }

    if (empty($data['text']))
    {
        return false;
    }

    if (empty($data['type']))
    {
        return false;
    }

    if (empty($data['url']))
    {
        return false;
    }

    $text = $escapeObj->stringEscape($data['text']);
    $type = $escapeObj->stringEscape($data['type']);
    $url = $data['url'];

    $text = strip_tags($text);

    $recipientObj = new \miuan\User();
    $recipientObj->setId($recipientId);
    $recipient = $recipientObj->getRows();

    if (! isset($recipient['id']))
    {
        return false;
    }

    $query = $conn->query("SELECT id FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=$recipientId AND post_id=$postId AND type='$type' AND active=1");

    if ($query->num_rows > 0)
    {
        $query2 = $conn->query("DELETE FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=$recipientId AND post_id=$postId AND type='$type' AND active=1");
    }

    if (! isset($data['undo']) or $data['undo'] != true)
    {
        $query3 = $conn->query("INSERT INTO " . DB_NOTIFICATIONS . " (timeline_id,active,notifier_id,post_id,text,time,type,url) VALUES ($recipientId,1,$notifierId,$postId,'$text'," . time() . ",'$type','$url')");

        if ($query3)
        {
            return true;
        }
    }
}

/* Pages */
function registerPageAdmin($pageId=0, $adminId=0, $adminRole='')
{
    if (! isLogged())
    {
        return false;
    }

    global $conn, $lang;
    $pageId = (int) $pageId;
    $adminId = (int) $adminId;

    $pageObj = new \miuan\User();
    $pageObj->setId($pageId);
    $page = $pageObj->getRows();

    $adminObj = new \miuan\User();
    $adminObj->setId($adminId);
    $admin = $adminObj->getRows();

    if (! isset($page['id']))
    {
        return false;
    }

    if (! isset($admin['id']))
    {
        return false;
    }

    if (empty($adminRole))
    {
        return false;
    }

    $escapeObj = new \miuan\Escape();
    $adminRole = $escapeObj->stringEscape($adminRole);

    if (! preg_match('/(admin|editor)/', $adminRole))
    {
        return false;
    }

    if (! $pageObj->isAdmin())
    {
        return false;
    }

    if ($page['type'] != "page")
    {
        return false;
    }

    if ($admin['type'] != "user")
    {
        return false;
    }

    if ($pageObj->isAdmin($adminId))
    {
        $query = $conn->query("UPDATE " . DB_PAGE_ADMINS . " SET role='$adminRole' WHERE page_id=$pageId AND admin_id=$adminId AND active=1");

        if ($query)
        {
            return true;
        }
    }
    else
    {
        $query = $conn->query("INSERT INTO " . DB_PAGE_ADMINS . " (active,admin_id,page_id,role) VALUES (1,$adminId,$pageId,'$adminRole')");

        if ($query)
        {
            registerNotification(array(
                'recipient_id' => $adminId,
                'notifier_id' => $pageId,
                'type' => 'page_add_admin',
                'text' => $lang['made_page_admin'],
                'url' => 'index.php?tab1=timeline&id=' . $page['username']
            ));

            return true;
        }
    }
}

function deletePageAdmin($pageId=0, $adminId=0)
{
    if (! isLogged())
    {
        return false;
    }

    global $conn;
    $pageId = (int) $pageId;
    $adminId = (int) $adminId;

    $pageObj = new \miuan\User();
    $pageObj->setId($pageId);
    $page = $pageObj->getRows();

    $adminObj = new \miuan\User();
    $adminObj->setId($adminId);
    $admin = $adminObj->getRows();

    if (! isset($page['id']))
    {
        return false;
    }

    if (! isset($admin['id']))
    {
        return false;
    }

    if ($page['type'] != "page")
    {
        return false;
    }

    if ($admin['type'] != "user")
    {
        return false;
    }

    if ($pageObj->isPageAdmin() != "admin")
    {
        return false;
    }

    $query = $conn->query("DELETE FROM " . DB_PAGE_ADMINS . " WHERE admin_id=" . $adminId . " AND page_id=" . $pageId);

    if ($query)
    {
        return true;
    }
}

/* Groups */
function registerGroupMember($groupId=0, $memberId=0)
{
    if (! isLogged())
    {
        return false;
    }

    global $conn, $lang;
    $groupId = (int) $groupId;
    $memberId = (int) $memberId;

    $groupObj = new \miuan\User();
    $groupObj->setId($groupId);
    $group = $groupObj->getRows();

    $memberObj = new \miuan\User();
    $memberObj->setId($memberId);
    $member = $memberObj->getRows();

    $continue = false;

    if (! isset($group['id']))
    {
        return false;
    }

    if (! isset($member['id']))
    {
        return false;
    }

    if ($group['type'] != "group")
    {
        return false;
    }

    if ($member['type'] != "user")
    {
        return false;
    }

    if ($memberObj->isFollowing($groupId))
    {
        return false;
    }

    if ($group['add_privacy'] == "admins")
    {
        if ($groupObj->isGroupAdmin())
        {
            $continue = true;
        }
    }
    elseif ($group['add_privacy'] == "members")
    {
        if ($groupObj->isFollowedBy())
        {
            $continue = true;
        }
    }

    if ($continue)
    {
        if ($groupObj->isFollowRequested($memberId))
        {
            $query = $conn->query("UPDATE " . DB_FOLLOWERS . " SET active=1 WHERE follower_id=" . $memberId . " AND following_id=" . $groupId . " AND active=0");

            if ($query)
            {
                registerNotification(array(
                    'recipient_id' => $member['id'],
                    'text' => str_replace('{group_name}', '[b weight=500]'. $group['name'] .'[/b]', $lang['accepted_group_join_request']),
                    'type' => 'accepted_group_member',
                    'url' => 'index.php?tab1=timeline&id=' . $group['username']
                ));

                return true;
            }
        }
        else
        {
            $query = $conn->query("INSERT INTO " . DB_FOLLOWERS . " (active,follower_id,following_id,time) VALUES (1," . $memberId . "," . $groupId . "," . time() . ")");

            if ($query)
            {
                registerNotification(array(
                    'recipient_id' => $member['id'],
                    'text' => str_replace('{group_name}', '[b weight=500]'. $group['name'] .'[/b]', $lang['added_to_group']),
                    'type' => 'made_group_member',
                    'url' => 'index.php?tab1=timeline&id=' . $group['username']
                ));

                return true;
            }
        }
    }
}

function registerGroupAdmin($groupId=0, $adminId=0)
{
    if (! isLogged())
    {
        return false;
    }

    global $conn, $lang;
    $groupId = (int) $groupId;
    $adminId = (int) $adminId;

    $groupObj = new \miuan\User();
    $groupObj->setId($groupId);
    $group = $groupObj->getRows();

    $adminObj = new \miuan\User();
    $adminObj->setId($adminId);
    $admin = $adminObj->getRows();

    if (! isset($group['id']))
    {
        return false;
    }

    if (! isset($admin['id']))
    {
        return false;
    }

    if ($group['type'] != "group")
    {
        return false;
    }

    if ($admin['type'] != "user")
    {
        return false;
    }

    if (! $groupObj->isGroupAdmin())
    {
        return false;
    }

    if ($groupObj->isGroupAdmin($adminId))
    {
        return false;
    }

    $query = $conn->query("INSERT INTO " . DB_GROUP_ADMINS . " (active,admin_id,group_id) VALUES (1," . $adminId . "," . $groupId . ")");

    if ($query)
    {
        registerNotification(array(
            'recipient_id' => $adminId,
            'text' => str_replace('{group_name}', '[b weight=500]'. $group['name'] .'[/b]', $lang['made_group_admin']),
            'type' => 'made_group_admin',
            'url' => 'index.php?tab1=timeline&id=' . $group['username']
        ));

        return true;
    }
}

function deleteGroupMember($groupId=0, $memberId=0)
{
    if (! isLogged())
    {
        return false;
    }

    global $conn, $user;
    $groupId = (int) $groupId;
    $memberId = (int) $memberId;

    $groupObj = new \miuan\User();
    $groupObj->setId($groupId);
    $group = $groupObj->getRows();

    $memberObj = new \miuan\User();
    $memberObj->setId($memberId);
    $member = $memberObj->getRows();

    $continue = false;

    if (! isset($group['id']))
    {
        return false;
    }

    if (! isset($member['id']))
    {
        return false;
    }

    if ($group['type'] != "group")
    {
        return false;
    }

    if ($member['type'] != "user")
    {
        return false;
    }

    if ($memberId == $user['id'] or $groupObj->isGroupAdmin())
    {
        $query = $conn->query("DELETE FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $memberId . " AND following_id=" . $groupId);
        return true;
    }
}

function deleteGroupAdmin($groupId=0, $adminId=0)
{
    if (! isLogged())
    {
        return false;
    }

    global $conn;
    $groupId = (int) $groupId;
    $adminId = (int) $adminId;

    $groupObj = new \miuan\User();
    $groupObj->setId($groupId);
    $group = $groupObj->getRows();

    $adminObj = new \miuan\User();
    $adminObj->setId($adminId);
    $admin = $adminObj->getRows();

    if (! isset($group['id']))
    {
        return false;
    }

    if (! isset($admin['id']))
    {
        return false;
    }

    if ($group['type'] != "group")
    {
        return false;
    }

    if ($admin['type'] != "user")
    {
        return false;
    }

    if (! $groupObj->isAdmin())
    {
        return false;
    }

    if ($groupObj->numGroupAdmins() < 2)
    {
        return false;
    }

    $query = $conn->query("DELETE FROM " . DB_GROUP_ADMINS . " WHERE admin_id=" . $adminId . " AND group_id=" . $groupId);

    if ($query)
    {
        return true;
    }
}

/* Send Message */
function registerMessage($data=array())
{
    if (! isLogged()) {
        return false;
    }

    global $conn, $config, $lang;
    $post_ability = false;
    $other_media = false;

    if (empty($data['timeline_id']) or ! is_numeric($data['timeline_id']) or $data['timeline_id'] < 1)
    {
        global $user, $userObj;
        $timelineId = $user['id'];
        $timelineObj = $userObj;
        $timeline = $user;
    }
    else
    {
        $timelineId = (int) $data['timeline_id'];
        $timelineObj = new \miuan\User();
        $timelineObj->setId($timelineId);
        $timeline = $timelineObj->getRows();
    }

    if ($timeline['type'] == "group")
    {
        return false;
    }

    if (! $timelineObj->isAdmin())
    {
        return false;
    }

    $text = '';
    $media_id = 0;
    $soundcloud_uri = '';
    $soundcloud_title = '';
    $youtube_video_id = '';
    $youtube_title = '';
    $google_map_name = '';
    $recipient_id = 0;
    $type1 = $data['type'];
    $type2 = 'none';

    if (!empty($data['text']))
    {
        $text = $data['text'];

        if ($config['message_character_limit'] > 0)
        {
            if (strlen($data['text']) > $config['message_character_limit'])
            {
                return false;
            }
        }

        $escapeObj = new \miuan\Escape();

        // Links
        $text = $escapeObj->createLinks($text);

        // Hashtags
        $text = $escapeObj->createHashtags($text);

        // Mentions
        $mentions = $escapeObj->createMentions($text);
        $text = $mentions['content'];

        $text = $escapeObj->postEscape($text);

        $post_ability = true;
    }

    if (!empty($data['recipient_id']) && is_numeric($data['recipient_id']) && $data['recipient_id'] > 0)
    {
        $recipientId = (int) $data['recipient_id'];
    }

    if ($recipientId > 0)
    {
        $recipientObj = new \miuan\User();
        $recipientObj->setId($recipientId);
        $recipient = $recipientObj->getRows();

        if (empty($recipient['id']))
        {
            return false;
        }

        if ($timelineId == $recipientId)
        {
            return false;
        }

        if ($recipient['type'] == "user" && $timeline['type'] != "page")
        {
            if ($recipient['message_privacy'] != "everyone" && ! $recipientObj->isFollowing())
            {
                return false;
            }
        }
        elseif ($recipient['type'] == "page")
        {
            if ($recipient['message_privacy'] != "everyone")
            {
                return false;
            }
        }
        elseif ($recipient['type'] == "group")
        {
            return false;
        }
    }

    if (isset($data['photos']['name']))
    {
        $photoCount = count($data['photos']['name']);

        if ($photoCount == 1)
        {
            $photo_param = array(
                'tmp_name' => $data['photos']['tmp_name'][0],
                'name' => $data['photos']['name'][0],
                'size' => $data['photos']['size'][0]
            );
            $photo_data = registerMedia($photo_param);

            if (isset($photo_data['id']))
            {
                $media_id = $photo_data['id'];
                $other_media = true;
                $post_ability = true;
            }
        }
        else
        {
            $query = $conn->query("INSERT INTO " . DB_MEDIA . " (timeline_id,active,name,type) VALUES ($timelineId,1,'temp_" . generateKey() . "','album')");

            if ($query)
            {
                $mediaId = $conn->insert_id;

                for ($i = 0; $i < $photoCount; $i++)
                {
                    $photo_param = array(
                        'tmp_name' => $data['photos']['tmp_name'][$i],
                        'name' => $data['photos']['name'][$i],
                        'size' => $data['photos']['size'][$i]
                    );
                    $photo_data = registerMedia($photo_param, $media_id);

                    if (! empty($photo_data['id']))
                    {
                        $query2 = $conn->query("INSERT INTO " . DB_MESSAGES . " (active,media_id,time,timeline_id,recipient_id) VALUES (1," . $photo_data['id'] . "," . time() . "," . $timelineId . ",$recipientId)");

                        if ($query2)
                        {
                            $mediaPostId = $conn->insert_id;

                            $conn->query("UPDATE " . DB_MEDIA . " SET post_id=$mediaPostId WHERE id=" . $photo_data['id']);

                            $mediaPostObj = new \miuan\Story();
                            $mediaPostObj->setId($mediaPostId);
                            $mediaPost = $mediaPostObj->getRows();

                            $mediaPostObj->putFollow();
                        }
                    }
                }

                $other_media = true;
                $post_ability = true;
            }
        }
    }

    if ($post_ability)
    {
        $query = $conn->query("INSERT INTO " . DB_MESSAGES . " (active,media_id,text,time,timeline_id,recipient_id) VALUES (1,$media_id,'$text'," . time() . ",$timelineId,$recipientId)");

        if ($query)
        {
            $post_id = $conn->insert_id;
            $query2 = $conn->query("UPDATE " . DB_MESSAGES . " SET post_id=$post_id WHERE id=$post_id");

            /* E-mail notification */
            if ($recipient['type'] == "user")
            {
                if ($recipient['mailnotif_message'] == true)
                {
                    global $themeData;
                    $themeData['conversation_url'] = smoothLink('index.php?tab1=messages&recipient_id=' . $timeline['username']);
                    $themeData['mail_recipient_name'] = $recipient['name'];
                    $themeData['mail_generator_url'] = $timeline['url'];
                    $themeData['mail_generator_name'] = $timeline['name'];

                    $subject = $config['site_name'];
                    $subject .= " | ";
                    $subject .= str_replace("{user}", $timeline['name'] . " (@" . $timeline['username'] . ")", $lang['new_message_email_subject']);

                    $message = \miuan\UI::view('emails/notifications/new-message');
                    send_mail($recipient['email'], $subject, $message);
                }
            }

            return $post_id;
        }
    }
}

/* v2.0 */
function __POST__ ($post, $return='')
{
    if ( !isset($_POST[$post]) )
    {
        return $return;
    }
    return $_POST[$post];
}
function __GET__ ($get, $return='')
{
    if ( !isset($_GET[$get]) )
    {
        return $return;
    }
    return $_GET[$get];
}
function activate_plugin ($P)
{
    global $PLUGINS;

    if ( isset($PLUGINS[$P]) )
    {
        $PLUGINS[$P] = true;
    }
}
function grab_meta_tags ($Url)
{
    $Urlname = preg_replace('/[^A-Za-z0-9_]/i', '', $Url);
    $get_meta = get_meta_tags($Url);
    $get_html = file_get_contents($Url);
    $title_preg_match = preg_match('/\<title\>(.*?)\<\/title\>/i', $get_html, $title_match);

    if ( !empty($title_match[1]) )
    {
        $get_meta['title'] = $title_match[1];
    }

    $img_preg_match = preg_match('/\<img(.*?)src\=\"(.*?)(\.jpg|\.png)\"(.*?)(|\/)\>/i', $get_html, $img_match);

    if ( !empty($img_match[2]) )
    {
        $get_meta['img_preview'] = $img_match[2] . $img_match[3];

        if (! preg_match('/http(|s)\:/i', $get_meta['img_preview']))
        {
            $get_meta['img_preview'] = 'http:' . $get_meta['img_preview'];
        }
    }

    return $get_meta;
}
function file_ext ($Url)
{
    $len = strlen($Url);
    $rpos = strrpos($Url, '.');
    $begin = $len - $rpos;
    $end = $rpos + 1;
    $sub = substr($Url, $end, $begin);
    $lwr = strtolower($sub);
    return $lwr;
}
