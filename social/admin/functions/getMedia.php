<?php
function SK_getMedia($file_id=0) {
    global $config, $dbConnect;
    
    if (is_numeric($file_id)) {
        $query = "SELECT * FROM " . DB_MEDIA . " WHERE id=$file_id";
        $sql_query = mysqli_query($dbConnect, $query);
        
        if (mysqli_num_rows($sql_query) == 1) {
            $sql_fetch = mysqli_fetch_assoc($sql_query);
            $sql_fetch['post_url'] = SK_smoothLink('index.php?tab1=post&post_id=' . $sql_fetch['post_id']);
            
            return $sql_fetch;
        }
    }
}
