<?php
session_start();
require_once("../php/conect_database.php");


if(isset($_SESSION['managerId']))
{
	header("location:dashboard.php");
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>login</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../assets/css/styles.min.css">
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
                width: 80%!important;
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

<body class="bg-color-index">
    <div class="container" >
        
        <header class="dh-header-non-rectangular mx-auto ">
            <div class="header__bg mt-0 pt-3">
                <span class="w-100 d-block text-danger mt-5 bg-color-index" style="position:relative;font-size:5vw; z-index : 100000!important;">Manager Panel</span>
            </div>
        </header>

        <!-- Start: Login-Form-blue-Gradient -->
        <section>
            <div class="lgp-hd mx-auto">
                <h2 style="filter: brightness(200%) ;font-size:5vw;" class="text-light mx-auto bg-color-index"><strong>Food Block</strong></h2>
                <h5 style="font-size:2vw;" class="mx-auto text-white">A easy way to get your Food</h5>
            </div>
            <div class="container login-cont">
                <div class="row">
                    <div class="mx-auto login-col w-75"><i class="icon ion-lock-combination"></i>
                        <form class="login-form" method="post" action="controller/adminlogin.php"> 
                            <div class="form-group"><input class="form-control" type="text" required placeholder="Enter User ID" name="userID"></div>
                            <div class="form-group"><input class="form-control" type="password" required placeholder="Enter Password" name="password"></div>
                            <div class="form-group">
                                <button class="btn btn-outline-light w-100" type="submit"><strong>LOGIN</strong></button>
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