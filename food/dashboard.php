<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>home</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css?h=1f8afc18ec3ce05d9a2e38380bd93365">

    <style>
        .bg-color{
            background: radial-gradient(circle,#0075b9 0,#002c5d 100%);
            /* background-color: rgba(0,0,0,.2); */
        }
        .user-profile-image{
            height: 100px;
            width: 100px;   
        }
        .responsive-screen{
            width: 350px;
            height: auto;
        }
        .popUpConfirmDiv{
            width : 100%;
            height : 85%;
            position:fixed;
            top:15%;
            left:0%;
            display:none;

            
        }
        @media (max-width: 767.98px) {
            .responsive-screen{
                width : 100%;
            } 

        }
    </style>
</head>

<body >
<!-- ......................header file included..................... -->
<?php include 'header.php';?>
<div class="text-warning text-center font-weight-bold container bg-dark" style="margin-top:-47px;">
    <?php 
        if (isset($_REQUEST['YouHadAOrder'])) {
            echo 'Please, Confirmed That Your Previous Order Delivered. <br>' ;  
            echo 'Otherwise, You Will Disable To Next Order. <br>' ;  
        }
    ?>
</div>

<?php
if (isset($_SESSION["doCancel"])) {
    if ($_SESSION["doCancel"] == 1) {
        echo "
        <script>
        setInterval(function() {
           document.getElementById('doCancel').style.display = 'inline-block';
        }, 0);    
        setInterval(function() {
            document.getElementById('doCancel').style.display = 'none';
            location.reload(true);
        }, 1000*10);    
        </script>
        ";
        $_SESSION["doCancel"] == 0;
        unset($_SESSION["doCancel"]);
    }
}
if (isset($_REQUEST['orderConfirmed'])) {
    echo "<script>alert('You Confirmed Your Order!')</script>";
}
if (isset($_REQUEST['enteredWrongCode'])) {
    echo "<script>alert('You entered Wrong Code!')</script>";
}

$id=$_SESSION['userid'];

$orderView = "SELECT * FROM `orders` WHERE `customer_id` ='$id' " ;
$run_orderView  = mysqli_query($connect,$orderView);

if (isset($_REQUEST['processingOrders'])) {
    $orderStatusView = "SELECT * FROM `orders` WHERE `customer_id` ='$id' AND `status` = 'processing' " ;
}
else if (isset($_REQUEST['deliveredOrders'])) {
    $orderStatusView = "SELECT * FROM `orders` WHERE `customer_id` ='$id' AND `status` = 'confirmed' " ;
}
else if (isset($_REQUEST['cancelOrders'])) {
    $orderStatusView = "SELECT * FROM `orders` WHERE `customer_id` ='$id' AND `status` = 'cancel' " ;
}
else {
    $orderStatusView = "SELECT * FROM `orders` WHERE `customer_id` ='$id' ";
}
$run_orderstates  = mysqli_query($connect,$orderStatusView);

$rcrgView = "SELECT * FROM `recharge_users` WHERE `user_id` ='$id' " ;
$run_rcrgView  = mysqli_query($connect,$rcrgView);


$sql="SELECT * FROM users WHERE studentid='$id'";
$Result=mysqli_query($connect,$sql);
while($row=mysqli_fetch_array($Result))
    { 
    $uname=$row['username'];
    $studentid=$row['studentid'];
    $email=$row['email'];
    $address=$row['address'];
    $contact=$row['contact'];
    $department=$row['department'];
    $user_role=$row['user_role'];
    $batch=$row['batch'];
    $gender=$row['gender'];
    $profile_picture=$row['profile_picture'];

    }
?>


<div class="container-fluid d-md-flex d-block">
    <!-- ..............left side Start.............. -->
        <aside class="responsive-screen py-5 px-3 my-3 mr-2 border border-primary float-left clearfix d-block" >
            <div class=" user-profile-image mx-auto">
                <img class="rounded-circle border border-rounded " src="assets/img/profilePicture/<?php echo  $profile_picture ?>.jpg" alt="user-profile" style="height: 100px;width:100px;">
            </div>
            <div class="text-center font-weight-bold"> <?php echo  $uname ?> </div><br><br>

            <div><button onclick="profile();" class="w-100 border btn border-primary d-block px-4 mx-2 my-1">Profile </button>  </div>
            <div><button onclick="profilePicture();" class=" w-100 btn border border-primary d-block px-4 mx-2 my-1">Profile Picture Change </button>  </div>
            <div><button onclick="transaction_cus_his();" class=" w-100 border btn border-primary d-block px-4 mx-2 my-1">Transaction History </button>  </div>
            <div><button onclick="cus_order_details()" class=" w-100 border btn border-primary d-block px-4 mx-2 my-1">Order </button>  </div>
            <div><button onclick="changePassword()" class=" w-100 btn border border-primary d-block px-4 mx-2 my-1">Password </button>  </div>

        </aside>
<!-- ..............left side end.............. -->
<div class="clearfix"></div>

    <!-- =============================== Right Update Start ===================================== -->
<div class="py-5 pl-3 border border-primary my-3 mx-auto w-100 d-flex " style="height: auto;">
                
                
            <!-- .....................profile picture changes Start.............. -->

    <div class="custom-file border border-info mb-5 mx-3 " id="profile-picture" style="display: none;">
        <label class="font-weight-bold pl-3">Change Your Profile Picture :</label>
        <form action="php/profilePictureChange.php" method="post" enctype="multipart/form-data" class="border border-info pl-2 pb-2">
            <input type="file" class="form-control" name="avatar_file" required>
            <button type="submit" name="picture_file" onclick="return confirm('Are You sure ?')" class="btn btn-outline-info mt-2 mx-3">Save Changed</button>
        </form>
    </div>

    <!-- =================================  user Picture update End ================================================== -->

    <!-- =================================  user profile update start ================================================== -->
<div class="w-75 pl-5 " id="user-profile-change" style="display: none;">
    <form action="php/allprofile.php" method="post">

    <div class="form-group ">
        <label for="exampleInputName">Name </label>
        <input type="text" class="form-control" id="exampleInputName" placeholder="Enter Name" value="<?php echo $uname?>" name="username">
    </div>
    
    <div class="form-group ">
    <label for="exampleInputId">Student Id </label>
    <input type="text" class="form-control" id="exampleInputId" placeholder="Enter Student Id" min="1" value="<?php echo $studentid?>" readonly>
    </div>

    <div class="form-group ">
        <label for="exampleInputDept">Department </label>
        <input type="text" class="form-control" id="exampleInputDept" placeholder="Enter Your Department" value="<?php echo $department?>" name="department">
    </div>

    <div class="form-group ">
        <label for="exampleInputBatch">Batch </label>
        <input type="text" class="form-control" id="exampleInputBatch" placeholder="Enter Batch" value="<?php echo $batch?>" name="batch">
    </div>

    <div class="form-group ">
        <label for="showGender">Gender :</label>
        <input type="text" class="form-control" id="showGender" placeholder="Gender" readonly value="<?php echo $gender?>" >
    </div>
    

    <div class="form-group">
        <label for="exampleInputDesignation">Designation</label>
        <input type="text" class="form-control" id="exampleInputDesignation" placeholder="Student,Teachers or Staffs " value="<?php echo $user_role?>" name="designation">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?php echo $email?>" name="email">
    </div>

    <div class="form-group">
        <label for="contactno">Contact Number</label>
        <input type="text" class="form-control" id="contactno" placeholder="Mobile Number" name="Phn_num" min="10" max="11" required value="<?php echo $contact?>">
    </div>

    <div class="form-group">
        <label for="deliveryAdd">Delivery Address</label>
        <input type="text" class="form-control" id="deliveryAdd" placeholder="Delivery Address" name="deliveryAdd" value="<?php echo $address?>">
    </div>
    <button type="submit" class="w-100 btn btn-outline-primary mt-5">Save Changed</button>
    </form>
</div>


<!-- =================================  user profile update End ================================================== -->




    <!-- ================================= Change Password Start ======================================== -->
<div class="mx-5 w-50" id="changePassword" style="display: none;">
<form action="php/changePassword.php" method="POST">

    <div class="form-group">
        <label for="exampleInputEmail1">Old Password</label>
        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Old Password" required name="oldPass">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">New Password</label>
        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="New Password" required name="newPass">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Confirm New Password</label>
        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Condirm New Password" required name="newPass2">
    </div>
    <button type="submit" class="w-50 btn btn-outline-primary mt-5">Save Changed</button>
</form>
</div>

<!-- ================================= Change Password End ======================================== -->


        <!-- ================================= Order History Start =============================-->

<div class="mx-5 w-100 " id="order_details_cus" style="display: block;">
<nav class="navbar navbar-expand-lg navbar-info bg-light w-100">
    <li class="navbar-brand nav-item ">
        <a class="nav-link btn btn-outline-info font-weight-bold " href="dashboard.php">ALL <span class="sr-only">(current)</span></a>
    </li>
  <button class="navbar-toggler btn btn-outline-info float-right border" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <!-- <span class="navbar-toggler-icon"></span> -->
    <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
    <!-- <i class="fa fa-camera-retro fa-2x"></i> -->
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link btn btn-outline-info px-3 font-weight-bold" href="dashboard.php?processingOrders">PROCESSING</a>
      </li>
      <li class="nav-item">
        <a class="nav-link btn btn-outline-info px-3 font-weight-bold" href="dashboard.php?deliveredOrders">DELIVERED</a>
      </li>
      <li class="nav-item">
        <a class="nav-link btn btn-outline-info px-3 font-weight-bold" href="dashboard.php?cancelOrders">CANCEL</a>
      </li>
    </ul>
  </div>
</nav>
<div class="d-flex flex-column-reverse mt-2">
<?php 
    if ($run_orderstates  == true) {
        while ($viewOrder = mysqli_fetch_array($run_orderstates)) {
            $order_id = $viewOrder['order_id'];
            $total = $viewOrder['total'];
            $order_time = $viewOrder['order_time']; 
            $status = $viewOrder['status']; 
            $payment_type = $viewOrder['payment_type']; 
        ?>
        <?php if ($status == "processing") {?>
            <div class="mb-1 text-right">
                <button onclick="popUpConfirmDiv();" class="btn btn-outline-dark">Do Confirm</button>
                <a href="php/order/orderCancel.php?order_id=<?php echo $order_id ;?>&payment_type=<?php echo $payment_type ;?>" onclick="return confirm('Are You sure ?\n\nDo You Want To Cancel Your Order')" class="btn btn-outline-danger " id="doCancel" style="display:none!important;">Do Cancel</a>
            </div>
        <?php }?>        
        <div class="bg-light border border-info p-2 font-weight-bold mb-1 w-100"> 
            <div class="clearfix">
                <span class="float-left">Date : <?php echo $order_time; ;?></span>  
                <span class="float-right">Amount : 
                    <span class="font-weight-normal"> <?php echo $total ;?> </span>
                </span>
            </div>
            <div class="text-danger d-flex justify-content-between">
                <span class="font-weight-normal">Order for Invoice :#<?php echo $order_id ;?></span> 
                <span class="font-weight-bold border border-info bg-white text-danger px-3 py-1 text-capitalize"><?php echo $status ;?></span> 
            </div>
        </div>
    <?php
        }
    }
?>
</div>
</div>
        <!-- ============================= Order History End ========================================-->

<!-- Transaction History start-->
<div class="mx-3 w-100 " id="transaction_cus_history" style="display: none;">
    <h4 class="h4 d-block bg-light py-2">Transaction History</h4>
    <div class="d-md-flex d-block w-100">
        <div class="bg-light border border-info p-2 font-weight-bold mb-1 w-100">
            <h5 class="h5 d-block bg-light py-2 text-center">Order History</h5>
            <div class="d-flex flex-column-reverse">
                <?php 
                if ($run_orderView  == true) {
                    while ($viewOrder = mysqli_fetch_array($run_orderView)) {
                        $order_id = $viewOrder['order_id'];
                        $total = $viewOrder['total'];
                        $order_time = $viewOrder['order_time'];
                ?>
                <div class="bg-light border border-info p-2 font-weight-bold mb-1 w-100 "> 
                    <div class="clearfix">
                        <span class="float-left">Date : <?php echo $order_time; ;?></span>  
                        <span class="float-right">Amount : 
                            <span class="font-weight-normal"> <?php echo $total ;?> </span>
                        </span>
                    </div>
                    <div class="text-danger">Order for Invoice :
                        <span class="font-weight-normal">#<?php echo $order_id ;?></span> 
                    </div>
                </div>
                <?php
                }
                }
                ?>
            </div>
        </div>
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

    <!-- Transaction History end-->

    </div>

    
</div>
<!-- ......................footer file included..................... -->
<?php include 'footer.php';?>

<?php 
 $code = rand(1000,10000);
 ?>
<!-- ================ Confirm Model ============ -->
<div class="popUpConfirmDiv border border-info bg-light m-auto p-4" id="popUpConfirmDiv" style="display:none;">
    <h3 class="text-danger text-center my-2">Note : If you have received the product,then confirm it.</h3>
    <h4 class="text-danger text-center my-2">Code :<?php echo $code;?></h4>
    <form action="php/order/confirmorder.php?code=<?php echo $code;?>&order_id=<?php echo $order_id ;?>" class="w-100" method="post">
        <div class="form-group d-flex mx-auto responsive-screen w-75 mt-5">
            <input class="form-control border border-info " type="number" required placeholder="Enter Code" name="codenumber">
            <button onclick="checkCode();" type="submit" class="btn btn-outline-dark">Submit</button>
            <button onclick="popUpConfirmDiv();" type="button" class="btn btn-outline-danger">Cancel</button>
        </div>
    </form>
    
</div>







<script>

    function popUpConfirmDiv() {
        var xx = document.getElementById("popUpConfirmDiv");
    if (xx.style.display == "none") {
        xx.style.display = "block";
    } else {
        xx.style.display = "none";
    }

    }
    var w = document.getElementById("profile-picture");
    var x = document.getElementById("user-profile-change");
    var y = document.getElementById("changePassword");
    var z = document.getElementById("order_details_cus");
    var v = document.getElementById("transaction_cus_history");
 
    function profilePicture() {
        w.style.display = "block";
        x.style.display = "none";
        y.style.display = "none";
        z.style.display = "none";
        v.style.display = "none";
    }
    function profile() { 
        w.style.display = "none";
        x.style.display = "block";
        y.style.display = "none";
        z.style.display = "none";
        v.style.display = "none";
    }
    function changePassword() {
        w.style.display = "none";
        x.style.display = "none";
        y.style.display = "block";
        z.style.display = "none";
        v.style.display = "none";
    }
    function cus_order_details() {
        w.style.display = "none";
        x.style.display = "none";
        y.style.display = "none";
        z.style.display = "block";
        v.style.display = "none";
        
    }
    function transaction_cus_his() {
        w.style.display = "none";
        x.style.display = "none";
        y.style.display = "none";
        z.style.display = "none";
        v.style.display = "block";
        
    }
</script>



    <!-- End: Bootstrap Cards v2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.min.js?h=43583f9c06d57d8535a11a9e2f5a6a7c"></script>
</body>

</html>