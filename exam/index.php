<?php
session_start();

if(!empty($_SESSION['exmUserid']))
{
    if($_SESSION['exmUsertype'] == 'student')
    {
        header("location: home.php");	
    }
    else {
        header("location:teacher/home.php");	
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>exam</title>
    <link  rel="stylesheet" href="css/bootstrap.min.css"/>
    <link  rel="stylesheet" href="css/style.css"/>
</head>
<body>

<section class="container ">
    <!-----------------------  navbar Start ----------------->
    <div class="row ">
        <nav class="navbar navbar-light d-flex justify-content-between w-100">
            <div class="d-flex justify-content-between">
                <a class="navbar-brand" href="index.php">HOME</a>
            </div>
            <div class="d-flex justify-content-between" >
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item d-flex">
                        <a class="d-flex text-light font-weight-bold m-2 btn" href="../index.php">
                            <img src="../image/home.png" alt="" class="img-fluid" style="height: 30px; width:30px;"> 
                        </a>
                        <button class="btn btn-outline-dark" onclick="loginForm();"> Login </button>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!-----------------------  navbar End ----------------->
    <div class="row bg_img ">
        <form action="php/registration.php" method="post" class="mt-5 col-md-6 col-12 px-1" >
            <div class="col mt-5 w-100 px-0 mb-1">
                <input type="text" class="form-control " placeholder="Enter Your Full Name" name="name" required>
            </div>
            <div class="col px-0 mb-1">
                <input type="text" class="form-control" placeholder="Enter Your University Id Number" name="verid" required>
            </div>
            <div class="col px-0 mb-1">
            <select class="custom-select" required name="gender">
                <option value="">Gender </option>
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select>
            </div>
            <div class="col px-0 mb-1">
            <select class="custom-select" required name="userType" onchange="showDepartmentCreateAcc();" id="userType">
                <option value="">User Type </option>
                <option value="teacher">Teacher</option>
                <option value="student">Student</option>
            </select>
            </div>
            <div class="col px-0 mb-1" id="department_Show" style="display:none;">
                <select class="custom-select"  name="department">
                    <option value="">Department</option>
                    <option value="CSE">CSE</option>
                    <option value="BPM">BPM</option>
                    <option value="BJM">BJM</option>
                    <option value="BBA">BBA</option>
                    <option value="EEE">EEE</option>
                    <option value="ENB">ENB</option>
                    <option value="ENM">ENM</option>
                    <option value="LLB">LLB</option>
                    <option value="MBA">MBA</option>
                </select>
            </div>
            <div class="col px-0 mb-1" id="batch_Show" style="display:none;">
                <input type="number" class="form-control" placeholder="Enter Your Batch" name="batch">
            </div>
            <div class="col px-0 mb-1">
                <input type="number" class="form-control" placeholder="Enter Mobile Number" required name="phone">
            </div>
            <div class="col px-0 mb-1">
                <input type="text" class="form-control" placeholder="Enter Password" required name="password">
            </div>
            <div class="col px-0 mb-1">
                <input type="text" class="form-control" placeholder="Re-enter Password" required name="confirmPass">
            </div>
            <div class="col px-0 mt-1 float-right">
                <button type="submit" class="btn btn-outline-dark float-right">Confirm Your Registration </button>
            </div>
        </form>
    </div>
</section>


<section id="loginForm" class="container bg-light col-8 col-sm-8 col-md-6 my-5 mx-auto loginForm flex-column border border-dark" style="display: none;">
    <div class="row ">
        <div class="w-100 text-dark text-center my-3 font-weight-bold" style="font-size: 3vw;">Login</div>
        <hr class="bg-dark w-100 border border-bottom border-dark">
        <form class="p-4 col-12 col-md-10 mx-auto" action="php/login.php">
            <div class="form-group">
                <label for="loginUserId" >User Id</label>
                <input type="text" class="form-control" id="loginUserId" placeholder="Enter Your Id Number" required name="userId">
            </div>
            <div class="col px-0">
                <label for="" >User Type</label>
                <select class="custom-select" required name="userType" onchange="showDepartmentCreateAcc();" id="userType">
                    <option value="">User Type </option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>
            </div>
            <div class="form-group">
                <label for="LoginUserPassword">Password</label>
                <input type="password" class="form-control" id="LoginUserPassword" placeholder="Password" required name="password">
            </div>
            <div class="form-group">
                <div class="form-check">
                <input type="checkbox" class="form-check-input" id="dropdownCheck2">
                <label class="form-check-label" for="dropdownCheck2">
                    Remember me
                </label>
                </div>
            </div>
            <span class="d-flex justify-content-between">
                <button type="submit" class="btn btn-outline-dark">Sign in</button>
                <button type="button" class="btn btn-outline-danger" onclick="loginForm();">Cancel</button>
            </span>
        </form>
    </div>
</section>




<script src="js/bootstrap.min.js"  type="text/javascript"></script>
<script src="js/custom.js"  type="text/javascript"></script>
</body>
</html>