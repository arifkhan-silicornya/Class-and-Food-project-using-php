<?php
if (isset($_POST['update_page_settings']) && isset($_POST['keep_blank']) && empty($_POST['keep_blank']) && $logged_in == true) {
    $saved = false;
    
    if (!empty($_POST['message_privacy']) && !empty($_POST['timeline_post_privacy'])) {
        $message_privacy = SK_secureEncode($_POST['message_privacy']);
        $timeline_post_privacy = SK_secureEncode($_POST['timeline_post_privacy']);
        
        if (preg_match('/(everyone|none)/', $message_privacy) && preg_match('/(everyone|admins)/', $timeline_post_privacy)) {
            $query = "ALTER TABLE " . DB_PAGES . " ALTER message_privacy SET DEFAULT '$message_privacy', ALTER timeline_post_privacy SET DEFAULT '$timeline_post_privacy'";
            $sql_query = mysqli_query($dbConnect, $query);
            
            if ($sql_query) {
                $saved = true;
            }
        }
    }
    
    if ($saved == true) {
        $post_message = '<div class="post-success">Page settings updated!</div>';
    } else {
        $post_message = '<div class="post-failure">Failed to save changes. Please do not keep required fields empty.</div>';
    }
}
