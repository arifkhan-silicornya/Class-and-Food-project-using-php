<?php 
require_once("../../php/connection.php");

session_start();
$userid = $_SESSION['exmUserid'];


$exmtype = $_REQUEST['exmtype'];
$courseCode = $_REQUEST['courseCode'];
$courseTitle = $_REQUEST['courseTitle'];
$batch = $_REQUEST['batch'];
$totalQuestion = $_REQUEST['totalQuestion'];
$rightQuestion = $_REQUEST['rightQuestion'];
$wrongQuestion = $_REQUEST['wrongQuestion'];
$semesterYear = $_REQUEST['semesterYear'];
$description = $_REQUEST['description'];
$examDate = $_REQUEST['examDate'];
$exmTime = $_REQUEST['exmTime'];
$totalTime = $_REQUEST['totalTime'];

if (isset($_REQUEST['exmtype']) &&  isset($_REQUEST['courseCode']) && isset($_REQUEST['courseTitle']) && isset($_REQUEST['batch']) && isset($_REQUEST['totalQuestion']) &&   isset($_REQUEST['rightQuestion']) && isset($_REQUEST['wrongQuestion']) && isset($_REQUEST['semesterYear'])) {
    $insertDataInDb= "INSERT INTO `exam` (`exmType`,`course_code`,`course_title`,`batch`,`totalQuestion`,`rightAnswerMarks`,`wrongAnswerMarks`,`semisterYear`,`describtion`,`teacher_id`,`exmdate`,`exmtime`,`totaltime`)
    VALUES('$exmtype','$courseCode','$courseTitle','$batch','$totalQuestion','$rightQuestion','$wrongQuestion','$semesterYear','$description','$userid','$examDate','$exmTime','$totalTime')";
    $runquery = mysqli_query($conn, $insertDataInDb);

    if ($runquery == true) {
        header("location:../exam.php?succesfull");    
    }else {
        header("location:../exam.php?fail");    
    }
}
else{
    header("location:../exam.php?Failed");	
}
?>