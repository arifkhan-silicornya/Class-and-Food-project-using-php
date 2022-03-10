<?php 
require_once("../../php/conect_database.php");

$pid = htmlentities($_REQUEST['pid']);
$product_name = htmlentities($_POST['product_name']);
$product_Quantity = htmlentities($_POST['product_Quantity']);
$product_price = htmlentities($_POST['product_price']);
$pro_category = htmlentities($_POST['pro_category']);
$product_details  = htmlentities($_POST['product_details']);


if (isset($_POST['product_name']) && isset($_POST['product_Quantity']) && isset($_POST['product_name']) && isset($_POST['product_name']) && isset($_REQUEST['product_name'])) {
    
    $sql="UPDATE `products` SET `pro_name`='$product_name',`pro_quantity`='$product_Quantity',`pro_price`='$product_price',`pro_details`='$product_details',`pro_category`='$pro_category' WHERE `id`= '$pid' ";
    
    $result=mysqli_query($connect,$sql); 

    if ($result == true){
        header("location:../viewProductList.php?Produc_Updated");
    }
    else {
        header("location:../viewProductList.php?OperationFailed");
    }
}
else {
    header("location:../viewProductList.php?OperationFailed");
}





?>