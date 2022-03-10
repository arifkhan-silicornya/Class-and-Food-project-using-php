<?php
if (isset($_GET['tab1']) && $_GET['tab1'] == "manage_reports" && $logged_in == true) {
    
    if (!empty($_GET['id']) && !empty($_GET['action']))
    {
        $id = SK_secureEncode($_GET['id']);
        $action = SK_secureEncode($_GET['action']);
        $query_one = "SELECT * FROM " . DB_REPORTS . " WHERE id=$id AND active=1 AND status=0";
        $sql_query_one = mysqli_query($dbConnect, $query_one);
        
        if (mysqli_num_rows($sql_query_one) == 1) {
            $sql_fetch_one = mysqli_fetch_assoc($sql_query_one);
            $saved = false;
            
            if ($action == "mark_safe")
            {
                if (mysqli_query($dbConnect, "UPDATE " . DB_REPORTS . " SET status=1 WHERE id=" . $id)) {
                    $saved = true;
                }
            }
            elseif ($action == "delete")
            {
                if ($sql_fetch_one['type'] == "comment")
                {
                    mysqli_query($dbConnect, "DELETE FROM " . DB_COMMENTS . " WHERE id=" . $sql_fetch_one['post_id']);
                }
                else
                {
                    mysqli_query($dbConnect, "DELETE FROM " . DB_POSTS . " WHERE post_id=" . $sql_fetch_one['post_id']);
                }
                mysqli_query($dbConnect, "UPDATE " . DB_REPORTS . " SET status=2 WHERE id=$id");
                $saved = true;
            }
            
            if ($saved == true)
            {
                $post_message = '<div class="post-success">Action completed!</div>';
            }
            else
            {
                $post_message = '<div class="post-failure">Unable to process action. Please try again.</div>';
            }
        }
    }
}
