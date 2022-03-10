<?php
function SK_getAccount($account_id=0) {
    global $config, $dbConnect;
    
    if (is_numeric($account_id)) {
        $check_query_part = "id=" . SK_secureEncode($account_id);
    } elseif (preg_match('/[A-Za-z0-9_]/', $account_id)) {
        $check_query_part = "username='" . SK_secureEncode($account_id) . "'";
    }
    
    $check_query = "SELECT * FROM " . DB_ACCOUNTS . " WHERE $check_query_part AND active=1";
    $check_sql_query = mysqli_query($dbConnect, $check_query);
    
    if (!mysqli_num_rows($check_sql_query) == 1) {
        return false;
    }
    
    $check_sql_fetch = mysqli_fetch_assoc($check_sql_query);
    
    if (is_numeric($check_sql_fetch['id'])) {
        $account_query = "SELECT * FROM " . DB_ACCOUNTS . " WHERE id=" . $check_sql_fetch['id'] . " AND active=1";
        $account_sql_query = mysqli_query($dbConnect, $account_query);
        
        if (mysqli_num_rows($account_sql_query) == 1) {
            $account_sql_fetch = mysqli_fetch_assoc($account_sql_query);
            $account_sql_fetch['password'] = '';
            $account_sql_fetch['url'] = SK_smoothLink('index.php?tab1=timeline&id=' . $account_sql_fetch['username']);
            $account_name_array = explode(' ', $account_sql_fetch['name']);
            $account_sql_fetch['first_name'] = $account_name_array[0];
            $account_sql_fetch['last_name'] = $account_name_array[count($account_name_array)-1];
            $no_avatar = false;
            
            if ($account_sql_fetch['cover_id'] > 0) {
                $account_sql_fetch['cover'] = SK_getMedia($account_sql_fetch['cover_id']);
                $account_sql_fetch['actual_cover_url'] =  $config['theme_url'] . '/' . $account_sql_fetch['cover']['url'] . '.' . $account_sql_fetch['cover']['extension'];
                $account_sql_fetch['cover_url'] =  $config['theme_url'] . '/' . $account_sql_fetch['cover']['url'] . '_cover.' . $account_sql_fetch['cover']['extension'];
            } else {
                $account_sql_fetch['actual_cover_url'] = $account_sql_fetch['cover_url'] =  $config['theme_url'].'/images/default_cover.png';
            }
            
            if ($account_sql_fetch['avatar_id'] > 0) {
                $account_sql_fetch['avatar'] = SK_getMedia($account_sql_fetch['avatar_id']);
                $account_sql_fetch['thumbnail_url'] =  $config['site_url'] . '/' . $account_sql_fetch['avatar']['url'] . '_thumb.' . $account_sql_fetch['avatar']['extension'];
                $account_sql_fetch['avatar_url'] =  $config['theme_url'] . '/' . $account_sql_fetch['avatar']['url'] . '_100x100.' . $account_sql_fetch['avatar']['extension'];
            } else {
                $no_avatar = true;
            }
            
            if ($account_sql_fetch['type'] == "user") {
                $user_query = "SELECT * FROM " . DB_USERS . " WHERE id=" . $account_sql_fetch['id'];
                $user_sql_query = mysqli_query($dbConnect, $user_query);
                
                if (mysqli_num_rows($user_sql_query) == 1) {
                    $user_sql_fetch = mysqli_fetch_assoc($user_sql_query);
                    $user_sql_fetch['birth'] = explode('-', $user_sql_fetch['birthday']);
                    $user_sql_fetch['birth']['date'] = $user_sql_fetch['birth'][0];
                    $user_sql_fetch['birth']['month'] = $user_sql_fetch['birth'][1];
                    $user_sql_fetch['birth']['year'] = $user_sql_fetch['birth'][2];
                    
                    if ($no_avatar == true) {
                        
                        if ($user_sql_fetch['gender'] == "female") {
                            $account_sql_fetch['thumbnail_url'] = $account_sql_fetch['avatar_url'] = $config['theme_url'] . '/images/default-female-avatar.png';
                        } else {
                            $account_sql_fetch['thumbnail_url'] = $account_sql_fetch['avatar_url'] = $config['theme_url'] . '/images/default-male-avatar.png';
                        }
                    }
                    
                    return array_merge($account_sql_fetch,$user_sql_fetch);
                }
            } elseif ($account_sql_fetch['type'] == "page") {
                $page_query = "SELECT * FROM " . DB_PAGES . " WHERE id=" . $account_sql_fetch['id'];
                $page_sql_query = mysqli_query($dbConnect, $page_query);
                
                if (mysqli_num_rows($page_sql_query) == 1) {
                    $page_sql_fetch = mysqli_fetch_array($page_sql_query,MYSQLI_ASSOC);
                    
                    if ($no_avatar == true) {
                        $account_sql_fetch['thumbnail_url'] = $account_sql_fetch['avatar_url'] = $config['theme_url'] . '/images/default-page-avatar.png';
                    }
                    
                    return array_merge($account_sql_fetch,$page_sql_fetch);
                }
            } elseif ($account_sql_fetch['type'] == "group") {
                $group_query = "SELECT * FROM " . DB_GROUPS . " WHERE id=" . $account_sql_fetch['id'];
                $group_sql_query = mysqli_query($dbConnect, $group_query);
                
                if (mysqli_num_rows($group_sql_query) == 1) {
                    $group_sql_fetch = mysqli_fetch_array($group_sql_query, MYSQLI_ASSOC);
                    
                    return array_merge($account_sql_fetch, $group_sql_fetch);
                }
            }
        }
    }
}
