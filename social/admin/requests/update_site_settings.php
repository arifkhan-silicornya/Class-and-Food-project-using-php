<?php
$config = array();
$confQuery = mysqli_query($dbConnect, "SELECT * FROM " . DB_CONFIGURATIONS);
$config = mysqli_fetch_assoc($confQuery);

$config['site_url'] = $site_url;
$config['theme_url'] = $site_url . '/main/' . $config['theme'];

if (isset($_POST['update_site_settings']) && isset($_POST['keep_blank']) && empty($_POST['keep_blank']) && $logged_in == true) {
    $saved = false;
    
    if (isset($_POST['friends']) && !empty($_POST['site_name']) && !empty($_POST['site_title']) && !empty($_POST['site_email']) && isset($_POST['email_verification']) && isset($_POST['chat']) && isset($_POST['captcha']) && isset($_POST['language']) && isset($_POST['smooth_links']) && isset($_POST['censored_words'])) {
        $friends = SK_secureEncode($_POST['friends']);
        $site_name = SK_secureEncode($_POST['site_name']);
        $site_title = SK_secureEncode($_POST['site_title']);
        $email = SK_secureEncode($_POST['site_email']);
        $email_verification = SK_secureEncode($_POST['email_verification']);
        $chat = SK_secureEncode($_POST['chat']);
        $captcha = SK_secureEncode($_POST['captcha']);
        $language = SK_secureEncode($_POST['language']);
        $smooth_links = SK_secureEncode($_POST['smooth_links']);
        $censored_words = $_POST['censored_words'];
        $clear_follow_table = false;

        if ($config['friends'] != true && $friends == 1)
        {
            $clear_follow_table = true;
        }
        elseif ($config['friends'] == true && $friends != 1)
        {
            $clear_follow_table = true;
        }

        $friends = (int) $friends;
        $email_verification = (int) $email_verification;
        $chat = (int) $chat;
        $captcha = (int) $captcha;
        $smooth_links = (int) $smooth_links;

        $story_character_limit = 0;
        $comment_character_limit = 0;
        $message_character_limit = 0;

        if (!empty($_POST['story_character_limit']) && is_numeric($_POST['story_character_limit']) && $_POST['story_character_limit'] > 0) {
            $story_character_limit = (int) $_POST['story_character_limit'];
        }

        if (!empty($_POST['comment_character_limit']) && is_numeric($_POST['comment_character_limit']) && $_POST['comment_character_limit'] > 0) {
            $comment_character_limit = (int) $_POST['comment_character_limit'];
        }

        if (!empty($_POST['message_character_limit']) && is_numeric($_POST['message_character_limit']) && $_POST['message_character_limit'] > 0) {
            $message_character_limit = (int) $_POST['message_character_limit'];
        }

        $reg_req_birthday = 0;
        $reg_req_currentcity = 0;
        $reg_req_hometown = 0;
        $reg_req_about = 0;

        if (! empty($_POST['reg_req_birthday']))
        {
            $reg_req_birthday = 1;
        }

        if (! empty($_POST['reg_req_currentcity']))
        {
            $reg_req_currentcity = 1;
        }

        if (! empty($_POST['reg_req_hometown']))
        {
            $reg_req_hometown = 1;
        }

        if (! empty($_POST['reg_req_about']))
        {
            $reg_req_about = 1;
        }

        $process = mysqli_query($dbConnect, "UPDATE " . DB_CONFIGURATIONS . " SET friends=$friends,site_name='$site_name',site_title='$site_title',email='$email',email_verification=$email_verification,chat=$chat,captcha=$captcha,language='$language',smooth_links='$smooth_links',censored_words='$censored_words',reg_req_birthday=$reg_req_birthday,reg_req_currentcity=$reg_req_currentcity,reg_req_hometown=$reg_req_hometown,reg_req_about=$reg_req_about,story_character_limit=$story_character_limit,comment_character_limit=$comment_character_limit,message_character_limit=$message_character_limit");

        if ($process) {
            $saved = true;

            if ($clear_follow_table == true) {
                mysqli_query($dbConnect, "DELETE FROM " . DB_FOLLOWERS);
            }
        }
    }
    
    if ($saved == true) {
        $post_message = '<div class="post-success">Website settings updated!</div>';
    } else {
        $post_message = '<div class="post-failure">Failed to save changes. Please do not keep required fields empty.</div>';
    }
}
