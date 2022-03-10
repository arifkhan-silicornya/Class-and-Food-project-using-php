<?php
require_once("../../php/conect_database.php");

   $product_name = htmlentities($_REQUEST['product_name']);
   $product_Quantity = htmlentities($_REQUEST['product_Quantity']);
   $product_price = htmlentities($_REQUEST['product_price']);
   $pro_category = htmlentities($_REQUEST['pro_category']);
   $product_details  = htmlentities($_REQUEST['product_details']);



if (isset($_FILES['product_image'])) {
    $uploads_dir = "../../assets/img/product/";
    $tmp_name = $_FILES["product_image"]["tmp_name"];
    $name = $_FILES["product_image"]["name"];
    $uniqName = $product_name.'_'.uniqid();
    $moveToFolder = move_uploaded_file($tmp_name, "$uploads_dir/$uniqName.jpg");
    if ($moveToFolder ==true)
        {
            $sql="INSERT INTO `products` (`id`, `pro_name`, `pro_img_name`, `img_path`, `pro_quantity`, `pro_price`, `pro_details`, `pro_category`) VALUES (NULL, '$product_name', '$uniqName', '$uploads_dir', '$product_Quantity', '$product_price', '$product_details', '$pro_category')";
            $result=mysqli_query($connect,$sql); 

        if ($result == true){
            header("location:../addNewFood.php?New_Product_Added");
        }
        else {
            header("location:../addNewFood.php?OperationFailed");
        } 
    }
    else{
            header("location:../addNewFood.php?error :".mysqli_error($sql));
        }
}



?>