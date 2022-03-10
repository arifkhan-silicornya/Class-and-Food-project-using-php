<?php
if (isset($_GET['tab1']) && $_GET['tab1'] == "announcements" && $logged_in == true) {
	
	if (!empty($_GET['delete_announcement']) && is_numeric($_GET['delete_announcement']) && $_GET['delete_announcement'] > 0) {
	    $announcement_id = SK_secureEncode($_GET['delete_announcement']);
	    $query_one = "DELETE FROM " . DB_ANNOUNCEMENTS . " WHERE id=$announcement_id";
	    $sql_query_one = mysqli_query($dbConnect, $query_one);
	    $query_two = "DELETE FROM " . DB_ANNOUNCEMENT_VIEWS . " WHERE announcement_id=$announcement_id";
	    $sql_query_one = mysqli_query($dbConnect, $query_two);
	    $post_message = '<div class="post-success">Announcement deleted!</div>';
	}
}
