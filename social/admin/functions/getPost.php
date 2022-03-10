<?php
function SK_getPost($post_id=0, $type='story') {
    global $config, $dbConnect;

    if ($type == "comment")
    {
        $query_one = "SELECT id,post_id,timeline_id FROM " . DB_COMMENTS . " WHERE id=$post_id AND active=1";
        $sql_query_one = mysqli_query($dbConnect, $query_one);
    }
    else
    {
        $query_one = "SELECT id,post_id,timeline_id FROM " . DB_POSTS . " WHERE id=$post_id AND active=1";
        $sql_query_one = mysqli_query($dbConnect, $query_one);
    }
    
    if (mysqli_num_rows($sql_query_one) == 1)
    {
        $sql_fetch_one = mysqli_fetch_assoc($sql_query_one);
        $sql_fetch_one['type'] = $type;
        
        return $sql_fetch_one;
    }
}
