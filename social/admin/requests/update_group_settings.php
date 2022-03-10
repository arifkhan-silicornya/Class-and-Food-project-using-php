<?php
if (isset($_POST['update_group_settings']) && isset($_POST['keep_blank']) && empty($_POST['keep_blank']) && $logged_in == true) {
    $saved = false;
    
    if (!empty($_POST['add_privacy']) && !empty($_POST['timeline_post_privacy'])) {
        $add_privacy = SK_secureEncode($_POST['add_privacy']);
        $timeline_post_privacy = SK_secureEncode($_POST['timeline_post_privacy']);
        
        if (preg_match('/(members|admins)/', $add_privacy) && preg_match('/(members|admins)/', $timeline_post_privacy)) {
            $query = "ALTER TABLE " . DB_GROUPS . " ALTER add_privacy SET DEFAULT '$add_privacy', ALTER timeline_post_privacy SET DEFAULT '$timeline_post_privacy'";
            $sql_query = mysqli_query($dbConnect, $query);
            
            if ($sql_query) {
                $saved = true;
            }
        }
    }
    
    if ($saved == true) {
        $post_message = '<div class="post-success">Group settings updated!</div>';
    } else {
        $post_message = '<div class="post-failure">Failed to save changes. Please do not keep required fields empty.</div>';
    }
}
