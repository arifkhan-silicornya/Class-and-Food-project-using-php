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

<div class="d-flex justify-content-center px-0 container" id="content">
    <section class="container-fluid float-right mt-5 pl-0" id="right_side">
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="allCourses-tab" data-toggle="tab" href="#allCourses" role="tab" aria-controls="allCourses" aria-selected="true">Exam Routine </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="runningcorses-tab" data-toggle="tab" href="#runningcorses" role="tab" aria-controls="runningcorses" aria-selected="true">Class Routine</a>
                    </li>
                </ul>
            </div><!-- header-part-end -->
            <div  class="tab-content" id="myTabContent">
                <div class="float-left w-100 p-1 card-body tab-pane fade show active" style="height: auto;" id="allCourses" role="tabpanel" aria-labelledby="allCourses-tab">
                    <img class="img-fluid" src="image/exmR.jpg" alt="Exam Routine">
                </div>
                <!-- ========= Running Courses =========== -->
                <div class="card-body tab-pane fade p-1" id="runningcorses" role="tabpanel" aria-labelledby="runningcorses-tab">
                <img class="img-fluid" src="image/classR.jpg" alt="Class Routine">
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