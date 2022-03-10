<?php
if (isset($_POST['delete_user']) && isset($_POST['delete_btn']) && !empty($_POST['user_id']) && is_numeric($_POST['user_id']) && isset($_POST['keep_blank']) && empty($_POST['keep_blank']) && $logged_in == true) {
    $user_id = SK_secureEncode($_POST['user_id']);
    $saved = false;
    
    $queries[] = "DELETE FROM " . DB_POSTS . " WHERE timeline_id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_POSTS . " WHERE recipient_id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_MEDIA . " WHERE timeline_id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_FOLLOWERS . " WHERE following_id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_BLOCKERS . " WHERE blocker_id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_BLOCKERS . " WHERE blocked_id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_PAGE_ADMINS . " WHERE admin_id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_GROUP_ADMINS . " WHERE admin_id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_REPORTS . " WHERE reporter_id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_ACCOUNTS . " WHERE id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_USERS . " WHERE id=" . $user_id;

    $queries[] = "DELETE FROM " . DB_POSTLIKES . " WHERE timeline_id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_POSTSHARES . " WHERE timeline_id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_POSTFOLLOWS . " WHERE timeline_id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_COMMENTS . " WHERE timeline_id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_COMMENTLIKES . " WHERE timeline_id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_MESSAGES . " WHERE timeline_id=" . $user_id;
    $queries[] = "DELETE FROM " . DB_MESSAGES . " WHERE recipient_id=" . $user_id;
    
    foreach ($queries as $query) {
        $saved = false;
        
        if (mysqli_query($dbConnect, $query)) {
            $saved = true;
        }
    }
    
    if ($user_id == $_SESSION['user_id']) {
        header('Location: ../index.php?tab1=logout');
    }
    
    if ($saved == true) {
        $post_message = '<div class="post-success">User was deleted!</div>';
    } else {
        $post_message = '<div class="post-failure">Failed to delete. Please try again.</div>';
    }
}
