<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link  rel="stylesheet" href="css/bootstrap.min.css"/>
    <link  rel="stylesheet" href="css/style.css"/>

    <title>home</title>
  </head>
  <body class="bg-light">
    <!-- Start heading Part -->
    <?php include 'header.php';?>
    <!-- End heading part -->

<div class="d-flex justify-content-center px-0" id="content">
    <!-- left side start -->
    <section style="width:400px;" class="container-fluid float-left mt-5 pr-0 mb-5" id="left_side">
        <div class="border border-dark float-left w-100 p-1" style="height: auto;">
            <h6 style="font-size: 20px;" class="text-center">All Courses</h6>
            <ul class="list-group list-group-flush ">
                <form action="">
                    <a href="" class="list-group-item list-group-item-primary ">Digital Logic Design</a>
                    <a href="" class="list-group-item list-group-item-info">Software Engineering</a></li>
                    <a href="" class="list-group-item list-group-item-danger">Software Quality Assurance</a></li>
                    <a href="" class="list-group-item list-group-item-dark">Advanced Java Enterprised</a></li>
                    <a href="" class="list-group-item list-group-item-success">Advanced Java Enterprised Labratory</a></li>
                </form>
            </ul>
        </div>
    </section>
    <!-- left side end -->

    <section class="container-fluid float-right mt-5 pl-0" id="right_side">
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="allCourses-tab" data-toggle="tab" href="#allCourses" role="tab" aria-controls="allCourses" aria-selected="true">All Courses </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="runningcorses-tab" data-toggle="tab" href="#runningcorses" role="tab" aria-controls="runningcorses" aria-selected="true">Running Courses</a>
                    </li>
                </ul>
            </div><!-- header-part-end -->
            <div  class="tab-content" id="myTabContent">
                <div class="float-left w-100 p-1 card-body tab-pane fade show active" style="height: auto;" id="allCourses" role="tabpanel" aria-labelledby="allCourses-tab">
                    <table class="table table-striped ">
                        <div class="font-weight-bold text-center bg-success">Summer 2020</div>
                        <thead class="bg-success font-weight-bold">
                            <tr>
                                <td>|S.N.|</td>
                                <td>|Course Code|</td>
                                <td>|Course title|</td>
                                <td>|Attempt Credit|</td>
                                <td>|Earned Credit|</td>
                                <td>|GPA|</td>
                                <td>|Grade|</td>
                            </tr>
                        </thead>
                        <tbody class="border border-bottom-0 border-success text-center">
                            <tr>
                                <td>01</td>
                                <td>CSE-201</td>
                                <td>Software Quality Assurance</td>
                                <td>20</td>
                                <td>5</td>
                                <td>5</td>
                                <td>3.50</td>
                            </tr>
                            <tr>
                                <td>02</td>
                                <td>CSE-201</td>
                                <td>Software Quality Assurance</td>
                                <td>20</td>
                                <td>5</td>
                                <td>5</td>
                                <td>3.50</td>
                            </tr>
                            <tr>
                                <td>03</td>
                                <td>CSE-201</td>
                                <td>Software Quality Assurance</td>
                                <td>20</td>
                                <td>5</td>
                                <td>5</td>
                                <td>3.10</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- ========= 2nd semister ========= -->
                    <table class="table table-striped ">
                        <div class="font-weight-bold text-center bg-success">Spring 2020</div>
                        <thead class="bg-success font-weight-bold">
                            <tr>
                                <td>|S.N.|</td>
                                <td>|Course Code|</td>
                                <td>|Course title|</td>
                                <td>|Attempt Credit|</td>
                                <td>|Earned Credit|</td>
                                <td>|GPA|</td>
                                <td>|Grade|</td>
                            </tr>
                        </thead>
                        <tbody class="border border-bottom-0 border-success text-center">
                            <tr>
                                <td>01</td>
                                <td>CSE-201</td>
                                <td>Software Quality Assurance</td>
                                <td>20</td>
                                <td>5</td>
                                <td>5</td>
                                <td>3.12</td>
                            </tr>
                            <tr>
                                <td>02</td>
                                <td>CSE-201</td>
                                <td>Software Quality Assurance</td>
                                <td>20</td>
                                <td>5</td>
                                <td>5</td>
                                <td>3.50</td>
                            </tr>
                            <tr>
                                <td>03</td>
                                <td>CSE-201</td>
                                <td>Software Quality Assurance</td>
                                <td>20</td>
                                <td>5</td>
                                <td>5</td>
                                <td>3.10</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- ========= Running Courses =========== -->
                <div class="card-body tab-pane fade p-1" id="runningcorses" role="tabpanel" aria-labelledby="runningcorses-tab">
                <table class="table table-striped ">
                        <thead class="bg-success font-weight-bold">
                            <tr>
                                <td>|S.N.|</td>
                                <td>|Exam Type|</td>
                                <td>|Course Code|</td>
                                <td>|Course title|</td>
                                <td>|Total Question|</td>
                                <td>|Marks|</td>
                                <td>|Total Marks|</td>
                                <td>|Time (mins)|</td>
                                <td>|GPA|</td>
                            </tr>
                        </thead>
                        <tbody class="border border-bottom-0 border-success text-center">
                            <tr>
                                <td>01</td>
                                <td>Class Test</td>
                                <td>CSE-201</td>
                                <td>Software Quality Assurance</td>
                                <td>20</td>
                                <td>5</td>
                                <td>100</td>
                                <td>30</td>
                                <td>2.5</td>
                            </tr>
                            <tr>
                                <td>02</td>
                                <td>Midterm </td>
                                <td>CSE-201</td>
                                <td>Software Quality Assurance</td>
                                <td>20</td>
                                <td>5</td>
                                <td>100</td>
                                <td>30</td>
                                <td>3.3</td>
                            </tr>
                        </tbody>
                    </table>
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

    <script src="js/bootstrap.min.js"  type="text/javascript"></script>
    <script src="js/custom.js"  type="text/javascript"></script>
  </body>
</html>