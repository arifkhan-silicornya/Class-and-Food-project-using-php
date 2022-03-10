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

$rcrgView = "SELECT * FROM `recharge_users` " ;
$run_rcrgView  = mysqli_query($connect,$rcrgView);

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
                
         
                    <!-- ============== Transaction History start ============-->
<div class="mx-5 w-50 " id="transaction_history" style="display: block;">
<div class="border border-info">
<div class="text-info text-center ">Transaction History</div>
<div class="bg-light border border-info p-2 font-weight-bold mb-1 w-100">
            <h5 class="h5 d-block bg-light py-2 text-center">Recharge History</h5>
            <div class="d-flex flex-column-reverse">
                <?php 
                if ($run_rcrgView  == true) {
                    while ($viewRecharge = mysqli_fetch_array($run_rcrgView)) {
                        $transaction_id = $viewRecharge['id'];
                        $amount = $viewRecharge['amount'];
                        $rechrg_time = $viewRecharge['rechrg_time'];
                ?>
                <div class="bg-light border border-info p-2 font-weight-bold mb-1 w-100 "> 
                    <div class="clearfix">
                        <span class="float-left">Date : <?php echo $rechrg_time ;?></span>  
                        <span class="float-right">Amount : 
                            <span class="font-weight-normal"> <?php echo $amount ;?> </span>
                        </span>
                    </div>
                    <div class="text-danger">Recharge Transaction Number : <span class="font-weight-normal">#<?php echo $transaction_id ;?></span> </div>
                </div>
                <?php
                }
                }
                ?>
            </div>
        </div>
</div>

</div>
<!-- ================================== Transaction History End ===================================-->

             
    </div>
</div>



<!-- ......................footer file included..................... -->
<?php include 'footer.php'; ?>





<script>
    

    function showDepartment(){
        var department_Show = document.getElementById("department_Show"); 
        var batch_Show = document.getElementById("batch_Show"); 

        var userType = document.getElementById("userType").value; 
        
        if (userType == "student" ) {
            department_Show.style.display = "block";
            batch_Show.style.display = "block";
        } else {
            department_Show.style.display = "none";
            batch_Show.style.display = "none";
        }
    }
</script>


    <!-- End: Bootstrap Cards v2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.min.js?h=43583f9c06d57d8535a11a9e2f5a6a7c"></script>
</body>

</html>

