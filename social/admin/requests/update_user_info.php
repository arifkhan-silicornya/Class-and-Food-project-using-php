<?php
$message = 'Failed to save changes. Please do not keep required fields empty.';

if (isset($_POST['update_user_information']) && !empty($_POST['user_id']) && is_numeric($_POST['user_id']) && isset($_POST['keep_blank']) && empty($_POST['keep_blank']) && $logged_in == true) {
    $saved = false;
    $user_id = SK_secureEncode($_POST['user_id']);
    $set_query_one = 'id=id';
    $set_query_two = 'id=id';
    $continue = true;
    
    if (isset($_POST['verified'])) {
        $verified = SK_secureEncode($_POST['verified']);
        
        if (preg_match('/(0|1)/', $verified)) {
            $set_query_one .= ",verified='$verified'";
        } else {
            $continue = false;
            $message = 'Unable to verify. Invalid input value';
        }
    }
    
    if (!empty($_POST['name'])) {
        $name = SK_secureEncode($_POST['name']);
        $set_query_one .= ",name='$name'";
    }
    
    if (!empty($_POST['username'])) {
        $username = SK_secureEncode($_POST['username']);
        
        if (SK_validateUsername($username)) {
            $set_query_one .= ",username='$username'";
        } else {
            $continue = false;
            $message = 'Invalid username';
        }
    }
    
    if (!empty($_POST['email'])) {
        $email = SK_secureEncode($_POST['email']);
        
        if (SK_validateEmail($email)) {
            $set_query_one .= ",email='$email'";
        } else {
            $continue = false;
            $message = 'Invalid email';
        }
    }
    
    if (!empty($_POST['about'])) {
        $about = SK_secureEncode($_POST['about']);
        $set_query_one .= ",about='$about'";
    } else {
        $set_query_one .= ",about=''";
    }
    
    if (!empty($_POST['current_city'])) {
        $current_city = SK_secureEncode($_POST['current_city']);
        $set_query_two .= ",current_city='$current_city'";
    } else {
        $set_query_two .= ",current_city=''";
    }
    
    if (!empty($_POST['hometown'])) {
        $hometown = SK_secureEncode($_POST['hometown']);
        $set_query_two .= ",hometown='$hometown'";
    } else {
        $set_query_two .= ",hometown=''";
    }
    
    if (!empty($_POST['gender'])) {
        $gender = SK_secureEncode($_POST['gender']);
        $set_query_two .= ",gender='$gender'";
        
        if (!preg_match('/(male|female)/', $gender)) {
            $continue = false;
            $message = 'Unknow gender';
        }
    }
    
    if (!empty($_POST['birthday'])) {
        
        if (!is_numeric($_POST['birthday'][0]) or $_POST['birthday'][0] > 31 or !is_numeric($_POST['birthday'][1]) or $_POST['birthday'][1] > 12) {
            $continue = false;
            $message = 'Invalid birthday';
        } else {
            $birthday = implode('-', $_POST['birthday']);
            $birthday = SK_secureEncode($birthday);
            $set_query_two .= ",birthday='$birthday'";
        }
    }
    
    if (!empty($_POST['confirm_followers'])) {
        $confirm_followers = SK_secureEncode($_POST['confirm_followers']);
        $set_query_two .= ",confirm_followers='$confirm_followers'";
        
        if (!preg_match('/(0|1)/', $confirm_followers)) {
            $continue = false;
            $message = 'Invalid value on confirm followers field';
        }
    }
    
    if (!empty($_POST['follow_privacy'])) {
        $follow_privacy = SK_secureEncode($_POST['follow_privacy']);
        $set_query_two .= ",follow_privacy='$follow_privacy'";
        
        if (!preg_match('/(everyone|following)/', $follow_privacy)) {
            $continue = false;
            $message = 'Invalid value on follow_privacy field';
        }
    }
    
    if (!empty($_POST['message_privacy'])) {
        $message_privacy = SK_secureEncode($_POST['message_privacy']);
        $set_query_two .= ",message_privacy='$message_privacy'";
        
        if (!preg_match('/(everyone|following)/', $message_privacy)) {
            $continue = false;
            $message = 'Invalid value on message_privacy field';
        }
    }
    
    if (!empty($_POST['timeline_post_privacy'])) {
        $timeline_post_privacy = SK_secureEncode($_POST['timeline_post_privacy']);
        $set_query_two .= ",timeline_post_privacy='$timeline_post_privacy'";
        
        if (!preg_match('/(everyone|following)/', $timeline_post_privacy)) {
            $continue = false;
            $message = 'Invalid value on timeline_post_privacy field';
        }
    }
    
    if (!empty($_POST['comment_privacy'])) {
        $comment_privacy = SK_secureEncode($_POST['comment_privacy']);
        $set_query_two .= ",comment_privacy='$comment_privacy'";
        
        if (!preg_match('/(everyone|following)/', $comment_privacy)) {
            $continue = false;
            $message = 'Invalid value on comment_privacy field';
        }
    }
    
    if ($continue == true) {
        $query_one = "UPDATE ". DB_ACCOUNTS ." SET $set_query_one WHERE id=" . $user_id;
        $sql_query_one = mysqli_query($dbConnect, $query_one);
        
        if ($sql_query_one) {
            $query_two = "UPDATE ". DB_USERS ." SET $set_query_two WHERE id=" . $user_id;
            $sql_query_two = mysqli_query($dbConnect, $query_two);
            
            if ($sql_query_two) {
                $saved = true;
            }
        }
    }
    
    if ($saved == true) {
        $post_message = '<div class="post-success">User information updated!</div>';
    }
    else {
        $post_message = '<div class="post-failure">' . $message . '</div>';
    }
}
