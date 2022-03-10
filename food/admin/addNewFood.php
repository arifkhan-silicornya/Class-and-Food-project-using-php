<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>add-new-food</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/styles.min.css?h=1f8afc18ec3ce05d9a2e38380bd93365">
    <style>
        .user-profile-image{
            height: 100px;
            width: 100px;   
        }
    </style>
</head>

<body >
<!-- ......................header file included..................... -->
<?php include 'header.php';?>
<?php


$id=$_SESSION['adminId'];
$sql="SELECT * FROM `admin` WHERE `username`='$id'";
$Result=mysqli_query($connect, $sql);

while ($row=mysqli_fetch_array($Result)) {
    $uname=$row['username'];
    $profile_pic=$row['profile_pic'];
}
    
?>

<div class="container-fluid d-flex">

                    <!-- ===================left side Start ======================  -->
                    <?php include 'sidebar.php';?>

<!-- ======================================================= left side end ===================================== -->
<div class="clearfix"></div>




<!-- ===================================== Right Side Start =========================================
     ================================================================================================
     =================================================================================================== -->

    
<div class="py-2 pl-3 border border-primary my-1 mx-auto w-100 d-flex " style="height: auto;">

<!-- ================ Add New Product Start ====================== -->
<div class="mx-auto w-50" id="addNewProduct" >
    <div class="text-center w-100 my-3 py-2 btn btn-outline-info font-weight-bold border border-info"> Add New Product</div>
    <form action="controller/addnewproduct.php" method="POST" enctype="multipart/form-data" class="border border-info p-3">
        <div class="form-group">
        <label for="pro_img" class="font-weight-bold">Product Image</label>
            <input id="pro_img" class="form-control lg-frc border border-info" type="file" required placeholder="Product Image" name="product_image">
        </div>
        <div class="form-group">
        <label for="pro_name" class="font-weight-bold">Product Name</label>
            <input id="pro_name" class="form-control lg-frc border border-info" type="text" required placeholder="Product Name" name="product_name">
        </div> 
        <div class="form-group">
            <label for="pro_qnty" class="font-weight-bold">Product Quantity</label>
            <input id="pro_qnty" class="form-control lg-frc border border-info" type="number" required placeholder="Product Quantity" name="product_Quantity" min="0">
        </div>
        <div class="form-group">
            <label for="pro_price" class="font-weight-bold">Product Price</label>
            <input id="pro_price" class="form-control lg-frc border border-info" type="number" required placeholder="Product Price" name="product_price" min="0">
        </div>
        <div class="form-group">
            <label for="pro_category" class="font-weight-bold">Product Category</label>
            <select class="custom-select border border-info" name="pro_category" id="pro_category" required>
                <option >Select Product Category</option>
                <option value="breakfast">Breakfast</option>
                <option value="lunch">Lunch</option>
                <option value="drinks">Drinks</option>
                <option value="dryfood">DryFood</option>
                <option value="others">Other's</option>
            </select>
        </div>
        <div class="form-group">
            <label for="pro_details" class="font-weight-bold">Product Details</label>
            <textarea class="form-control border border-info" required id="pro_details" rows="4" name="product_details"></textarea>
        </div> 



        <button type="submit" class="w-100 btn btn-outline-info mt-3 font-weight-bold">Add New</button>
    </form>
</div>
<!-- ================================= Add New Product End ======================================== -->
    </div>
</div>



<!-- ......................footer file included..................... -->
<?php include 'footer.php'; ?>

    <!-- End: Bootstrap Cards v2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.min.js?h=43583f9c06d57d8535a11a9e2f5a6a7c"></script>
</body>

</html>

