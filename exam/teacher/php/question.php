<?php 
require_once("../../php/connection.php");


$exmid = $_REQUEST['exmid'];
$totalQ = $_REQUEST['totalQ'];
$question = $_REQUEST['question'];
$OptionOne = $_REQUEST['Option1'];
$OptionTwo = $_REQUEST['Option2'];
$OptionThree = $_REQUEST['Option3'];
$OptionFour = $_REQUEST['Option4'];
$correctAnswer = $_REQUEST['correctAnswer'];

$sql="SELECT * FROM `question` WHERE `exmid` = '$exmid'";
$result=mysqli_query($conn,$sql);
$counterSubmitQuestion = 0;
while($row=mysqli_fetch_array($result))
{
    $counterSubmitQuestion++ ;
}
$counterSubmitQuestion++ ;

if (isset($_REQUEST['exmid']) &&  isset($_REQUEST['question']) && isset($_REQUEST['Option1']) && isset($_REQUEST['Option2']) && isset($_REQUEST['Option3']) &&   isset($_REQUEST['Option4']) && isset($_REQUEST['correctAnswer'])) {
    $insertData= "INSERT INTO `question` (`question_id`, `exmid`, `questn`, `opOne`, `optwo`, `opThree`, `opFour`, `correctAnswer`, `create_date`) VALUES (NULL, '$exmid', '$question', '$OptionOne', '$OptionTwo', '$OptionThree', '$OptionFour', '$correctAnswer', current_timestamp());";
    $runQuery = mysqli_query($conn, $insertData);

    if ($runQuery == true) {
        if ($counterSubmitQuestion == $totalQ) {
            header("location:../exam.php?allQuestionSetup");
        }
        else {
            header("location:../question.php?exmid=$exmid&totalques=$totalQ");
        }
        
    } else {
        header("location:../question.php?fail");
    }
}else {
    header("location:../question.php?failed");    
}

?>