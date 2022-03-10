<?php

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
                        <a class="nav-link " id="runningExam-tab" data-toggle="tab" href="#runningExam" role="tab" aria-controls="runningExam" aria-selected="true">Attendence</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="assignment-tab" data-toggle="tab" href="#assignment" role="tab" aria-controls="assignment" aria-selected="true">Assignment</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link " id="tutorial-tab" data-toggle="tab" href="#tutorial" role="tab" aria-controls="tutorial" aria-selected="true">Tutorial</a>
                    </li>
                </ul>
            </div><!-- header-part-end -->
            <div  class="tab-content" id="myTabContent">
                <!-- ========= file Upload =========== -->
                <div class="float-left w-75 p-1 card-body tab-pane fade show active m-3" style="height: auto;" id="allexam" role="tabpanel" aria-labelledby="allexam-tab">
                    <h3 class="h3 my-3 mb-5">Upload Class Material</h3>
                    <form class="md-form" class="border border-dark" action="" method="post">
                        <div class="form-group border border-dark" >
                            <select class="custom-select" required name="depertment">
                                <option value="">Select Course</option>
                                <option value="CSE-101">CSE-101 (Computer Fundamental)</option>
                            </select>
                        </div>
                        <div class="form-group border border-dark">
                            <label for="formGroupExampleInput " class="sr-only">Lecture</label>
                            <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Lecture ( Example : 1 / 2 / 3 /1. part 1 )">
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
                <!-- ========= Attendence =========== -->
                <div class="card-body tab-pane fade p-1" id="runningExam" role="tabpanel" aria-labelledby="runningExam-tab">
                    <div class="d-flex">
                        <div class="w-25">
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
                                </ul>
                            </div>
                        </div>
                        <div class="w-75">
                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" >Course Code | Course Title | Batch-41 |</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="midterm-tab" data-toggle="tab" href="#midterm" role="tab" aria-controls="midterm" aria-selected="true">Midterm</a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link " id="final-tab" data-toggle="tab" href="#final" role="tab" aria-controls="final" aria-selected="true">Final</a>
                                        </li>
                                    </ul>
                                </div>
                                <div  class="tab-content" id="myTabContent"> 
                                    <!-- Midterm -->
                                    <div class="float-left w-75 p-1 card-body tab-pane fade show active m-3" style="height: auto;" id="midterm" role="tabpanel" aria-labelledby="midterm-tab">
                                        <table class="table table-striped table-responsive">
                                            <thead class="bg-success font-weight-bold">
                                                <tr>
                                                    <td>|Id|</td>
                                                    <td>|Name|</td>
                                                    <td>|Batch|</td>
                                                    <td>|class-1| <br> 10/10/2020 </td>
                                                    <td>|class-2| <br> 10/10/2020 </td>
                                                    <td>|<button class="btn btn-outline-dark border-0 font-weight-bolder" onclick="addNewClass();"> + </button>| </td>
                                                </tr>
                                            </thead>
                                            <tbody class="border border-bottom-0 border-success text-center">
                                                <tr>
                                                    <td>420</td>
                                                    <td>Aminul Islam Maruf</td>
                                                    <td>41</td>
                                                    <td>
                                                        <select class="custom-select">
                                                            <option selected>Attendence</option>
                                                            <option value="a">A</option>
                                                            <option value="p">P</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="custom-select">
                                                            <option selected>Attendence</option>
                                                            <option value="a">A</option>
                                                            <option value="p">P</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>420</td>
                                                    <td>Aminul Islam Maruf</td>
                                                    <td>41</td>
                                                    <td>
                                                        <select class="custom-select">
                                                            <option selected>Attendence</option>
                                                            <option value="a">A</option>
                                                            <option value="p">P</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="custom-select">
                                                            <option selected>Attendence</option>
                                                            <option value="a">A</option>
                                                            <option value="p">P</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Final -->
                                    <div class="float-left w-75 p-1 card-body tab-pane fade show m-3" style="height: auto;" id="final" role="tabpanel" aria-labelledby="final-tab">
                                        <table class="table table-striped table-responsive">
                                            <thead class="bg-success font-weight-bold">
                                                <tr>
                                                    <td>|Id|</td>
                                                    <td>|Name|</td>
                                                    <td>|Batch|</td>
                                                    <td>|class-1| <br> 10/10/2020 </td>
                                                    <td>|class-2| <br> 10/10/2020 </td>
                                                    <td>|<button class="btn btn-outline-dark border-0 font-weight-bolder" onclick="addNewClass();"> + </button>| </td>
                                                </tr>
                                            </thead>
                                            <tbody class="border border-bottom-0 border-success text-center">
                                                <tr>
                                                    <td>420</td>
                                                    <td>Aminul Islam Maruf</td>
                                                    <td>41</td>
                                                    <td>
                                                        <select class="custom-select">
                                                            <option value="">Attendence</option>
                                                            <option value="a">A</option>
                                                            <option value="p">P</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="custom-select">
                                                            <option value="">Attendence</option>
                                                            <option value="a">A</option>
                                                            <option value="p">P</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>420</td>
                                                    <td>Aminul Islam Maruf</td>
                                                    <td>41</td>
                                                    <td>
                                                        <select class="custom-select">
                                                            <option value="">Attendence</option>
                                                            <option value="a">A</option>
                                                            <option value="p">P</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="custom-select">
                                                            <option value="">Attendence</option>
                                                            <option value="a">A</option>
                                                            <option value="p">P</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ========= Assignment =========== -->
                <div class="card-body tab-pane fade p-1" id="assignment" role="tabpanel" aria-labelledby="assignment-tab">
                    <h3 class="h3">Assignment</h3>
                    <div class="card text-center">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="addNewAss-tab" data-toggle="tab" href="#addNewAss" role="tab" aria-controls="addNewAss" aria-selected="true">Add New Assignment</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link " id="submittedAss-tab" data-toggle="tab" href="#submittedAss" role="tab" aria-controls="submittedAss" aria-selected="true">Submitted Assignment</a>
                                </li>
                            </ul>
                        </div>
                        <div  class="tab-content" id="myTabContent">
                            <div class="float-left w-75 p-1 card-body tab-pane fade show active m-3" style="height: auto;" id="addNewAss" role="tabpanel" aria-labelledby="addNewAss-tab">
                                <form class="p-4 col-12 col-md-10 mx-auto" action="#action" method="post">
                                    <div class="form-group border border-dark" >
                                        <select class="custom-select" required name="depertment">
                                            <option value="">Select Course </option>
                                            <option value="cse-101">Cse-101 (Computer Fundamental)</option>
                                        </select>
                                    </div>
                                    <div class="form-group border border-dark" >
                                        <select class="custom-select" required name="depertment">
                                            <option value="">Assignment No.</option>
                                            <option value="ass1">Assignment 1</option>
                                            <option value="ass2">Assignment 2</option>
                                            <option value="ass3">Assignment 3</option>
                                            <option value="ass4">Assignment 4</option>
                                            <option value="ass5">Assignment 5</option>
                                            <option value="ass6">Assignment 6</option>
                                        </select>
                                    </div>
                                    <div class="form-group my-1 border border-dark">
                                        <label for="courseCode" class="sr-only">Assignment Topic</label>
                                        <input type="text" class="form-control" id="courseCode" placeholder="Assignment Topic" required>
                                    </div>
                                    <div class="form-group border border-dark my-1 mt-3">
                                        <div class="d-flex ">
                                            <div class="btn btn-mdb-color btn-sm float-left">
                                                <span class="">Choose file</span>
                                                <input type="file" name="file" class="border border-dark border-right-0" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" clearfix"></div>
                                    <div class="form-group my-1 float-left ">
                                        <button type="submit" class="btn btn-outline-dark">Upload</button>
                                    </div>
                                </form>
                            </div>
                            <div class="float-left w-100 p-1 card-body tab-pane fade show m-3" style="height: auto;" id="submittedAss" role="tabpanel" aria-labelledby="submittedAss-tab">
                                <section style="width:400px;" class="container-fluid float-left mt-5 pr-0 mb-5 w-25" id="left_side">
                                    <div class="border border-dark float-left w-100 p-1" style="height: auto;">
                                        <h6 style="font-size: 20px;" class="text-center">Course List</h6>
                                        <ul class="list-group list-group-flush ">
                                            <a href="" class="list-group-item list-group-item-primary ">Digital Logic Design</a>
                                            <a href="" class="list-group-item list-group-item-info">Software Engineering</a></li>
                                            <a href="" class="list-group-item list-group-item-danger">Software Quality Assurance</a>
                                            <a href="" class="list-group-item list-group-item-dark">Advanced Java Enterprised</a>
                                            <a href="" class="list-group-item list-group-item-success">Advanced Java Enterprised Labratory</a>
                                            <a href="" class="list-group-item list-group-item-primary ">Digital Logic Design</a>
                                            <a href="" class="list-group-item list-group-item-info">Software Engineering</a>
                                        </ul>
                                    </div>
                                </section>
                                <section class="container-fluid float-right mt-5 pl-0 border border-left-0 border-dark w-75" id="right_side">
                                    <div class="card text-center">
                                        <div class="card-header">
                                            <div>Course Code - Course Title</div>
                                            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link active" id="ass1-tab" data-toggle="tab" href="#ass1" role="tab" aria-controls="ass1" aria-selected="true">Assignment 1</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link " id="ass2-tab" data-toggle="tab" href="#ass2" role="tab" aria-controls="ass2" aria-selected="true">Assignment 2</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link " id="ass3-tab" data-toggle="tab" href="#ass3" role="tab" aria-controls="ass3" aria-selected="true">Assignment 3</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link " id="ass4-tab" data-toggle="tab" href="#ass4" role="tab" aria-controls="ass4" aria-selected="true">Assignment 4</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link " id="ass5-tab" data-toggle="tab" href="#ass5" role="tab" aria-controls="ass5" aria-selected="true">Assignment 5</a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link " id="ass6-tab" data-toggle="tab" href="#ass6" role="tab" aria-controls="ass6" aria-selected="true">Assignment 6</a>
                                                </li>
                                            </ul>
                                        </div><!-- header-part-end -->
                                        <div  class="tab-content" id="myTabContent">
                                            <!-- ========= body =========== -->
                                            <div class="float-left w-100 p-1 card-body tab-pane fade show active" style="height: auto;" id="ass1" role="tabpanel" aria-labelledby="ass1-tab">
                                                <table class="table table-striped ">
                                                    <thead class="bg-success font-weight-bold">
                                                        <tr>
                                                            <td>|Id|</td>
                                                            <td>|Name|</td>
                                                            <td>|Batch|</td>
                                                            <td>|Date|</td>
                                                            <td>|Time|</td>
                                                            <td>|Action|</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="border border-bottom-0 border-success text-center">
                                                        <tr>
                                                            <td>420</td>
                                                            <td>Aminul Islam Maruf</td>
                                                            <td>41</td>
                                                            <td>5/5/1997</td>
                                                            <td>10:30</td>
                                                            <td>
                                                                <a href="" class="btn btn-outline-dark">Preview</a>
                                                                <a href="" class="btn btn-outline-danger">Download</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- ========= Assignment 2 =========== -->
                                            <div class="card-body tab-pane fade p-1" id="ass2" role="tabpanel" aria-labelledby="ass2-tab">
                                                <table class="table table-striped ">
                                                    <thead class="bg-success font-weight-bold">
                                                        <tr>
                                                            <td>|Id|</td>
                                                            <td>|Name|</td>
                                                            <td>|Batch|</td>
                                                            <td>|Date|</td>
                                                            <td>|Time|</td>
                                                            <td>|Action|</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="border border-bottom-0 border-success text-center">
                                                        <tr>
                                                            <td>421</td>
                                                            <td>Aminul Islam Maruf</td>
                                                            <td>41</td>
                                                            <td>7/6/1998</td>
                                                            <td>11:30</td>
                                                            <td>
                                                                <a href="" class="btn btn-outline-dark">Preview</a>
                                                                <a href="" class="btn btn-outline-danger">Download</a>
                                                            </td>
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
                        </div>
                    </div>
                    
                </div>
                <!-- ========= Tutorial =========== -->
                <div class="card-body tab-pane fade p-1" id="tutorial" role="tabpanel" aria-labelledby="tutorial-tab">
                    <h3 class="h3">Tutorial</h3>
                    <div>Site Is Under Construction........................</div>
                    <div>Update will Come Soon</div>
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