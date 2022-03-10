<?php

if(empty($_REQUEST['exmid']) && empty($_REQUEST['totalques']))
{
    header("location:exam.php");
}
else{
    $examId = $_REQUEST['exmid']; 
    $totalques = $_REQUEST['totalques']; 
}


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link  rel="stylesheet" href="../css/bootstrap.min.css"/>
    <link  rel="stylesheet" href="../css/style.css"/>

    <title>question</title>
    <style>
        ::placeholder{
            color: grey!important;
        }
    </style>

  </head>
  <body class="bg-light">
    <!-- Start heading Part -->
        <?php include 'header.php';?>
    <!-- End heading part -->

    <!-- ================= content part start =========== -->
    <section class="container-fluid " >
        <div class="card text-center">
            <div>
                <!-- ========= Add New Exam =========== -->
                <div class="p-1">
                <h3 class="h3">Enter Quiz Details</h3>
                    <?php
                        $sql="SELECT * FROM `question` WHERE `exmid` = '$examId'";
                        $result=mysqli_query($conn,$sql);
                        $counterSubmitQuestion = 0;
                        while($row=mysqli_fetch_array($result))
                        {
                            $counterSubmitQuestion++ ;
                        }
                        $srno= 1;
                        if ($counterSubmitQuestion < $totalques) {
                            ?>
                    
                    <form class="p-4 col-12 col-md-10 mx-auto mb-5" action="php/question.php" method="post">
                        <input type="number" class="form-control border border-dark d-none" required name="exmid" value="<?php echo $examId;?>">
                        <input type="number" class="form-control border border-dark d-none" required name="totalQ" value="<?php echo $totalques;?>">
                        <div class="form-group my-1 form-row ">
                            <label class="px-5 py-2 border bg-danger font-weight-bolder ">Question <?php echo $counterSubmitQuestion+1; ?>: </label>
                            <input type="text" class="form-control border border-dark" placeholder="Enter Your Question " required name="question" value="">
                        </div> 
                        <div class=" mt-2 ">
                            <div class="form-group my-0 form-row d-flex flex-row mb-1">
                                <div class="input-group-prepend border border-danger"><label class="font-weight-bold input-group-text text-left px-5 py-1">Option 1 </label></div>
                                <input type="text" class="form-control w-75 border border-dark" placeholder="Option 1  " required name="Option1">
                            </div>
                            <div class="form-group my-0 form-row d-flex flex-row mb-1">
                                <div class="input-group-prepend border border-danger"><label class=" font-weight-bold input-group-text text-left px-5 py-1">Option 2 </label></div>
                                <input type="text" class="form-control w-75 border border-dark" placeholder="Option 2  " required name="Option2">
                            </div>
                            <div class="form-group my-0 form-row d-flex flex-row mb-1">
                                <div class="input-group-prepend border border-danger"><label class=" font-weight-bold input-group-text text-left px-5 py-1">Option 3 </label></div>
                                <input type="text" class="form-control w-75 border border-dark" placeholder="Option 3  " required name="Option3">
                            </div>
                            <div class="form-group my-0 form-row d-flex flex-row">
                                <div class="input-group-prepend border border-danger "><label class=" font-weight-bold input-group-text text-left px-5 py-1">Option 4 </label></div>
                                <input type="text" class="form-control w-75 border border-dark" placeholder="Option 4  " required name="Option4">
                            </div>
                            <div class="input-group mt-3 mb-4 mx-0 ml-0 mx-0 px-0 d-flex flex-row border border-dark w-75">
                                <div class="input-group-prepend">
                                    <label class="input-group-text font-weight-bolder " >Correct Answer</label>
                                </div>
                                <select class="custom-select text-dark" required name="correctAnswer">
                                    <option value="">Correct Answer</option>
                                    <option value="1">Option One</option>
                                    <option value="2">Option Two</option>
                                    <option value="3">Option Three</option>
                                    <option value="4">Option Four</option>
                                </select>
                            </div>
                            <br/>
                            <div class=" clearfix"></div>
                            <div class="form-group mb-5  float-left ">
                                <button type="submit" class="btn btn-outline-dark" onclick="return confirm('Are you sure?\n\n')">Save</button>
                                <button type="button" class="btn btn-danger text-light ml-1" onclick="return confirm('Input field will clear\n\nAre you sure?'),inputFieldRefresh();" >Reset</button>
                            </div>
                        </div>
                    </form>
                <?php
                    }
                    else {
                ?>
                <div class="text-danger bg-warning py-5 my-5 font-weight-bold"> All Question Setup. </div>
                <?php        
                    }
                ?>
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