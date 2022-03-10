<?php

require_once("../php/connection.php");

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

    <title>Course Registration</title>
  </head>
  <body class="bg-light">
    <!-- Start heading Part -->
        <?php include 'header.php';?>
    <!-- End heading part -->

    <!-- ================= content part start =========== -->
    <section class="container-fluid " >
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="allexam-tab" data-toggle="tab" href="#allexam" role="tab" aria-controls="allexam" aria-selected="true">Request Courses</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="runningExam-tab" data-toggle="tab" href="#runningExam" role="tab" aria-controls="runningExam" aria-selected="true">Approve Student Registration</a>
                    </li>
                    <li class="nav-item mx-5" role="presentation">
                        <form class="form-inline my-2 my-lg-0 p-0">
                            <input class="form-control mr-sm-2 mr-0" type="search" placeholder="Course Code" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0 ml-0" type="submit">Search</button>
                        </form>
                    </li>
                    <li class="nav-item mx-5" role="presentation">
                        <form class="form-inline my-2 my-lg-0">
                            <select class="custom-select" >
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
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </li>
                </ul>
            </div><!-- header-part-end -->
            <div  class="tab-content" id="myTabContent">
                <!-- ========= Request Course =========== -->
                <div class="float-left w-100 p-1 card-body tab-pane fade show active" style="height: auto;" id="allexam" role="tabpanel" aria-labelledby="allexam-tab">
                <table class="table table-striped ">
                        <h4 class="">Course List </h4>
                        <thead class="bg-success font-weight-bold text-center">
                            <tr>
                                <td>|S.N.|</td>
                                <td>|Course Code|</td>
                                <td>|Course title|</td>
                                <td>|Total credit|</td>
                                <td>|Action|</td>
                            </tr>
                        </thead>
                        <tbody class="border border-bottom-0 border-success text-center">
                        <?php                            
                            $sql="SELECT * FROM `course` ";
                            $result=mysqli_query($conn,$sql);
                            $srNo = 00;      
                            while($row=mysqli_fetch_array($result))
                            {
                                $course_id = $row['course_id'];
                                $course_code = $row['course_code'];
                                $course_title = $row['course_title'];
                                $credit = $row['credit'];
                                $department = $row['department'];
                                $srNo = $srNo + 01;
                            ?>
                            <tr>
                                <td><?php if ($srNo <=9) {echo '0';} echo $srNo;  ?></td>
                                <td><?php echo $course_code; ?></td>
                                <td><?php echo $course_title; ?></td>
                                <td><?php echo $credit; ?></td>
                                <td><a href="" class="btn btn-outline-danger">Request</a></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- ========= Approve Student Request =========== -->
                <div class="card-body tab-pane fade p-1" id="runningExam" role="tabpanel" aria-labelledby="runningExam-tab">
                    <table class="table table-striped ">
                        <thead class="bg-success font-weight-bold">
                            <tr>
                                <td>|Course Code|</td>
                                <td>|Course title|</td>
                                <td>|Student Name|</td>
                                <td>|Student ID|</td>
                                <td>|Batch|</td>
                                <td>|Action|</td>
                            </tr>
                        </thead>
                        <tbody class="border border-bottom-0 border-success text-center">
                            <tr>
                                <td>CSE-201</td>
                                <td>Software Quality Assurance</td>
                                <td>Aminul Islam</td>
                                <td>545</td>
                                <td>41</td>
                                <td><a class="btn bg-danger text-light">Approve</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>


<!-- =========== footer ============= -->
<?php include 'footer.php';?>
<!-- =========== footer End ============= -->


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    <script src="../js/bootstrap.min.js"  type="text/javascript"></script>
    <script src="../js/custom.js"  type="text/javascript"></script>
<!-- 
    // ==============  Teacher Home input Field Refresh ============== 
// ================== Start ==================== -->
<script>
    var j = 0;
    var count = document.getElementsByTagName("input").length;
    var x =[];
    while(j < count ){

        x[j] = document.getElementsByTagName("input")[j].placeholder;
        j++;
    }
    
function inputFieldRefresh() {

    var i = 0;

    while (i < count) {

        document.getElementsByTagName("input")[i].value = "";
        document.getElementsByTagName("input")[i].placeholder  = x[i];
        i++;
    }

}
</script>
  </body>
</html>