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
    
        <?php if (isset($_REQUEST['New_Course_Inserted_Successful'])){
            echo "
            <div class='w-100 bg-warning text-danger container font-weight-bold py-3'>
               New Course Inserted Successfully
            </div>";
            }
        ?>
    <!-- ================= content part start =========== -->
    <section class="container mt-5 border" >
        <h5 class="h5 py-3">Add New Course To The Course List :</h5><br>
        <div class="card text-center">
            <form class="md-form " class="border border-dark" action="../php/addnewcourse.php" method="post">
                <div class="form-group border border-dark">
                    <label for="formGroupExampleInput " class="sr-only">Course Code</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Course code. Example : CSE-101" required name="courseCode">
                </div>
                <div class="form-group border border-dark">
                    <label for="formGroupExampleInput " class="sr-only">Course Title</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Course title. Example : Digital Logic Design" required name="courseTitle">
                </div>
                <div class="form-group border border-dark">
                    <label for="formGroupExampleInput " class="sr-only">Credit</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Credit. Example : 3 " required name="credit">
                </div>
                <div class="form-group border border-dark">
                    <div class="col px-0 mb-1" >
                        <select class="custom-select"  name="department" required name="department">
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
                </div>

                <button type="submit" value="submit" class="btn btn-outline-dark" >Save</button>
            </form>
        </div>
    </section>
    <!-- ================= content part End =========== -->
    


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