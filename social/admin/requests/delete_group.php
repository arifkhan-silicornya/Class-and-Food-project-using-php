<?php
if (isset($_POST['delete_group']) && isset($_POST['delete_btn']) && !empty($_POST['group_id']) && is_numeric($_POST['group_id']) && isset($_POST['keep_blank']) && empty($_POST['keep_blank']) && $logged_in == true) {
    $group_id = SK_secureEncode($_POST['group_id']);
    $saved = false;
    
    $queries[] = "DELETE FROM " . DB_POSTS . " WHERE timeline_id=" . $group_id;
    $queries[] = "DELETE FROM " . DB_POSTS . " WHERE recipient_id=" . $group_id;
    $queries[] = "DELETE FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $group_id;
    $queries[] = "DELETE FROM " . DB_MEDIA . " WHERE timeline_id=" . $group_id;
    $queries[] = "DELETE FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $group_id;
    $queries[] = "DELETE FROM " . DB_FOLLOWERS . " WHERE following_id=" . $group_id;
    $queries[] = "DELETE FROM " . DB_BLOCKERS . " WHERE blocker_id=" . $group_id;
    $queries[] = "DELETE FROM " . DB_BLOCKERS . " WHERE blocked_id=" . $group_id;
    $queries[] = "DELETE FROM " . DB_GROUP_ADMINS . " WHERE group_id=" . $group_id;
    $queries[] = "DELETE FROM " . DB_ACCOUNTS . " WHERE id=" . $group_id;
    $queries[] = "DELETE FROM " . DB_GROUPS . " WHERE id=" . $group_id;
    
    foreach ($queries as $query) {
        $saved = false;
        
        if (mysqli_query($dbConnect, $query)) {
            $saved = true;
        }
    }
    
    if ($saved == true) {
        $post_message = '<div class="post-success">Group was deleted!</div>';
    } else {
        $post_message = '<div class="post-failure">Failed to delete. Please try again.</div>';
    }
}
