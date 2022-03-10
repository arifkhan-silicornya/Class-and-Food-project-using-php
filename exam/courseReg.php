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
            <h6 style="font-size: 20px;" class="text-center">Pre-Advising</h6>
            <ul class="list-group list-group-flush ">
                <form action="">
                    <a href="" class="list-group-item list-group-item-primary ">Digital Logic Design</a>
                    <a href="" class="list-group-item list-group-item-info">Software Engineering</a></li>
                    <a href="" class="list-group-item list-group-item-danger">Software Quality Assurance</a></li>
                    <a href="" class="list-group-item list-group-item-dark">Advanced Java Enterprised</a></li>
                    <a href="" class="list-group-item list-group-item-success">Advanced Java Enterprised Labratory</a></li>
                    <button type="submit" class="w-100 btn btn-outline-dark bg-danger text-light mt-3">Submit For Advising</button>
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
                    <a class="nav-link active" id="preAdvising-tab" data-toggle="tab" href="#preAdvising" role="tab" aria-controls="preAdvising" aria-selected="true">Pre-Advising</a>
                </li>
                <li class="nav-item" role="presentation">
                <a class="nav-link " id="Advising-tab" data-toggle="tab" href="#advising" role="tab" aria-controls="advising" aria-selected="true">Advising</a>
                </li>
                <li class="nav-item" role="presentation">
                <a class="nav-link "   id="regCourses-tab" data-toggle="tab" href="#regCourses" role="tab" aria-controls="regCourses" aria-selected="true">Registered Courses</a>
                </li>
                </ul>
            </div><!-- header-part-end -->
            <div  class="tab-content" id="myTabContent">
                <div class="float-left w-100 p-2 card-body tab-pane fade show active" id="preAdvising" role="tabpanel" aria-labelledby="preAdvising-tab" style="height: auto;">
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
                            <tr>
                                <td>01</td>
                                <td>CSE-201</td>
                                <td>Software Quality Assurance</td>
                                <td>3</td>
                                <td><a href="" class="btn btn-outline-danger">Add</a></td>
                            </tr>
                            <tr>
                                <td>02</td>
                                <td>CSE-201</td>
                                <td>Advanced Java Enterprised Labratory</td>
                                <td>1.5</td>
                                <td><a href="" class="btn btn-outline-danger">Add</a></td>
                            </tr>
                            <tr>
                                <td>03</td>
                                <td>CSE-201</td>
                                <td>Advanced Java Enterprised </td>
                                <td>3</td>
                                <td><a href="" class="btn btn-outline-danger">Add</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body tab-pane fade " id="advising" role="tabpanel" aria-labelledby="Advising-tab">
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
                            <tr>
                                <td>01</td>
                                <td>CSE-201</td>
                                <td>Software Quality Assurance</td>
                                <td>3</td>
                                <td><a href="" class="btn btn-outline-danger">Remove</a></td>
                            </tr>
                            <tr>
                                <td>02</td>
                                <td>CSE-201</td>
                                <td>Advanced Java Enterprised Labratory</td>
                                <td>1.5</td>
                                <td><a href="" class="btn btn-outline-danger">Remove</a></td>
                            </tr>
                            <tr>
                                <td>03</td>
                                <td>CSE-201</td>
                                <td>Advanced Java Enterprised </td>
                                <td>3</td>
                                <td><a href="" class="btn btn-outline-danger">Remove</a></td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <form action="" method="post">
                                        <button type="submit" class="btn btn-outline-dark float-right mr-3" onclick="return window.confirm('Are You sure?\nOnce you Submit you could not Change It.');">Confirm</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body tab-pane fade " id="regCourses" role="tabpanel" aria-labelledby="regCourses-tab">
                    <h2>Registered Courses</h2>
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