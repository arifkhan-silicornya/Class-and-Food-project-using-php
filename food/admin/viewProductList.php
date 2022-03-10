<?php
//  ==============   for Product Filtering  ===================
$productSearch = null ;
 if (isset($_POST['category_search'])) {
     $productSearch = $_POST['category_search'];
     if ($productSearch == "All Category") {
        $productQuery = "SELECT * FROM `products` ";
     } else {
         // search in all table columns
        $productQuery = "SELECT * FROM `products`  WHERE `pro_category` = '$productSearch' ";
     }
 } else {
        $productQuery = "SELECT * FROM `products` ";
  }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>home</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                
       

                    <!-- ================= View Products List start ========== -->

<div class="w-100 px-1" id="viewProductsList" style="display: block;">
    <form action="viewProductList.php" class="my-1 w-50 d-flex" method="post">
        <span class="btn btn-info" disabled> Search : </span>
        <select class="custom-select font-weight-bold border border-info" name="category_search" required>
            <option value="<?php if (empty($productSearch)) {echo 'All Category';} else {echo $productSearch;}?>"><?php if (empty($productSearch)) {echo 'All Category';} else {echo $productSearch;}?></option>
            <option value="All Category">All Category</option>
            <option value="breakfast">Breakfast</option>
            <option value="lunch">Lunch</option>
            <option value="drinks">Drinks</option>
            <option value="dryfood">Dryfood</option>
            <option value="others">Other's</option>
        </select>
        <button class="btn btn-outline-info" type="submit" >Search</button>
    </form>



    <!-- Breakfast [Prosucts]-->
    <span id="breakfastDiv" style="display:block;" class="border border-info w-100 px-4 py-2 mr-1 my-1">
    <h2 class="row font-weight-bold mb-3 w-100 text-uppercase border border-info py-3 pl-1"><?php if (empty($productSearch)) {
            echo 'All category';} else {echo $productSearch;}?> 
    </h2>
    
    <div class="row mb-4 w-100 border border-info ">
        <table class="table">
            <thead class="bg-info">
                <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Image</th>
                <th scope="col">Price</th>
                <th scope="col">Stock</th>
                <th scope="col">Update Stock</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
<?php 


$pro_qry_Result = mysqli_query($connect, $productQuery);

while ($row3=mysqli_fetch_array($pro_qry_Result)) {
    $pid=$row3['id'];
    $pro_name=$row3['pro_name'];
    $pro_img_name=$row3['pro_img_name'];
    $pro_quantity=$row3['pro_quantity'];
    $pro_price=$row3['pro_price'];
    $pro_details=$row3['pro_details'];
    $pro_category=$row3['pro_category'];
 
    ?>
                <tr style="border-bottom: 3px solid #17a2b8;">
                    <td class="border border-info"><h5 class="text-dark"> <?php echo $pro_name ; ?> </h5></td>
                    <td class="border border-info"><img src="../assets/img/product/<?php echo $pro_img_name ; ?>.jpg" alt="image" class="mx-auto" style="height:120px;width:120px"></td>
                    <td class="border border-info"><p class="text-dark"><?php echo $pro_price ; ?> tk </p></td>
                    <td class="border border-info"><p class="text-dark">  <?php echo $pro_quantity ; ?>  </p></td>
                    <form action="controller/updateStock.php?pid=<?php echo $pid ;?>" method="post">
                    <td class="border border-info"><input id="pro_qnty" class="form-control lg-frc border border-info" type="number" required placeholder="Product Quantity" name="stock_update" min="0"></td>
                    <td class="border border-info">
                        <button type="submit" onclick="return confirm('Do You Want To Update Stock ?')" class="btn btn-outline-info w-100">Update Stock</button>
                        <a href="updateProduct.php?pid=<?php echo $pid ;?>" class="btn btn-outline-info mt-3 w-100">Edit</a>
                        <a href="controller/deleteProduct.php?pid=<?php echo $pid ;?>" onclick="return confirm('Permanent Delete,\n\nDo you Agree?')" class="btn btn-outline-info mt-3 w-100">Delete</a>
                    </td>
                    </form>
                </tr>
<?php
}
?>
            </tbody>
        </table>
    </div>
    </span>

    

</div>
<!-- =================================  View Pruucts List End ================================================== -->


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

