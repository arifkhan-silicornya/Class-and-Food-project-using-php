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
                        <a class="nav-link active" id="allexam-tab" data-toggle="tab" href="#allexam" role="tab" aria-controls="allexam" aria-selected="true">All Result</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="runningExam-tab" data-toggle="tab" href="#runningExam" role="tab" aria-controls="runningExam" aria-selected="true">Pending</a>
                    </li>
                </ul>
            </div><!-- header-part-end -->
            <div  class="tab-content" id="myTabContent">
                <!-- ========= All Exam =========== -->
                <div class="float-left w-100 p-1 card-body tab-pane fade show active" style="height: auto;" id="allexam" role="tabpanel" aria-labelledby="allexam-tab">
                    <table class="table table-striped ">
                        <thead class="bg-success font-weight-bold">
                            <tr>
                                <td>|Course Code|</td>
                                <td>|Exam Type|</td>
                                <td>|Course title|</td>
                                <td>|Batch|</td>
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
                                <td>100</td>
                                <td>30</td>
                                <td>
                                    <a href="" class="btn btn-outline-danger">Question details</a>
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
                                <td>100</td>
                                <td>30</td>
                                <td><a class="btn bg-danger text-light">Publish</a></td>
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

</script>
  </body>
</html>