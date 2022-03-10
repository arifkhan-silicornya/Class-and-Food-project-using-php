<?php
if (isset($_POST['add_new_announcement']) && !empty($_POST['announcement_text']) && isset($_POST['keep_blank']) && empty($_POST['keep_blank']) && $logged_in == true) {
    $text = str_replace("'", "&apos;", $_POST['announcement_text']);
    $saved = false;
    $query = "INSERT INTO " . DB_ANNOUNCEMENTS . " (text,time) VALUES ('$text','" . time() . "')";
    $sql_query = mysqli_query($dbConnect, $query);

    if ($sql_query) {
        $saved = true;
    }
    
    if ($saved === true) {
        $post_message = '<div class="post-success">New announcement added!</div>';
    } else {
        $post_message = '<div class="post-failure">Failed to add new announcement. Please try again.</div>';
    }
}
