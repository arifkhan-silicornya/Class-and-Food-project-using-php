<?php
// ================= for User Filteting ==============
$valueToSearch = null ;
if (isset($_POST['valueToSearch'])) {
    $valueToSearch = $_POST['valueToSearch'];
    if ($valueToSearch == "All User") {
        $query = "SELECT * FROM `users` ";
    } else {
        // search in all table columns
        $query = "SELECT * FROM `users` WHERE `user_role` = '$valueToSearch' ";
    }
} else {
     $query = "SELECT * FROM `users` ";
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
        .bg-color{
            background: radial-gradient(circle,#0075b9 0,#002c5d 100%);
            /* background-color: rgba(0,0,0,.2); */
        }
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
                
 
                    <!-- =============== Manage Customer  Start ============= -->
    <div class="mx-2 w-100 table-responsive" id="managecustomer" style="display: block;">
    <h3 class="h3 text-info ">User List : </h3>

    <form action="manageCustomer.php" class="my-1 w-50 d-flex" method="post">
    <span class="btn btn-info" disabled> Search : </span>
    <select class="browser-default custom-select font-weight-bold" name="valueToSearch" required>
    <option ><?php if (empty($valueToSearch)) {
        echo 'All User';
    } else {
        echo $valueToSearch;
    }?> </option>
    <option value="All User">All User</option>
    <option value="student">Students</option>
    <option value="teacher">Teachers</option>
    <option value="stuff">Staffs</option>
    <option value="others">Others</option>
    </select>
    <button class="btn btn-outline-info" type="submit" >Search</button>
    </form>

    
    <table class="table table-striped table-bordered table-light table-hover" >
    <thead class="bg-info">
        <tr>
        <th scope="col">Serial</th>
        <th >Name </th>
        <th >Rank</th>
        <th >StudentId</th>
        <th >Department</th>
        <th >Batch </th>
        <th colspan="2" class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>

    <?php

    $filter_Result = mysqli_query($connect, $query);
        
    while ($row2=mysqli_fetch_array($filter_Result)) {
        $id=$row2['id'];
        $username=$row2['username'];
        $user_role=$row2['user_role'];
        $studentid=$row2['studentid'];
        $department=$row2['department'];
        $batch=$row2['batch'];
        $deleted=$row2['deleted'];

        if ($deleted == "0") {
            ?>
        <tr>
        <td>  <?php echo $id ; ?>  </td>
        <td>  <?php echo $username ; ?>  </td>
        <td>  <?php echo $user_role ; ?>  </td>
        <td>  <?php echo $studentid ; ?>  </td>
        <td>  <?php echo $department ; ?>  </td>
        <td>  <?php echo $batch ; ?>  </td>
        <td class="p-0 pt-1 text-center"><a href="updateUser.php?id=<?php echo $id ; ?>" class="btn btn-outline-info ">Edit</a></td>
        <td class="p-0 pt-1 text-center"><a href="controller/deleteuser.php?id=<?php echo $id ; ?>" class="btn btn-outline-info" onclick="return confirm('Are You Want to Delete <?php echo $username; ?> ?')">Delete</a></td>
        </tr>
    <?php
        }
    }
    $valueToSearch = null;
    ?>
    </tbody>
    </table>

    </div>
<!-- ================================== Manage Customer End ===================================-->

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

