<?php
$message = 'Failed to save changes. Please do not keep required fields empty.';

if (isset($_POST['update_group_information']) && !empty($_POST['group_id']) && is_numeric($_POST['group_id']) && isset($_POST['keep_blank']) && empty($_POST['keep_blank']) && $logged_in == true) {
    $saved = false;
    $group_id = SK_secureEncode($_POST['group_id']);
    $set_query_one = 'id=id';
    $set_query_two = 'id=id';
    
    $continue = true;
    
    if (!empty($_POST['name'])) {
        $name = SK_secureEncode($_POST['name']);
        $set_query_one .= ",name='$name'";
    }
    
    if (!empty($_POST['username'])) {
        $username = SK_secureEncode($_POST['username']);
        $set_query_one .= ",username='$username'";
        
        if (!SK_validateUsername($username)) {
            $continue = false;
            $message = 'Invalid username';
        }
    }
    
    if (!empty($_POST['email'])) {
        $email = SK_secureEncode($_POST['email']);
        $set_query_one .= ",email='$email'";
        
        if (!SK_validateEmail($email)) {
            $message = 'Invalid email';
        }
    }
    
    if (!empty($_POST['about'])) {
        $about = SK_secureEncode($_POST['about']);
        $set_query_one .= ",about='$about'";
    } else {
        $set_query_one .= ",about=''";
    }
    
    if (!empty($_POST['group_privacy'])) {
        $group_privacy = SK_secureEncode($_POST['group_privacy']);
        $set_query_two .= ",group_privacy='$group_privacy'";
        
        if (!preg_match('/(open|closed|secret)/', $group_privacy)) {
            $continue = false;
            $message = 'Invalid value in group_privacy field';
        }
    }
    
    if (!empty($_POST['add_privacy'])) {
        $add_privacy = SK_secureEncode($_POST['add_privacy']);
        $set_query_two .= ",add_privacy='$add_privacy'";
        
        if (!preg_match('/(members|admins)/', $add_privacy)) {
            $continue = false;
            $message = 'Invalid value in add_privacy field';
        }
    }
    
    if (!empty($_POST['timeline_post_privacy'])) {
        $timeline_post_privacy = SK_secureEncode($_POST['timeline_post_privacy']);
        $set_query_two .= ",timeline_post_privacy='$timeline_post_privacy'";
        
        if (!preg_match('/(everyone|admins)/', $timeline_post_privacy)) {
            $continue = false;
            $message = 'Invalid value in timeline_post_privacy field';
        }
    }
    
    if ($continue == true) {
        $query_one = "UPDATE " . DB_ACCOUNTS . " SET $set_query_one WHERE id=$group_id";
        $sql_query_one = mysqli_query($dbConnect, $query_one);
        
        if ($sql_query_one) {
            $query_two = "UPDATE " . DB_GROUPS . " SET $set_query_two WHERE id=$group_id";
            $sql_query_two = mysqli_query($dbConnect, $query_two);
            
            if ($sql_query_two) {
                $saved = true;
            }
        }
    }
    
    if ($saved == true) {
        $post_message = '<div class="post-success">Group information updated!</div>';
    } else {
        $post_message = '<div class="post-failure">' . $message . '</div>';
    }
}
