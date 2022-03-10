<?php
if (isset($_POST['update_admin_login']) && isset($_POST['keep_blank']) && empty($_POST['keep_blank']) && $logged_in == true) {
    $saved = false;
    
    if (!empty($_POST['admin_username']) && !empty($_POST['admin_password'])) {
        $admin_username = SK_secureEncode($_POST['admin_username']);
        $admin_password = SK_secureEncode($_POST['admin_password']);
        $md5_admin_password = md5($admin_password);

        if (preg_match('/^[A-Za-z0-9_]+$/', $admin_username))
        {
            $process = mysqli_query($dbConnect, "UPDATE " . DB_CONFIGURATIONS . " SET admin_username='$admin_username',admin_password='$md5_admin_password'");
            
            if ($process) {
                $saved = true;
            }
        }
    }
    
    if ($saved == true) {
        $post_message = '<div class="post-success">Admin login details updated!</div>';
    } else {
        $post_message = '<div class="post-failure">Failed to save changes. Please do not keep required fields empty.</div>';
        
        if (!preg_match('/^[A-Za-z0-9_]+$/', $admin_username)) {
            $post_message = '<div class="post-failure">Invalid username.</div>';
        }
        
        if (empty($_POST['admin_password'])) {
            $post_message = '<div class="post-failure">You cannot keep password field empty. Please retype your current password if you don\'t want to change it.</div>';
        }
    }
}
