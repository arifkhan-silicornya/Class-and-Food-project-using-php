<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link  rel="stylesheet" href="../css/bootstrap.min.css"/>
    <link  rel="stylesheet" href="../css/style.css"/>

    <title>home</title>
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
                        <a class="nav-link active" id="allexam-tab" data-toggle="tab" href="#allexam" role="tab" aria-controls="allexam" aria-selected="true">file Upload</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="runningExam-tab" data-toggle="tab" href="#runningExam" role="tab" aria-controls="runningExam" aria-selected="true">Exam Schedule </a>
                    </li>
                </ul>
            </div><!-- header-part-end -->
            <div  class="tab-content" id="myTabContent">
                <!-- ========= All Exam =========== -->
                <div class="float-left w-75 border border-dark card-body tab-pane fade show active m-3 " style="height: auto;" id="allexam" role="tabpanel" aria-labelledby="allexam-tab">
                    <form class="md-form" class="border border-dark" action="" method="post">
                        <div class="form-group border border-dark" >
                            <select class="custom-select" required name="depertment">
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
                        <div class="form-group border border-dark" >
                            <select class="custom-select" required name="routine">
                                <option value="">Select One</option>
                                <option value="1">Class </option>
                                <option value="2">Mid-term Exam</option>
                                <option value="3">Semister Final Exam</option>
                            </select>
                        </div>
                        <div class="file-field border border-dark">
                            <div class="d-flex ">
                            <div class="btn btn-mdb-color btn-rounded float-left">
                                <span>Choose file</span>
                                <input type="file" name="file" class="" required>
                            </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-danger my-5">Upload file</button>
                    </form>
                </div>
                <!-- ========= Running Exam =========== -->
                <div class="card-body tab-pane fade p-1" id="runningExam" role="tabpanel" aria-labelledby="runningExam-tab">
                    <form action="actio.php" method="post" class="mt-3 col-md-6 col-12 px-1 mx-auto" >
                        <div class="col mt-5 w-100 px-0" >
                            <select class="custom-select" required>
                            <option value="">Course Code</option>
                                <option value="CSE">CSE-101</option>
                                <option value="CSE">CSE-102</option>
                                <option value="CSE">CSE-103</option>
                                <option value="CSE">CSE-104</option>
                                <option value="CSE">CSE-105</option>
                            </select>
                        </div>
                        <div class="col mt-5 w-100 px-0">
                            <input type="text" class="form-control " placeholder="Course title" name="Course tiltle" required readonly>
                        </div>
                        <div class="col px-0">
                            <input type="text" class="form-control" placeholder="Exam Type" name="Exam type" required>
                        </div>
                        <div class="col px-0" >
                            <input type="number" class="form-control" placeholder="Enter Your Batch" >
                        </div>
                        <div class="col px-0">
                            <input type="number" class="form-control" placeholder="Marks" required>
                        </div>
                        <div class="col px-0">
                            <input type="date" class="form-control" placeholder="Date" required>
                        </div>
                        <div class="col px-0">
                            <input type="time" class="form-control" placeholder="Time" required>
                        </div>
                        <div class="col px-0 mt-1 float-right">
                            <button type="submit" class="btn btn-outline-dark float-right">Confirm New Schedule </button>
                        </div>
                    </form>
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