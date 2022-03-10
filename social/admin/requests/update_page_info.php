<?php
$message = 'Failed to save changes. Please do not keep required fields empty.';

if (isset($_POST['update_page_information']) && !empty($_POST['page_id']) && is_numeric($_POST['page_id']) && isset($_POST['keep_blank']) && empty($_POST['keep_blank']) && $logged_in == true) {
    $saved = false;
    $page_id = SK_secureEncode($_POST['page_id']);
    $set_query_one = 'id=id';
    $set_query_two = 'id=id';
    $continue = true;
    
    if (isset($_POST['verified'])) {
        $verified = SK_secureEncode($_POST['verified']);
        
        if (preg_match('/(0|1)/', $verified)) {
            $set_query_one .= ",verified='$verified'";
        } else {
            $message = 'Unable to verify. Wrong input value';
        }
    }
    
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
    }
    
    if (!empty($_POST['about'])) {
        $about = SK_secureEncode($_POST['about']);
        $set_query_one .= ",about='$about'";
    } else {
        $set_query_one .= ",about=''";
    }
    
    if (!empty($_POST['category_id']) && is_numeric($_POST['category_id']) && $_POST['category_id'] > 0) {
        $category_id = SK_secureEncode($_POST['category_id']);
        $set_query_two .= ",category_id='$category_id'";
    }
    
    if (!empty($_POST['address'])) {
        $address = SK_secureEncode($_POST['address']);
        $set_query_two .= ",address='$address'";
    } else {
        $set_query_two .= ",address=''";
    }
    
    if (!empty($_POST['awards'])) {
        $awards = SK_secureEncode($_POST['awards']);
        $set_query_two .= ",awards='$awards'";
    } else {
        $set_query_two .= ",awards=''";
    }
    
    if (!empty($_POST['phone'])) {
        $phone = SK_secureEncode($_POST['phone']);
        $set_query_two .= ",phone='$phone'";
    } else {
        $set_query_two .= ",phone=''";
    }
    
    if (!empty($_POST['products'])) {
        $products = SK_secureEncode($_POST['products']);
        $set_query_two .= ",products='$products'";
    } else {
        $set_query_two .= ",products=''";
    }
    
    if (!empty($_POST['website'])) {
        $website = SK_secureEncode($_POST['website']);
        $set_query_two .= ",website='$website'";
    } else {
        $set_query_two .= ",website=''";
    }
    
    if (!empty($_POST['message_privacy'])) {
        $message_privacy = SK_secureEncode($_POST['message_privacy']);
        $set_query_two .= ",message_privacy='$message_privacy'";
        
        if (!preg_match('/(everyone|none)/', $message_privacy)) {
            $continue = false;
            $message = 'Invalid value on message_privacy field';
        }
    }
    
    if (!empty($_POST['timeline_post_privacy'])) {
        $timeline_post_privacy = SK_secureEncode($_POST['timeline_post_privacy']);
        $set_query_two .= ",timeline_post_privacy='$timeline_post_privacy'";
        
        if (!preg_match('/(everyone|admins)/', $timeline_post_privacy)) {
            $continue = false;
            $message = 'Invalid value on timeline_post_privacy field';
        }
    }
    
    if ($continue == true) {
        $query_one = "UPDATE " . DB_ACCOUNTS . " SET $set_query_one WHERE id=" . $page_id;
        $sql_query_one = mysqli_query($dbConnect, $query_one);
        
        if ($sql_query_one) {
            $query_two = "UPDATE " . DB_PAGES . " SET $set_query_two WHERE id=" . $page_id;
            $sql_query_two = mysqli_query($dbConnect, $query_two);
            
            if ($sql_query_two) {
                $saved = true;
            }
        }
    }
    
    if ($saved == true) {
        $post_message = '<div class="post-success">Page information updated!</div>';
    } else {
        $post_message = '<div class="post-failure">' . $message . '</div>';
    }
}
