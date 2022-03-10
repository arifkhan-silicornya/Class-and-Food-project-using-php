<?php
if (isset($_POST['update_user_settings']) && isset($_POST['keep_blank']) && empty($_POST['keep_blank']) && $logged_in == true) {
    $saved = false;
    
    if (!empty($_POST['comment_privacy']) && isset($_POST['confirm_followers']) && !empty($_POST['follow_privacy']) && !empty($_POST['message_privacy']) && !empty($_POST['timeline_post_privacy'])) {
        $comment_privacy = SK_secureEncode($_POST['comment_privacy']);
        $confirm_followers = SK_secureEncode($_POST['confirm_followers']);
        $follow_privacy = SK_secureEncode($_POST['follow_privacy']);
        $message_privacy = SK_secureEncode($_POST['message_privacy']);
        $timeline_post_privacy = SK_secureEncode($_POST['timeline_post_privacy']);
        $post_privacy = SK_secureEncode($_POST['post_privacy']);
        
        if (preg_match('/(everyone|following)/', $comment_privacy) && preg_match('/(0|1)/', $confirm_followers) && preg_match('/(everyone|following)/', $follow_privacy) && preg_match('/(everyone|following)/', $message_privacy) && preg_match('/(everyone|following|none)/', $timeline_post_privacy) && preg_match('/(everyone|following)/', $post_privacy)) {
            $query = "ALTER TABLE ". DB_USERS ."
            ALTER comment_privacy SET DEFAULT '$comment_privacy',
            ALTER confirm_followers SET DEFAULT '$confirm_followers',
            ALTER follow_privacy SET DEFAULT '$follow_privacy',
            ALTER message_privacy SET DEFAULT '$message_privacy',
            ALTER timeline_post_privacy SET DEFAULT '$timeline_post_privacy',
            ALTER post_privacy SET DEFAULT '$post_privacy'
            ";
            $sql_query = mysqli_query($dbConnect, $query);
            
            if ($sql_query) {
                $saved = true;
            }
        }
    }
    
    if ($saved == true) {
        $post_message = '<div class="post-success">User settings updated!</div>';
    }
    else {
        $post_message = '<div class="post-failure">Failed to save changes. Please do not keep required fields empty.</div>';
    }
}
