<?php
session_start();
require_once('../assets/includes/tables.php');
require_once('../assets/includes/config.php');

$dbConnect = mysqli_connect($sql_host, $sql_user, $sql_pass, $sql_name);
mysqli_set_charset($dbConnect, "utf8");

$function_files = glob('functions/*.php');

foreach ($function_files as $func_file)
{
    require_once($func_file);
}

$config = array();
$confQuery = mysqli_query($dbConnect, "SELECT * FROM " . DB_CONFIGURATIONS);
$config = mysqli_fetch_assoc($confQuery);

$config['site_url'] = $site_url;
$config['theme_url'] = $site_url . '/main/' . $config['theme'];

if (!SK_verifyLogin()) {
    exit();
}

$data = array('status' => 0);

$t = null;

if (!empty($_GET['t'])) {
    $t = $_GET['t'];
}

if ($t == "manage_users" && !empty($_GET['after_user_id']) && is_numeric($_GET['after_user_id']) && $_GET['after_user_id'] > 0) {
    $user_id = SK_secureEncode($_GET['after_user_id']);
    
    $query = "SELECT id FROM ". DB_ACCOUNTS ." WHERE type='user' AND id IN (SELECT id FROM ". DB_USERS .") AND id<$user_id ORDER BY id DESC LIMIT 20";
    
    $sql_query = mysqli_query($dbConnect, $query);
    
    if (mysqli_num_rows($sql_query) > 0) {
        $html = '';
        
        while ($sql_fetch = mysqli_fetch_array($sql_query, MYSQLI_ASSOC)) {
        $account = SK_getAccount($sql_fetch['id']);
        
        $html .= '<div class="user-data-wrapper manage-user-list" data-user-id="' . $account['id'] . '">
            <div class="float-left span10">
                ' . $account['id'] . '
            </div>
            <div class="float-left span30" align="left">
                <img src="' . $account['thumbnail_url'] . '" width="24px" alt="" valign="middle" style="border-radius: 2px;">
                <a href="' . $config['site_url'] . '/index.php?tab1=timeline&id=' . $account['username'] . '">' . $account['name'] . '</a>
            </div>
            <div class="float-left span40" align="left">
                ' . $account['email'] . '
            </div>
            <div class="float-left span20" align="center">
                <a href="?tab1=edit_user&id=' . $account['id'] . '">Edit</a> - <a href="?tab1=delete_user&id=' . $account['id'] . '">Delete</a>
            </div>
            <div class="float-clear"></div>
        </div>';
        
        }
        
        $data = array('status' => 200, 'html' => $html);
    }
    
    header("Content-type: application/json");
    echo json_encode($data);
}

if ($t == "manage_pages" && !empty($_GET['after_page_id']) && is_numeric($_GET['after_page_id']) && $_GET['after_page_id'] > 0) {
    $page_id = SK_secureEncode($_GET['after_page_id']);
    
    $query = "SELECT id FROM ". DB_ACCOUNTS ." WHERE type='page' AND id IN (SELECT id FROM ". DB_PAGES .") AND id<$page_id ORDER BY id DESC LIMIT 20";
    
    $sql_query = mysqli_query($dbConnect, $query);
    
    if (mysqli_num_rows($sql_query) > 0) {
        $html = '';
        
        while ($sql_fetch = mysqli_fetch_array($sql_query, MYSQLI_ASSOC)) {
        $account = SK_getAccount($sql_fetch['id']);
        
        $html .= '<div class="user-data-wrapper manage-page-list" data-page-id="' . $account['id'] . '">
            <div class="float-left span10">
                ' . $account['id'] . '
            </div>
            <div class="float-left span30" align="left">
                <img src="' . $account['thumbnail_url'] . '" width="24px" alt="" valign="middle" style="border-radius: 2px;">
                <a href="' . $config['site_url'] . '/index.php?tab1=timeline&id=' . $account['username'] . '">' . $account['name'] . '</a>
            </div>
            <div class="float-left span40" align="left">
                ' . mysqli_num_rows(mysqli_query($dbConnect, "SELECT id FROM ". DB_FOLLOWERS ." WHERE following_id=" . $account['id'])) . '
            </div>
            <div class="float-left span20" align="center">
                <a href="?tab1=edit_user&id=' . $account['id'] . '">Edit</a> - <a href="?tab1=delete_user&id=' . $account['id'] . '">Delete</a>
            </div>
            <div class="float-clear"></div>
        </div>';
        
        }
        
        $data = array('status' => 200, 'html' => $html);
    }
    
    header("Content-type: application/json");
    echo json_encode($data);
}

