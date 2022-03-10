<?php
session_start();
require_once("../php/conect_database.php");

if(!isset($_SESSION['adminId']))
{
	header("location:index.php");
}
else {
$id=$_SESSION['adminId'];
$sql="SELECT * FROM `admin` WHERE `username`='$id'";
$Result=mysqli_query($connect,$sql);

while($row=mysqli_fetch_array($Result))
    { 
    $uname=$row['username'];
    }
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
    <header class="header-part mt-0 d-flex mb-3">
        <div class="d-flex justify-content-between container d-flex">    
            <span class="text-light align-items-center d-flex font-weight-bold">
                <a href="index.php" class="text-light"> Food block </a>    
            </span>
            <span class="d-flex text-light align-items-center font-weight-bold" onclick="showSmallPanel();" > <?php echo $uname?></span>
        </div>
    </header>

                <!-- ========= small panel ====== -->
    <div id="smallPanel" class="p-1 small-panel text-light font-weight-bold" style="display:none;">
        <a href="dashboard.php" class="d-block border border-bottom border-light pl-2 text-light">Dashboard</a>
        <a href="controller/logout.php" class="d-block border border-bottom border-light pl-2 text-light">Logout</a>
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