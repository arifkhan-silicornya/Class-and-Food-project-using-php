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

    <style>
    ::placeholder{
        color: #8a8989!important;
    }
    </style>

    <title>Exam</title>
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
                        <a class="nav-link active" id="allexam-tab" data-toggle="tab" href="#allexam" role="tab" aria-controls="allexam" aria-selected="true">All Exam </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="runningExam-tab" data-toggle="tab" href="#runningExam" role="tab" aria-controls="runningExam" aria-selected="true">Running Exam</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="allNewExam-tab" data-toggle="tab" href="#allNewExam" role="tab" aria-controls="allNewExam" aria-selected="true">Add New Exam</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="addQuestion-tab" data-toggle="tab" href="#addQuestion" role="tab" aria-controls="addQuestion" aria-selected="true">Add Question</a>
                    </li>
                </ul>
            </div><!-- header-part-end -->
            <div  class="tab-content" id="myTabContent">
                <!-- ========= All Exam =========== -->
                <div class="float-left w-100 p-1 card-body tab-pane fade show active" style="height: auto;" id="allexam" role="tabpanel" aria-labelledby="allexam-tab">
                    <table class="table table-striped table-hover">
                        <thead class="bg-success font-weight-bold">
                            <tr>
                                <td>|Course Code|</td>
                                <td>|Exam Type|</td>
                                <td>|Course title|</td>
                                <td>|Batch|</td>
                                <td>|Total Question|</td>
                                <td>|Total Marks|</td>
                                <td>|Exam Date|</td>
                                <td>|Exam time|</td>
                                <td>|Time (mins)|</td>
                                <td>|Action|</td>
                            </tr>
                        </thead>
                        <?php
                        $userid = $_SESSION['exmUserid'];
                            
                            $sql="SELECT * FROM `exam` ";
                            $result=mysqli_query($conn,$sql);

                            
                            $srNo = 00;      
                            while($row=mysqli_fetch_array($result))
                            {
                                $course_code = $row['course_code'];
                                $course_title = $row['course_title'];
                                $exmType = $row['exmType'];
                                $batch = $row['batch'];
                                $totalQuestion = $row['totalQuestion'];
                                $rightAnswerMarks = $row['rightAnswerMarks'];
                                $teacher_id = $row['teacher_id'];
                                $exmid = $row['exmid'];
                                $exmdate = $row['exmdate'];
                                $exmtime = $row['exmtime'];
                                $totaltime = $row['totaltime'];
                                $srNo = $srNo + 01;

                            if ($userid == $teacher_id ){
                            ?>
                        <tbody class="border border-bottom-0 border-success text-center">
                            <tr>    
                                <td><?php echo $course_code;?></td>
                                <td><?php echo $exmType;?></td>
                                <td><?php echo $course_title;?></td>
                                <td><?php echo $batch;?></td>
                                <td><?php echo $totalQuestion;?></td>
                                <td><?php echo $totalQuestion*$rightAnswerMarks;?></td>
                                <td><?php echo $exmdate;?></td>
                                <td><?php echo $exmtime;?></td>
                                <td><?php echo $totaltime;?></td>
                                <td>
                                    <a href="" class="btn btn-outline-danger ">Start</a>
                                    <form action="viewQuestion.php" method="post">
                                    <input type="number" name="examid" class="d-none" value="<?php echo $exmid; ?>">
                                    <button type="submit" class="btn btn-outline-danger">Questions</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                        <?php
                            }
                        }
                        ?>
                    </table>
                </div>
                <!-- ========= Running Exam =========== -->
                <div class="card-body tab-pane fade p-1" id="runningExam" role="tabpanel" aria-labelledby="runningExam-tab">
                    <table class="table table-striped ">
                        <thead class="bg-success font-weight-bold">
                            <tr>
                                <td>|Course Code|</td>
                                <td>|Exam Type|</td>
                                <td>|Course title|</td>
                                <td>|Batch|</td>
                                <td>|Total Question|</td>
                                <td>|Total Marks|</td>
                                <td>|Exam Date|</td>
                                <td>|Exam time|</td>
                                <td>|Time (mins)|</td>
                                <td>|Status|</td>
                            </tr>
                        </thead>
                        <?php
                        $userid = $_SESSION['exmUserid'];
                            
                            $sql="SELECT * FROM `exam` ";
                            $result=mysqli_query($conn,$sql);

                            
                            $srNo = 00;      
                            while($row=mysqli_fetch_array($result))
                            {
                                $course_code = $row['course_code'];
                                $course_title = $row['course_title'];
                                $exmType = $row['exmType'];
                                $batch = $row['batch'];
                                $totalQuestion = $row['totalQuestion'];
                                $rightAnswerMarks = $row['rightAnswerMarks'];
                                $teacher_id = $row['teacher_id'];
                                $exmid = $row['exmid'];
                                $exmdate = $row['exmdate'];
                                $exmtime = $row['exmtime'];
                                $totaltime = $row['totaltime'];
                                $srNo = $srNo + 01;

                            if ($userid == $teacher_id ){
                            ?>
                        <tbody class="border border-bottom-0 border-success text-center">
                            <tr>
                                <td><?php echo $course_code;?></td>
                                <td><?php echo $exmType;?></td>
                                <td><?php echo $course_title;?></td>
                                <td><?php echo $batch;?></td>
                                <td><?php echo $totalQuestion;?></td>
                                <td><?php echo $totalQuestion*$rightAnswerMarks;?></td>
                                <td><?php echo $exmdate;?></td>
                                <td><?php echo $exmtime;?></td>
                                <td><?php echo $totaltime;?></td>
                                <td><a class="btn bg-danger text-light">Running</a></td>
                            </tr>
                        </tbody>
                        <?php
                            }
                        }
                        ?>
                    </table>
                </div>
                <!-- ========= Add New Exam =========== -->
                <div class="card-body tab-pane fade p-1 " id="allNewExam" role="tabpanel" aria-labelledby="allNewExam-tab">
                    <h3 class="h3 py-5">Enter Quiz Details</h3>
                    <form class="p-4 col-12 col-md-10 mx-auto" action="php/createexam.php" method="post">
                        <div class="form-group my-1">
                            <label class="sr-only">Exam Type</label>
                            <input type="text" class="form-control" placeholder="Exam Type - Example : Midterm /Final /Class Test /Quiz /........... " required name="exmtype">
                        </div>
                        <div class="form-group my-1">
                            <label class="sr-only">Course Code</label>
                            <input type="text" class="form-control" placeholder="Course Code - Example : CSE-420 " required name="courseCode">
                        </div>
                        <div class="form-group my-1">
                            <label class="sr-only">Course Title</label>
                            <input type="text" class="form-control" placeholder="Course Title - Example : Computer Fundamental " required name="courseTitle">
                        </div>
                        <div class="form-group my-1">
                            <label class="sr-only">Batch </label>
                            <input type="text" class="form-control" placeholder="Batch - Example : 42(A) " required name="batch">
                        </div>
                        <div class="form-group my-1">
                            <label class="sr-only">Total Number of Question</label>
                            <input type="text" class="form-control" placeholder="Total Number of Question ( Example : 20 )" required name="totalQuestion">
                        </div>
                        <div class="form-group my-1">
                            <label class="sr-only">Marks of each right Question</label>
                            <input type="text" class="form-control" placeholder="Marks of each Right Question ( Example : 1 )" required name="rightQuestion">
                        </div>
                        <div class="form-group my-1">
                            <label class="sr-only">Marks of each Wrong Question</label>
                            <input type="text" class="form-control" placeholder="Marks of each Wrong Question ( Example : 1 )" required name="wrongQuestion">
                        </div>
                        <div class="form-group my-1">
                            <label class="sr-only">Semester-Year</label>
                            <input type="text" class="form-control" placeholder="Semester-Year ( Example : Summer - 2020 )" required name="semesterYear">
                        </div>
                        <div class="form-group my-1 d-flex">
                            <label class="float-left font-weight-bold w-25 text-left">Exam Date <span class="mx-5">:</span></label>
                            <input type="date" class="form-control" placeholder="Exam date " required name="examDate">
                        </div>
                        <div class="form-group my-1 d-flex">
                            <label class="float-left font-weight-bold w-25 text-left">Exam Time <span class="mx-5">:</span></label>
                            <input type="time" class="form-control" placeholder="Exam Time" required name="exmTime">
                        </div>
                        <div class="form-group my-1">
                            <label class="sr-only">Total Time</label>
                            <input type="number" class="form-control" placeholder="Total Exam Time(min) ( Example : 30 )" required name="totalTime">
                        </div>
                        <div class="form-group my-1 float-left">
                            <label for="markeachQuestion" class="sr-only">Comment</label>
                            <textarea cols="145" rows="6" name="description" class="text-left" placeholder="Write Describtion Here......"></textarea>
                        </div><br/>
                        <div class=" clearfix"></div>
                        <div class="form-group my-1 float-left ">
                            <button type="submit" class="btn btn-outline-dark" onclick="return confirm('Are you sure?\n\n')">Save</button>
                            <button type="button" class="btn btn-danger text-light ml-1" onclick="inputFieldRefresh()" >Reset</button>
                        </div>
                    </form>
                </div>
                <!-- ========= Add New Question =========== -->
                <div class="card-body tab-pane fade p-1 " id="addQuestion" role="tabpanel" aria-labelledby="addQuestion-tab">
                    <table class="table">
                        <h4 class="h4 text-left bg-danger p-2 text-capitalize text-white">Semester : Summer-2020</h2>
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th scope="col">Sr. No.</th>
                                <th scope="col">Course Code</th>
                                <th scope="col">Exam Type</th>
                                <th scope="col">Batch</th>
                                <th scope="col">Total Question</th>
                                <th scope="col">Exam Date</th>
                                <th scope="col">Exam Time</th>
                                <th scope="col">Total Time</th>
                                <th scope="col">Create Questions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php           
                            $userid = $_SESSION['exmUserid'];
                            
                            $sql="SELECT * FROM `exam` ";
                            $result=mysqli_query($conn,$sql);

                            
                            $srNo = 00;      
                            while($row=mysqli_fetch_array($result))
                            {
                                $course_code = $row['course_code'];
                                $exmType = $row['exmType'];
                                $batch = $row['batch'];
                                $totalQuestion = $row['totalQuestion'];
                                $teacher_id = $row['teacher_id'];
                                $exmid = $row['exmid'];
                                $exmdate = $row['exmdate'];
                                $exmtime = $row['exmtime'];
                                $totaltime = $row['totaltime'];
                                $srNo = $srNo + 01;

                            if ($userid == $teacher_id ){
                            ?>
                            <tr>
                                <th scope="row"><?php if ($srNo <=9) {echo '0';} echo $srNo;  ?></th>
                                <td><?php echo $course_code;?></td>
                                <td><?php echo $exmType;?></td>
                                <td><?php echo $batch;?></td>
                                <td><?php echo $totalQuestion;?></td>
                                <td><?php echo $exmdate;?></td>
                                <td><?php echo $exmtime;?></td>
                                <td><?php echo $totaltime;?></td>
                                <td><a class="btn btn-outline-dark" href="question.php?exmid=<?php echo $exmid; ?>&totalques=<?php echo $totalQuestion; ?>">Create Question</a></td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
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

</script>
  </body>
</html>