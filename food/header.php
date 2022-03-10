<?php
session_start();
require_once("php/conect_database.php");

if(empty($_SESSION['userid']))
{
	header("location:index.php");
}
else {

$id=$_SESSION['userid'];
$sql="SELECT * FROM `user_account` WHERE `user_institute_id`='$id'";
$Result=mysqli_query($connect,$sql);

while($row=mysqli_fetch_array($Result))
    { 
    $uname=$row['user_name'];
    $current_money=$row['current_money'];
    }
}
 
if (isset($_SESSION["countproduct"])) {
    $countproduct  = $_SESSION["countproduct"];
}
else {
    $countproduct = 0;
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Getting Started</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">

    <style>
    .header-part{
        height: 60px;
        background: radial-gradient(circle,#0a3769 0,#000000 100%)!important;
        width : 100%!important;
        height:90px!important;
    }
    .small-panel{
        width: 200px;
        position:fixed;
        top: 100px;
        right:10px;
        background-color: #FA4858;
        z-index : 100000;
    }
    </style>
</head>

<body >
    <header class="bg-light mt-0 d-flex mb-5">
        <div class="d-flex justify-content-between container d-flex text-dark">
            <a href="index.php" class="text-light align-items-center d-flex font-weight-bold text-dark"> Food block</a>    
            <span class="align-items-center d-flex flex-row">
                <a class="d-flex text-light font-weight-bold my-auto ml-2 mr-4" href="addtocart.php" > 
                    <h6><i class="fa fa-shopping-cart fa-2x text-dark" aria-hidden="true"></i></h6>   <!-- <img src="assets/img/icon/icon.jpg" alt="icon"  style="height: 30px; width:36px;"> -->
                    <h6><span class="badge badge-danger text-dark"><?php echo $countproduct;?></span></h6>
                </a>
                <a class="d-flex text-light font-weight-bold m-2 btn text-dark" onclick="showSmallPanel();" > <?php echo $uname?></a>
                <a class="d-flex text-light font-weight-bold m-2 btn" href="../index.php"> <img src="../image/home.png" alt="" class="img-fluid" style="height: 30px; width:30px;"> </a>
            </span>
        </div>
    </header>


    <div id="smallPanel" class="p-1 small-panel text-light font-weight-bold" style="display:none;">
        <div class="d-block border border-bottom border-light pl-2">Balance : <?php echo $current_money?> </div>
        <a href="dashboard.php" class="d-block border border-bottom border-light pl-2 text-light">Dashboard</a>
        <a href="php/logout.php" class="d-block border border-bottom border-light pl-2 text-light">Logout</a>
    </div>


<script> 
function showSmallPanel() {
    var x = document.getElementById("smallPanel");
  if (x.style.display == "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }

}
</script>




</body>
</html>