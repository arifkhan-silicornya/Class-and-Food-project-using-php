<?php
//  ==============   for Product Filtering  ===================
$productSearch = null ;
 if (isset($_POST['category_search'])) {
     $productSearch = $_POST['category_search'];
     if ($productSearch == "All") {
        $productQuery = "SELECT * FROM `orders` ";
     } else {
         // search in all table columns
        $productQuery = "SELECT * FROM `orders`  WHERE `status` = '$productSearch' ";
     }
 } else {
        $productQuery = "SELECT * FROM `orders` ";
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
        @media screen and (max-width: 768px) {
            aside{
                width : 100%!important;
            }
        }
        

    </style>
</head>

<body >
<!-- ......................header file included..................... -->
<?php include 'header.php';?>
<?php


$id=$_SESSION['managerId'];
$sql="SELECT * FROM `manager` WHERE `manager_id`='$id'";
$Result=mysqli_query($connect, $sql);

while ($row=mysqli_fetch_array($Result)) {
    $uname=$row['Manager_name'];
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

    
         

<!-- ============================= View Order List Start ========================================-->
<div class="w-100" id="viewOrder" style="display: block;">
    <form action="viewOrder.php" class="my-1 w-50 d-flex" method="post">
        <span class="btn btn-info" disabled> Search : </span>
        <select class="custom-select font-weight-bold border border-info" name="category_search" required>
            <option value="<?php if (empty($productSearch)) {echo 'All Category';} else {echo $productSearch;}?>"><?php if (empty($productSearch)) {echo 'Search By Status';} else {echo $productSearch;}?></option>
            <option value="All">All</option>
            <option value="processing">Processing</option>
            <option value="confirmed">Delivered</option>
            <option value="cancel">Cancel</option>
        </select>
        <button class="btn btn-outline-info" type="submit" >Search</button>
    </form>
    <h3 class="my-3 text-center text-info font-weight-bold">View Order List</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Sr. no.</th>
                <th scope="col">Order ID</th>
                <th scope="col">Customer ID</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Customer Type</th>
                <th scope="col">Delivery Address</th>
                <th scope="col">Payment Type</th>
                <th scope="col">Total</th>
                <th scope="col">Status</th>
                <th scope="col">Order Time</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $srNo = 0;

                $Result2=mysqli_query($connect, $productQuery);

                while ($row=mysqli_fetch_array($Result2)) {
                    $order_id=$row['order_id'];
                    $customer_id=$row['customer_id'];
                    $customer_name=$row['customer_name'];
                    $usertype=$row['usertype'];
                    $address=$row['address'];
                    $payment_type=$row['payment_type'];
                    $total=$row['total'];
                    $status=$row['status'];
                    $order_time=$row['order_time']; 
                    
                    $srNo++;
             ?>
            <tr>
                <td scope="col"><?php echo $srNo; ?></td>
                <td scope="col"><?php echo $order_id; ?></td>
                <td scope="col"><?php echo $customer_id; ?></td>
                <td scope="col"><?php echo $customer_name; ?></td>
                <td scope="col"><?php echo $usertype; ?></td>
                <td scope="col"><?php echo $address; ?></td>
                <td scope="col"><?php echo $payment_type; ?></td>
                <td scope="col"><?php echo $total; ?></td>
                <td scope="col"><?php echo $status; ?></td>
                <td scope="col"><?php echo $order_time; ?></td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>
<!-- ============================= View Order List End ========================================-->


                 

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

