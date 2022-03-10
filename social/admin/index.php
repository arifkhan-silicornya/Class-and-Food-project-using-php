<?php
session_start();
date_default_timezone_set('Europe/London');

require('../assets/includes/tables.php');
require('../assets/includes/config.php');

$dbConnect = mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_name);
mysqli_set_charset($dbConnect, "utf8");

$function_files = glob('functions/*.php');

foreach ($function_files as $func_file) {
    require($func_file);
}

$logged_in = false;

if (SK_verifyLogin()) {
    $logged_in = true;
}

$post_message = null;
$request_files = glob('requests/*.php');

foreach ($request_files as $req_file) {
    require($req_file);
}

if (!isset($_GET['tab1']) or empty($_GET['tab1'])) {
    $_GET['tab1'] = 'general_settings';
}

if ($_GET['tab1'] == "logout") {
    $logged_in = false;
    
    if (isset($_SESSION['admin_id'])) {
        unset($_SESSION['admin_id']);
    }
    
    if (isset($_SESSION['admin_password'])) {
        unset($_SESSION['admin_password']);
    }
}

$config = array();
$confQuery = mysqli_query($dbConnect, "SELECT * FROM " . DB_CONFIGURATIONS);
$config = mysqli_fetch_assoc($confQuery);

$config['site_url'] = $site_url;
$config['theme_url'] = $site_url . '/main/' . $config['theme'];

if (! isset($_SESSION['lang_data']))
{
    $lang = array();
    $langQuery = mysqli_query($dbConnect, "SELECT keyword,text FROM " . DB_LANGUAGES . " WHERE type='" . $_SESSION['language'] . "'");
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

$tab_files = glob('tabs/*.php');

foreach ($tab_files as $tab_file) {
    require($tab_file);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>
        <?php echo $config['site_name']; ?> - Admin Area
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link href="style/style.css" rel="stylesheet">
    <?php if (!$logged_in) { ?>
    <link href="style/welcome.css" rel="stylesheet">
    <?php } ?>
</head>
<body<?php if (!$logged_in) echo ' class="welcome"'; ?>>
    <?php if ($logged_in) { ?>
    <div class="header-wrapper">
        <div class="header-content">
            <div class="float-left">
                <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="float: left;">
                        <span style="font-size: 18px;">Admin</span>
                    </td>
                    <td style="float: right;padding-left: 1100px;">
                        <span><a href="?tab1=logout">Log Out</a></span>
                    </td>
                </tr>
                </table>
            </div>
            <div class="float-clear"></div>
        </div>
    </div>
    <?php } ?>
    
    <div class="page-wrapper">
        <div class="page-content">
            <?php
            if (! $logged_in)
            {
            admin_login();
            }
            else
            {
            $query = mysqli_query($dbConnect, "SELECT * FROM " . DB_REPORTS . " WHERE active=1 AND status=0");
            $new_reports = mysqli_num_rows($query);
            ?>
            <div class="float-left span25">
                <div class="list-container">
                    <div class="list-header">
                        <div class="float-left">Menu</div>
                        <div class="float-clear"></div>
                    </div>
                    
                    <a href="?tab1=announcements" class="list-wrapper">Announcements</a>
                    <a href="?tab1=manage_ads" class="list-wrapper">Notices</a>
                    <a href="?tab1=general_settings" class="list-wrapper">General Settings</a>
                    <a href="?tab1=manage_pages" class="list-wrapper">Manage Pages</a>
                    <a href="?tab1=manage_groups" class="list-wrapper">Manage Groups</a>
                    
                    <a href="?tab1=manage_reports" class="list-wrapper">Manage Reports <?php if ($new_reports > 0) echo '<span class="update-alert">' . $new_reports . '</span>'; ?></a>
                    <a href="?tab1=manage_users" class="list-wrapper">Manage Users</a>
                    <a href="?tab1=manage_admin_login" class="list-wrapper">Manage Admin Login</a>




                </div>
            </div>
            <div class="float-right span75">
                <?php
                echo $post_message;
                
                switch($_GET['tab1']) {
                    case 'general_settings':
                    general_settings();
                    break;
                    
                    case 'user_settings':
                    user_settings();
                    break;
                    
                    case 'announcements':
                    announcements();
                    break;

                    case 'manage_users':
                    manage_users();
                    break;
                    
                    case 'manage_pages':
                    manage_pages();
                    break;
                    
                    case 'manage_groups':
                    manage_groups();
                    break;
                    
                    case 'manage_reports':
                    manage_reports();
                    break;
                    
                    case 'manage_ads':
                    manage_ads();
                    break;
                    
                    case 'manage_admin_login':
                    manage_admin_login();
                    break;
                    
                    case 'edit_user':
                    edit_user();
                    break;
                    
                    case 'delete_user':
                    delete_user();
                    break;
                    
                    case 'edit_group':
                    edit_group();
                    break;
                    
                    case 'delete_group':
                    delete_group();
                    break;
                    
                    case 'edit_page':
                    edit_page();
                    break;
                    
                    case 'delete_page':
                    delete_page();
                    break;

                    case 'reset_password':
                    reset_password();
                    break;
                }
                ?>
            </div>
            <div class="float-clear"></div>
            <?php } ?>
        </div>
    </div>

    <?php if ($logged_in) { ?>
    <div class="footer-wrapper">
        
            <div class="footer-line">
                
            </div>
        
    </div>
    <?php } ?>
</body>