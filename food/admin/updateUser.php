<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>User Update</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/styles.min.css?h=1f8afc18ec3ce05d9a2e38380bd93365">

    <style>

    </style>
</head>

<body >
<!-- ......................header file included..................... -->
<?php include 'header.php';?>

<?php
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $select = "SELECT * FROM `users` WHERE `id`= '$id' ";
    $Result=mysqli_query($connect,$select);
    while ($row2=mysqli_fetch_array($Result)) {
        $username=$row2['username'];
        $user_role=$row2['user_role'];
        $studentid=$row2['studentid'];
        $department=$row2['department'];
    }    
}
else {
    header("location:dashboard.php");
}

?>





<div class="container d-block w-75" >
    <div class="row py-4 pl-3 border border-primary my-1 mx-auto w-100 d-flex " style="height: auto;">
    <h3 class="mx-auto">Reset User Password</h3>
        <form action="controller/userPassUpdate.php?id=<?php echo $id ; ?>" method="post" class="w-75 mx-auto border border-info p-3">
            <div class="text-info font-weight-bold ">Name :<span> <?php echo $username ; ?></span> </div>
            <div class="text-info font-weight-bold ">User Type :<span> <?php echo $user_role ; ?></span> </div>
            <div class="text-info font-weight-bold ">Department :<span> <?php echo $department ; ?></span> </div>
            <div class="text-info font-weight-bold ">ID :<span> <?php echo $studentid ; ?></span> </div>
            <div class="form-group mt-3">
                <label for="">New Password </label>
                <input class="form-control lg-frc border border-info" type="password" required placeholder="New User Password" name="password">
            </div>
            <div class="form-group">
            <label for="">Confirm New Password </label>
                <input class="form-control lg-frc border border-info" type="password" required placeholder="Re-type Password" name="password2">
            </div>
            <button type="submit" name="newPassUser" onclick="return confirm('Are You sure ?')" class="w-50 btn btn-outline-info mt-5">Set New Password</button>
        
        </form>
                

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

