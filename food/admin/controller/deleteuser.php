<?php 
require_once("../../php/conect_database.php");

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $update = " UPDATE `users` SET `deleted`= '1'  WHERE `id`= '$id' ";
    $Result=mysqli_query($connect,$update);

    reset($id);
    
    if($Result == true)
        { 
            header("location:../manageCustomer.php?userHasBeenDeleted");
    }
    else {
        header("location:../manageCustomer.php?UserNotDelete");
    }
    
}
else {
    header("location:../manageCustomer.php");
}


?>