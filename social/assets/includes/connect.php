<?php

$config = array();
$confQuery = $conn->query("SELECT * FROM " . DB_CONFIGURATIONS);
$config = $confQuery->fetch_array(MYSQLI_ASSOC);

$config['site_url'] = $site_url;
$config['theme_url'] = $site_url . '/main/' . $config['theme'];
$config['script_path'] = str_replace('index.php', '', $_SERVER['PHP_SELF']);
$config['ajax_path'] = $config['script_path'] . 'request.php';
$config['page_path'] = $config['script_path'] . 'page.php';

if ($config['theme'] == "blackberry")
{
    $conn->query("UPDATE " . DB_CONFIGURATIONS . " SET theme='lemon'");
    header("Location: " . $config['site_url']);
}

if (! isset($_SESSION['language']))
{
    $_SESSION['language'] = $config['language'];
}

include_once('main/' . $config['theme'] . '/emoticons/process.php');

foreach ($config as $cnm => $cfg)
{
    define(strtoupper($cnm), $cfg);
    $themeData['config_' . $cnm] = $cfg;
}

// Login verification and user stats update
$logged = false;
$user = null;

if (isLogged())
{
    $userObj = new \miuan\User();
    $userObj->setId($_SESSION['user_id']);
    $user = $userObj->getRows();

    if (isset($user['id']) && $user['type'] == "user")
    {
        $logged = true;
        
        $conn->query("UPDATE " . DB_ACCOUNTS . " SET last_logged=" . time() . " WHERE id=" . $user['id']);
        
        if (! empty($user['language']))
        {
            $_SESSION['language'] = $user['language'];
        }
        
        if (! isset($_SESSION['tempche_user_ownfollowing']))
        {
            $conn->query("DELETE FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user['id'] . " AND following_id=" . $user['id']);
            $_SESSION['tempche_user_ownfollowing'] = true;
        }

        foreach ($user as $key => $value)
        {
            if (! is_array($value))
            {
                $key = str_replace('current_city', 'location', $key);
                $themeData['user_' . $key] = $value;
            }
        }
    }
}

$sk['logged'] = $logged;

// Fetch preferred language
if (! empty($_GET['lang']))
{
    $_GET['lang'] = preg_replace('/[^A-Za-z0-9_]+/i', '', $_GET['lang']);
    $langExistQuery = $conn->query("SELECT id FROM " . DB_LANGUAGES . " WHERE type='" . $_GET['lang'] . "' LIMIT 1");

    if ($langExistQuery->num_rows == 1)
    {
        $config['language'] = $_GET['lang'];
        $_SESSION['language'] = $_GET['lang'];
        
        if ($logged == true)
        {
            $conn->query("UPDATE " . DB_ACCOUNTS . " SET language='" . $_GET['lang'] . "' WHERE id=" . $user['id']);
        }

        unset($_SESSION['lang_data']);
        header("Location: " . $config['site_url']);
    }
}

if (! isset($_SESSION['lang_data']))
{
    $lang = array();
    $langQuery = $conn->query("SELECT keyword,text FROM " . DB_LANGUAGES . " WHERE type='" . $_SESSION['language'] . "'");
    while ($langFetch = $langQuery->fetch_array(MYSQLI_ASSOC))
    {
        $lang[$langFetch['keyword']] = $langFetch['text'];
    }
    $_SESSION['lang_data'] = $lang;
}
else
{
    $lang = $_SESSION['lang_data'];
}

// Removes session and unnecessary variables if user verification fails
if ($logged == false)
{
    unset($_SESSION['user_id']);
    unset($user);
}