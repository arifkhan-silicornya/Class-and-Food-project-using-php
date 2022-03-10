<?php
if (isset($_POST['delete_page']) && isset($_POST['delete_btn']) && !empty($_POST['page_id']) && is_numeric($_POST['page_id']) && isset($_POST['keep_blank']) && empty($_POST['keep_blank']) && $logged_in == true) {
    $page_id = SK_secureEncode($_POST['page_id']);
    $saved = false;
    
    $queries[] = "DELETE FROM " . DB_POSTS . " WHERE timeline_id=" . $page_id;
    $queries[] = "DELETE FROM " . DB_POSTS . " WHERE recipient_id=" . $page_id;
    $queries[] = "DELETE FROM " . DB_NOTIFICATIONS . " WHERE timeline_id=" . $page_id;
    $queries[] = "DELETE FROM " . DB_MEDIA . " WHERE timeline_id=" . $page_id;
    $queries[] = "DELETE FROM " . DB_FOLLOWERS . " WHERE follower_id=" . $page_id;
    $queries[] = "DELETE FROM " . DB_FOLLOWERS . " WHERE following_id=" . $page_id;
    $queries[] = "DELETE FROM " . DB_BLOCKERS . " WHERE blocker_id=" . $page_id;
    $queries[] = "DELETE FROM " . DB_BLOCKERS . " WHERE blocked_id=" . $page_id;
    $queries[] = "DELETE FROM " . DB_PAGE_ADMINS . " WHERE page_id=" . $page_id;
    $queries[] = "DELETE FROM " . DB_ACCOUNTS . " WHERE id=" . $page_id;
    $queries[] = "DELETE FROM " . DB_PAGES . " WHERE id=" . $page_id;
    
    foreach ($queries as $query) {
        $saved = false;
        
        if (mysqli_query($dbConnect, $query)) {
            $saved = true;
        }
    }
    
    if ($saved == true) {
        $post_message = '<div class="post-success">Page was deleted!</div>';
    } else {
        $post_message = '<div class="post-failure">Failed to delete. Please try again.</div>';
    }
}
