<?php 
require_once("../../php/conect_database.php");

$pid = $_REQUEST['pid'];

$stock_update = htmlentities($_POST['stock_update']);

if (isset($_POST['stock_update'])) {
    $sql="UPDATE `products` SET `pro_quantity` = '$stock_update'  WHERE `id`='$pid' ";
    $result=mysqli_query($connect, $sql);
    if ($result == true) {
        header("location:../viewProductList.php?StockUpdated");
    } else {
        header("location:../viewProductList.php?Failed_error :".mysqli_error($sql));
    }
}
else {
    header("location:../viewProductList.php?ValueNotFound");
}



?>