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
        @media screen and (min-width: 991px) {
            .login-col{
                width: 80%;
            }
        }
        @media screen and (max-width: 991px) {
            .login-cont {
                padding: 7px;
            }
            .login-col{
                width: 100%;
            }
        }
        @media screen and (max-width: 575.98px) {
            .login-col{
                padding : 0!important;
            }
        }
    </style>
</head>

<body >
  <div class="container mt-1">
    <!-- Start: Login-Form-blue-Gradient -->
    <section class="">
        <div class="mt-3 d-inline-block mx-auto w-100 text-center">
            <h2 style="font-size: 4vw;" class="my-auto mx-auto h2"><strong>Food Block</strong></h2>
            <h5 style="font-size: 1.5vw;" class="mx-auto h5"><strong>A easy way to get your Food</strong></h5>
        </div>
        <div class="container ">
            <div class="row">
                <div class="mx-auto col-md-6 col-12">
                    <form class="mt-3 " method="post" action="php/insert.php"> 
                        <div class="form-group"><input class="form-control " type="text" required placeholder="Enter Full Name" name="username"></div>
                        <div class="form-group"><input class="form-control " type="text" required placeholder="Eenter Your ID" name="studentID"></div> 
                        <div class="form-group">
                            <select class="custom-select form-control lg-frc" name="gender" required>
                                <option value="">Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="custom-select form-control lg-frc" name="userType" onchange="showDepartmentCreateAcc();" id="userType" required> 
                                <option value="">User Type</option>
                                <option value="student">Student</option>
                                <option value="teacher">Teacher</option>
                                <option value="stuff">Stuff</option>
                                <option value="others">Other's</option>
                            </select>
                        </div>
                        <div class="form-group border border-info" id="department_Show" style="display:none;">
                            <select class="custom-select form-control lg-frc" name="department" >
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
                        <div class="form-group border border-info" id="batch_Show" style="display:none;">
                            <input class="form-control lg-frc" type="number" placeholder="Batch No." name="batch" min="0" value="">
                        </div>


                        <div class="form-group"><input class="form-control lg-frc" type="number" required placeholder="Contact Number" name="phn_num" ></div> 

                        <div class="form-group"><input class="form-control lg-frc" type="password" required placeholder="Enter Password" name="password"></div>
                        <div class="form-group"><input class="form-control lg-frc" type="password" required placeholder="Re-type Password" name="password2"></div>
                        
                        <div class="form-group">
                            <button class="btn btn-outline-dark w-100" type="submit"><strong>SIGNUP</strong></button>
                        </div>
                        <div class="d-block mx-auto text-center">
                            <span class="text-dark text-center">
                                Back to <a href="index.php" class="text-dark text-center" ><strong>Login</strong> Page</a>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
        <!-- End: Login-Form-blue-Gradient -->
    </div>


<script>

function showDepartmentCreateAcc(){
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
</body>

</html>