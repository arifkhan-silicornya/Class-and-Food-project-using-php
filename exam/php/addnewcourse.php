<?php

require_once("connection.php");
// // To Add new Course to the course list

$courseCode = $_REQUEST['courseCode'];
$courseTitle = $_REQUEST['courseTitle'];
$credit = $_REQUEST['credit'];
$department = $_REQUEST['department'];

if (isset($_REQUEST['courseCode']) &&  isset($_REQUEST['courseTitle']) && isset($_REQUEST['credit']) && isset($_REQUEST['department'])) {

    $insertDataInDb= "INSERT INTO `course` (`course_code`,`course_title`,`credit`,`department`) VALUES('$courseCode','$courseTitle','$credit','$department')";
    $runquery = mysqli_query($conn, $insertDataInDb);

    if ($runquery == true) {
        header("location: ../teacher/newcourse.php?New_Course_Inserted_Successful");
    }
    else{
        header("location: ../teacher/newcourse.php?operation_Failed");
    }
}

?>