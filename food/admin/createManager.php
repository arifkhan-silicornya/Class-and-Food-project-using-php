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
<!-- ==================================== left side end =============== -->
<div class="clearfix"></div>




<!-- ===================================== Right Side Start =========================================
     ================================================================================================
     =================================================================================================== -->

    
<div class="py-2 pl-3 border border-primary my-1 mx-auto w-100 d-flex " style="height: auto;">

    
           <!-- ==========  Money Recharge Start =================-->

<div class="mx-5 w-75" id="createManager" style="display: block;">
    
    <h3 class="my-3 text-center text-info font-weight-bold">Create Manager Account</h3>
    <form method="post" action="transaction/rechargeUser.php" class="w-75 mx-auto border border-info p-3">
    <div class="form-group border border-info" >
        <input class="form-control " type="text" placeholder="Manager Name" name="manager_name" required value="" >
    </div>
    <div class="form-group border border-info">
        <input class="form-control " type="text" placeholder="Phone" name="phone" required value="" >
    </div> 
    <div class="form-group border border-info" >
        <input class="form-control " type="number" placeholder="National ID" name="national_id" min="0" value="" >
    </div>
    <div class="form-group border border-info" >
        <input class="form-control " type="text" placeholder="Address" name="address" value="" >
    </div>
    <div class="form-group border border-info">
        <input class="form-control " type="number" placeholder="Password" name="password" min="0" required value="" >
    </div>
    <div class="form-group">
        <button class="btn btn-outline-info w-100" type="submit"><strong>Create New</strong></button>
    </div>

    </form>
</div>
<!-- ============================= Money Recharge End ========================================-->


                 

    </div>
</div>

<?php $studentid = null ;?>

<!-- ......................footer file included..................... -->
<?php include 'footer.php'; ?>


<!-- End: Bootstrap Cards v2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.min.js?h=43583f9c06d57d8535a11a9e2f5a6a7c"></script>
</body>

</html>

