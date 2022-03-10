<?php
if (isset($_POST['update_user_password']) && !empty($_POST['user_id']) && is_numeric($_POST['user_id']) && isset($_POST['keep_blank']) && empty($_POST['keep_blank']) && $logged_in == true) {
    $user_id = SK_secureEncode($_POST['user_id']);
    $saved = false;
    
    if (!empty($_POST['password'])) {
        $password = SK_secureEncode($_POST['password']);
        $md5_password = md5($password);
        
        $query_one = "UPDATE ". DB_ACCOUNTS ." SET password='$md5_password' WHERE id=" . $user_id;
        $sql_query_one = mysqli_query($dbConnect, $query_one);
        
        if ($sql_query_one) {
            $saved = true;
        }
    }
    
    if ($saved == true) {
        $post_message = '<div class="post-success">User password updated!</div>';
    }
    else {
        $post_message = '<div class="post-failure">Failed to save changes. Please do not keep required fields empty.</div>';
    }
}
