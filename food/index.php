<?php
session_start();
require_once("php/conect_database.php");


if(isset($_SESSION['userid']))
{
	header("location:home.php");
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
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <style>
        .bg-color-index{
            background: radial-gradient(circle,#0a3769 0,#000000 100%)!important;
        width : 100%!important;
        }
        .login-col{z-index:10000!important;}
        @media screen and (max-width: 991px) {
            .dh-header-non-rectangular{
                width: 100%!important;
                margin-left: 0!important;
                margin-right: 0!important;
            }
            .header__bg{
                width: 100%!important;
                margin-left: 0!important;
                margin-right: 0!important;
            }
            .lgp-hd{
                margin-top:-160px!important;
            }
            .login-cont{
                padding: 6px 7px 7px;
                width: 100%;
                margin-left:0!important;
                margin-right:0!important;
            }
            .login-col{
                width: 100%!important;
            }
        }
        @media screen and (max-width: 768px) {
            .login-col{
                width: 100%!important;
            }
        }
        @media screen and (max-width: 575.98px) {
            .login-col{
                padding : 0!important;
            }
        }
    </style>
</head>

<body class="">
    <div class="container pt-3" >
        
        <!-- Start: Login-Form-blue-Gradient -->
        <section>
            <div class=" text-center d-flex justify-content-center  ">
                <h2 style="font-size:5vw;" ><strong>Food </strong></h2>
                <span ><img src="assets/img/icon/cart.png" alt="icon" class="img-fluid rounded mt-4" style="height:30px;width:60px;"></span>
                <h2 style="font-size:5vw;" ><strong>Block</strong></h2>
            </div>
            <div class="text-center">            
                <h5 style="font-size:1vw;" >A easy way to get your Food</h5>
            </div>
            <div class="container ">
                <div class="row">
                    <div class="mx-auto ">
                        <form class="w-100" method="post" action="php/login.php"> 
                            <div class="form-group"><input class="form-control " type="text" required placeholder="Enter User ID" name="userID"></div>
                            <div class="form-group"><input class="form-control " type="password" required placeholder="Enter Password" name="password"></div>
                            <div class="form-group">
                                <button class="btn btn-outline-dark w-100" type="submit"><strong>LOGIN</strong></button>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-dark">Don't have any account? <a href="createnewacc.php" class="text-dark" type="submit"><strong>Create new account</strong></a></span><br>
                                <!-- <span class="text-white"> <a href="forgetpass.php" class="text-light" type="submit"><strong>Forget Password</strong></a> </span> -->
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-dark font-weight-normal">Click to go <a href="../index.php" class="text-dark" ><strong>welcome page</strong></a></span>
                                <!-- <span class="text-white"> <a href="forgetpass.php" class="text-light" type="submit"><strong>Forget Password</strong></a> </span> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- End: Login-Form-blue-Gradient -->
    </div>
    
    
    


</body>

</html>