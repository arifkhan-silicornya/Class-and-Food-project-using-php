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

    
         


<div class="mx-5 w-75" id="moneyRecharge" style="display: block;">
    

    <h3 class="my-3 text-center text-info font-weight-bold">Recharge Amount To User Account</h3>
    <form method="post" action="transaction/rechargeUser.php" class="w-75 mx-auto border border-info p-3">
    <div class="form-group border border-info" >
        <input class="form-control lg-frc" type="text" placeholder="User Name" name="user_name" required value="<?php echo $username ;?>" readonly onclick="alert('User Name\n\nNot Editable ');">
    </div>
    <div class="form-group border border-info">
        <input class="form-control lg-frc" type="text" placeholder="User Type" name="userType" required value="<?php echo $user_role ;?>" readonly onclick="alert(' User Type\n\nNot Editable ');">
    </div> 
    <div class="form-group border border-info" id="department_Show" style="display:block;">
        <input class="form-control lg-frc" type="text" placeholder="Department" name="department" value="<?php echo $department; ?>" readonly onclick="alert(' Department\n\nNot Editable ');">
    </div>
    <div class="form-group border border-info" id="batch_Show" style="display:block;">
        <input class="form-control lg-frc" type="number" placeholder="Batch No." name="batch" min="0" value="<?php echo $batch ; ?>" readonly onclick="alert(' Batch\n\nNot Editable ');">
    </div>
    <div class="form-group border border-info">
        <input class="form-control lg-frc" type="number" placeholder="ID" name="User_id" min="0" required value="<?php echo $studentid;?>" readonly onclick="alert(' User ID\n\nNot Editable ');">
    </div>
    
    <div class="form-group  border border-info">
        <input class="form-control lg-frc" type="number" placeholder="Amount" name="rechrg_Amount" required>
    </div>
    <div class="form-group  border border-info">
        <input class="form-control lg-frc" type="password" placeholder="Pin Number" name="pinNumber" min="0" required>
    </div>
    <div class="form-group">
        <button class="btn btn-outline-info w-100" type="submit"><strong>Recharge</strong></button>
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

