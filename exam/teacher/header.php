<?php
require_once("../php/connection.php");
session_start();
$userid = $_SESSION['exmUserid'];

if(empty($_SESSION['exmUserid']))
{
    header("location:../index.php");
}

$sql="SELECT * FROM `user` WHERE `versityid` = '$userid'";
$result=mysqli_query($conn,$sql);
    
while($row=mysqli_fetch_array($result))
{
    $teacherName = $row['name'];
}
    
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link  rel="stylesheet" href="../css/bootstrap.min.css"/>
    <link  rel="stylesheet" href="../css/style.css"/>

    <title>Header</title>
  </head>
  <body class="bg-light">
    <!-- Start Nav Part -->
    <section class="bg-light sticky-top">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" >Logo</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="result.php">Result-Publish</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="routine.php">Routine</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="courseReg.php">Registration</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="runningCourse.php">Running Course</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="exam.php">Exam</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="newcourse.php">Add New Course</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item active d-flex">
                            <a class="d-flex text-light font-weight-bold m-2 btn" href="../../index.php">
                                <img src="../../image/home.png" alt="" class="img-fluid" style="height: 30px; width:30px;"> 
                            </a>
                            <a class="nav-link my-auto" ><?php echo $teacherName; ?></a>
                            <a class="nav-link my-auto btn btn-outline-danger" href="../php/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </section>
    <!-- End nv part -->
  <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script src="../js/bootstrap.min.js"  type="text/javascript"></script>
    <script src="../js/custom.js"  type="text/javascript"></script>

</script>
  </body>
</html>