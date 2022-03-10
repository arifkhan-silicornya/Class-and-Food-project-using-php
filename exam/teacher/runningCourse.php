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

<div class="d-flex justify-content-center px-0" id="content">
    <!-- left side start -->
    <section style="width:460px;" class="container-fluid float-left mt-5 pr-0 mb-5" id="left_side">
        <div class="border border-dark float-left w-100 p-1" style="height: auto;">
            <h6 style="font-size: 20px;" class="text-center">Running Course</h6>
            <ul class="list-group list-group-flush ">
                <a href="" class="list-group-item list-group-item-primary ">Digital Logic Design</a>
                <a href="" class="list-group-item list-group-item-info">Software Engineering</a></li>
                <a href="" class="list-group-item list-group-item-danger">Software Quality Assurance</a>
                <a href="" class="list-group-item list-group-item-dark">Advanced Java Enterprised</a>
                <a href="" class="list-group-item list-group-item-success">Advanced Java Enterprised Labratory</a>
                <a href="" class="list-group-item list-group-item-primary ">Digital Logic Design</a>
                <a href="" class="list-group-item list-group-item-info">Software Engineering</a>
                <a href="" class="list-group-item list-group-item-danger">Software Quality Assurance</a>
                <a href="" class="list-group-item list-group-item-dark">Advanced Java Enterprised</a>
                <a href="" class="list-group-item list-group-item-success">Advanced Java Enterprised Labratory</a>
            </ul>
        </div>
    </section>
    <!-- left side end -->

    <section class="container-fluid float-right mt-5 pl-0" id="right_side">
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" >Course Code - Course Title</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" >Uploaded File</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" >New File Upload</a>
                    </li>
                </ul>
            </div><!-- header-part-end -->
            <div  class="tab-content" id="myTabContent">
                <!-- ========= All Exam =========== -->
                <div class="float-left w-100 p-1 card-body tab-pane fade show active" style="height: auto;" id="allexam" role="tabpanel" aria-labelledby="allexam-tab">
                    <table class="table table-striped ">
                        <thead class="bg-success font-weight-bold">
                            <tr>
                                <td>|Exam Type|</td>
                                <td>|Batch|</td>
                                <td>|Total Marks|</td>
                                <td>|Time (mins)|</td>
                                <td>|Action|</td>
                            </tr>
                        </thead>
                        <tbody class="border border-bottom-0 border-success text-center">
                            <tr>
                                <td>Class Test</td>
                                <td>01</td>
                                <td>100</td>
                                <td>30</td>
                                <td>
                                    <a href="" class="btn btn-outline-danger">Question Details</a>
                                    <a href="" class="btn btn-outline-danger">Result</a>
                                </td>
                            </tr>
                        </tbody>
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
                                <td>|Marks|</td>
                                <td>|Total Marks|</td>
                                <td>|Time (mins)|</td>
                                <td>|Action|</td>
                            </tr>
                        </thead>
                        <tbody class="border border-bottom-0 border-success text-center">
                            <tr>
                                <td>CSE-201</td>
                                <td>Class Test</td>
                                <td>Software Quality Assurance</td>
                                <td>01</td>
                                <td>20</td>
                                <td>5</td>
                                <td>100</td>
                                <td>30</td>
                                <td><a href="" class="btn btn-outline-danger">Running</a></td>
                            </tr>
                            <tr>
                                <td>CSE-201</td>
                                <td>Midterm </td>
                                <td>Software Quality Assurance</td>
                                <td>02</td>
                                <td>20</td>
                                <td>5</td>
                                <td>100</td>
                                <td>30</td>
                                <td><a href="" class="btn btn-outline-danger">Running</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- ========= Add New Exam =========== -->
                <div class="card-body tab-pane fade p-1" id="allNewExam" role="tabpanel" aria-labelledby="allNewExam-tab">
                    
                </div>
            </div>
        </div>
    </section>

</div>


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
  </body>
</html>