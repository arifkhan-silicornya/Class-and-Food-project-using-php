<?php
function SK_verifyLogin()
{
    global $config, $dbConnect;

    $config = array();
    $confQuery = mysqli_query($dbConnect, "SELECT * FROM " . DB_CONFIGURATIONS);
    $config = mysqli_fetch_assoc($confQuery);
    
    if (! empty($_SESSION['admin_id']) && ! empty($_SESSION['admin_password']))
    {
        if ($_SESSION['admin_id'] == $config['admin_username'] && $_SESSION['admin_password'] == $config['admin_password'])
        {
            return true;
        }
    }
}
