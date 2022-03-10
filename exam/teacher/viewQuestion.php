<?php
require_once("../php/connection.php");
if(empty($_POST['examid']))
{
    header("location:exam.php");
}
else{
    $examid = $_REQUEST['examid']; 
}


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

    <title>View Question</title>

  </head>
  <body class="bg-light">
    <!-- Start heading Part -->
        <?php include 'header.php';?>
    <!-- End heading part -->

    <!-- ================= content part start =========== -->
    <section class="container" >
        <div class="card text-center pl-3">
            <div>
                <!-- ========= Add New Exam =========== -->
                <div class="p-1">
                <h3 class="h3 border py-2 text-info">All Questions</h3>
                <?php
                    $srno= 0;
                    $sql="SELECT * FROM `question` WHERE `exmid` = '$examid'";
                    $result=mysqli_query($conn,$sql);
                    while ($row=mysqli_fetch_array($result)) {
                        $questn = $row['questn'];
                        $opOne = $row['opOne'];
                        $optwo = $row['optwo'];
                        $opThree = $row['opThree'];
                        $opFour = $row['opFour'];
                        $correctAnswer = $row['correctAnswer'];
                        
                        $srno ++; ?>
                    <table class="table table-striped border pl-2">
                        <h4 class="text-left text-danger">Question <?php echo $srno; ?></h4>
                        <thead class="text-left pl-1">
                            <tr><th scope="col">Question : <?php echo $questn; ?> </th></tr>
                            <tr><th scope="col">Option 1 : <?php echo $opOne; ?> </th></tr>
                            <tr><th scope="col">Option 2 : <?php echo $optwo; ?> </th></tr>
                            <tr><th scope="col">Option 3 : <?php echo $opThree; ?> </th></tr>
                            <tr><th scope="col">Option 4 : <?php echo $opFour; ?> </th></tr>
                            <tr><th scope="col">Answer   : <?php echo $correctAnswer; ?> </th></tr>
                            </tr>
                        </thead>
                        </table>
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