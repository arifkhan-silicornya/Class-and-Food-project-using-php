<?php 
require_once("../../php/conect_database.php");

$pid = $_REQUEST['pid'];


if (isset($_REQUEST['pid'])) {
    $sql="DELETE FROM `products` WHERE `id`='$pid' ";
    $result=mysqli_query($connect, $sql);
    if ($result == true) {
        header("location:../viewProductList.php?Product_Deleted_Forever");
    } else {
        header("location:../viewProductList.php?Failed_error :".mysqli_error($sql));
    }
}
else {
    header("location:../viewProductList.php?ValueNotFound");
}



?>