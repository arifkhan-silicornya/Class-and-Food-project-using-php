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
            <!-- ============ User Picture Update Start ============ -->

<div class="custom-file w-75 border border-info mt-5" id="profile_picture" style="display: block;">
    <form action="controller/profilePictureChange.php" method="post" enctype="multipart/form-data">
        <input type="file" class="form-control" name="adminPro" required>
        <button type="submit" name="pic_file" onclick="return confirm('Are You sure ?')" class="w-50 btn btn-outline-info mt-5">Save Profile Picture</button>
    </form>
</div>
<!-- =================================  User Picture Update End ================================================== -->




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