if ($t == "manage_groups" && !empty($_GET['after_group_id']) && is_numeric($_GET['after_group_id']) && $_GET['after_group_id'] > 0) {
    $group_id = SK_secureEncode($_GET['after_group_id']);
    
    $query = "SELECT id FROM ". DB_ACCOUNTS ." WHERE type='group' AND id IN (SELECT id FROM ". DB_GROUPS .") AND id<$group_id ORDER BY id DESC LIMIT 20";
    
    $sql_query = mysqli_query($dbConnect, $query);
    
    if (mysqli_num_rows($sql_query) > 0) {
        $html = '';
        
        while ($sql_fetch = mysqli_fetch_array($sql_query, MYSQLI_ASSOC)) {
        $account = SK_getAccount($sql_fetch['id']);
        
        $html .= '<div class="user-data-wrapper manage-group-list" data-group-id="' . $account['id'] . '">
            <div class="float-left span10">
                ' . $account['id'] . '
            </div>
            <div class="float-left span30" align="left">
                <a href="' . $config['site_url'] . '/index.php?tab1=timeline&id=' . $account['username'] . '">' . $account['name'] . '</a>
            </div>
            <div class="float-left span40" align="left">
                ' . mysqli_num_rows(mysqli_query($dbConnect, "SELECT id FROM ". DB_FOLLOWERS ." WHERE following_id=" . $account['id'])) . '
            </div>
            <div class="float-left span20" align="center">
                <a href="?tab1=edit_group&id=' . $account['id'] . '">Edit</a> - <a href="?tab1=delete_group&id=' . $account['id'] . '">Delete</a>
            </div>
            <div class="float-clear"></div>
        </div>';
        
        }
        
        $data = array('status' => 200, 'html' => $html);
    }
    
    header("Content-type: application/json");
    echo json_encode($data);
}

if ($t == "manage_reports" && !empty($_GET['after_report_id']) && is_numeric($_GET['after_report_id']) && $_GET['after_report_id'] > 0) {
    $report_id = SK_secureEncode($_GET['after_report_id']);
    
    $query = "SELECT * FROM ". DB_REPORTS ." WHERE id<$report_id ORDER BY id DESC LIMIT 20";
    
    $sql_query = mysqli_query($dbConnect, $query);
    
    if (mysqli_num_rows($sql_query) > 0) {
        $html = '';
        
        while ($report = mysqli_fetch_assoc($sql_query)) {
        $reporter = SK_getAccount($report['reporter_id']);
        $post = SK_getPost($report['post_id']);
        
        $unseen_class = '';
        
        if ($report['status'] == 0) {
            $unseen_class = ' unseen';
        }
        
        $html .= '<div class="user-data-wrapper manage-report-list' . $unseen_class . '" data-report-id="' . $report['id'] . '">
            <div class="float-left span10">
                ' . $report['id'] . '
            </div>
            <div class="float-left span30" align="left">
                <img src="' . $reporter['thumbnail_url'] . '" width="24px" alt="" valign="middle" style="border-radius: 2px;">
                <a href="' . $config['site_url'] . '/index.php?tab1=timeline&id=' . $reporter['username'] . '">' . $reporter['name'] . '</a>
            </div>
            <div class="float-left span20" align="left">
                <a href="' . $config['site_url'] . '/?tab1=story&id=' . $post['post_id'] . '#' . $post['type'] .'_' . $post['id'] . '">Show Post</a>
            </div>
            <div class="float-left span15" align="left">';
            
            if ($report['status'] == 1) $html .= 'Marked safe';
            else if ($report['status'] == 2) $html .= 'Deleted';
            else $html .= 'Pending';
            
            $html .= '</div>
            <div class="float-left span25" align="center">';
                if ($report['status'] == 0) {
                $html .= '<a href="?tab1=manage_reports&id=' . $report['id'] . '&action=mark_safe">Mark Safe</a> - 
                <a href="?tab1=manage_reports&id=' . $report['id'] . '&action=delete">Delete Post</a>';
                } else {
                $html .= 'None';
                }
            $html .= '</div>
            <div class="float-clear"></div>
        </div>';
        
        }
        
        $data = array('status' => 200, 'html' => $html);
    }
    
    header("Content-type: application/json");
    echo json_encode($data);
}
