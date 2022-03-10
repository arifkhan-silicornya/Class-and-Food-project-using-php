<?php
require_once("../php/conect_database.php");

if (empty($_REQUEST['pid'])) {
    header("location:../dashboard.php?ValueNotFound");
}
$pid = $_REQUEST['pid'];

$productQuery = "SELECT * FROM `products` where `id` = '$pid'";

$pro_qry_Result = mysqli_query($connect, $productQuery);

while ($row3=mysqli_fetch_array($pro_qry_Result)) {
    $pid=$row3['id'];
    $pro_name=$row3['pro_name'];
    $pro_img_name=$row3['pro_img_name'];
    $pro_quantity=$row3['pro_quantity'];
    $pro_price=$row3['pro_price'];
    $pro_details=$row3['pro_details'];
    $pro_category=$row3['pro_category'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Getting Started</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../assets/css/styles.min.css">
    <style>

    </style>
</head>

<body>
<!-- ......................Header file included..................... -->
<?php include 'header.php';?>

<div class="mx-auto w-25" id="addNewProduct" style="display: block;">
    <div class="text-center w-100 my-3 py-2 btn btn-outline-info font-weight-bold border border-info"> Update Product </div>
    <form action="controller/updateProduct.php?pid=<?php echo $pid ; ?>" method="POST" enctype="multipart/form-data" class="border border-info p-3">
        <div class="form-group font-weight-bold text-center">Product Image</div>
        <div class="form-group font-weight-bold text-center"><img src="../assets/img/product/<?php echo $pro_img_name ; ?>.jpg" alt="image" class="mx-auto" style="height:100px;width:160px"></div>
        <div class="form-group">
        <label for="pro_name" class="font-weight-bold">Product Name</label>
            <input id="pro_name" class="form-control lg-frc border border-info" type="text" required placeholder="Product Name" name="product_name" value="<?php echo $pro_name;?>">
        </div> 
        <div class="form-group">
            <label for="pro_qnty" class="font-weight-bold">Product Quantity</label>
            <input id="pro_qnty" class="form-control lg-frc border border-info" type="number" required placeholder="Product Quantity" name="product_Quantity" min="0" value="<?php echo $pro_quantity;?>">
        </div>
        <div class="form-group">
            <label for="pro_price" class="font-weight-bold">Product Price</label>
            <input id="pro_price" class="form-control lg-frc border border-info" type="number" required placeholder="Product Price" name="product_price" min="0" value="<?php echo $pro_price;?>">
        </div>
        <div class="form-group">
            <label for="pro_category" class="font-weight-bold">Product Category</label>
            <select class="custom-select border border-info" name="pro_category" id="pro_category">
                <option ><?php echo $pro_category;?></option>
                <option value="breakfast">Breakfast Lunch</option>
                <option value="lunch">Lunch</option>
                <option value="drinks">Drinks</option>
                <option value="dryfood">DryFood</option>
                <option value="others">Other's</option>
            </select>
        </div>
        <div class="form-group">
            <label for="pro_details" class="font-weight-bold">Product Details</label>
            <textarea class="form-control border border-info" required id="pro_details" rows="4" name="product_details"><?php echo $pro_details;?></textarea>
        </div> 



        <button type="submit" class="w-100 btn btn-outline-info mt-3 font-weight-bold" onclick="return confirm('Do You Want To Update Stock ?')">Update </button>
    </form>
</div>    

    
    

<!-- ......................footer file included..................... -->
<?php include 'footer.php'; ?>


</body>

</html>