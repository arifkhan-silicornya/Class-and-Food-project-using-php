<?php

require_once("conect_database.php");
// //  ===============  End ===================
// // To Create Uniq Account Number For User 
   

$department = "NULL";
$batch = "NULL";

if (isset($_REQUEST['username']) &&  isset($_REQUEST['studentID']) &&  isset($_REQUEST['password']) && isset($_REQUEST['password2']) ) {

   $username = htmlentities($_REQUEST['username']);
   $userType = htmlentities($_REQUEST['userType']);
   $phn_num = htmlentities($_REQUEST['phn_num']);
   $gender = htmlentities($_REQUEST['gender']);
   $department = htmlentities($_REQUEST['department']);
   $batch = htmlentities($_REQUEST['batch']);
   $studentID  = htmlentities($_REQUEST['studentID']);
   $password    = md5(sha1($_REQUEST['password']));
   $password2    = md5(sha1($_REQUEST['password2']));

   if ($userType == "student" && $department== "" || $batch == "") {
      header("location: ../createnewacc.php?fillUpAll");
   }
   else {
      if ($password == $password2) {
         $SELECT= "SELECT `studentid` FROM `users` where `studentid` = ? limit 1";

         //prepare statement
         $stmt = $connect->prepare($SELECT);
         $stmt -> bind_param("i", $studentID);
         $stmt -> execute();
         $stmt -> bind_result($studentID);
         $stmt -> store_result();
         $rnum = $stmt -> num_rows;
         if ($rnum == 0) {
            $stmt -> close();

            $insertDataInDb= "INSERT INTO `users` (`user_role`,`username`,`studentid`,`department`,`batch`,`gender`,`password`,`contact`) VALUES('$userType','$username','$studentID','$department','$batch','$gender','$password','$phn_num')";
            $runquery = mysqli_query($connect, $insertDataInDb);

            if ($runquery == true) {
               $create_new_account = "INSERT INTO `user_account` (  `user_institute_id`, `user_name`) VALUES (  '$studentID', '$username')";
               $create_account_run_query = mysqli_query($connect, $create_new_account);
               if ($create_account_run_query == true) {
                  header("location: ../index.php?loginNow");
               }else {
                  header("location: ../createnewacc.php?FailedToCreate");
                  }
               }else {
                  header("location: ../createnewacc.php?FailedToCreate");
               }
            }else {
               header("location: ../createnewacc.php?duplicate_ID");
            }
         }else {
            header("location: ../createnewacc.php?passwordNotmMatched");
      }
   }
   $connect -> close();
   }
else{
   header("location: ../createnewacc.php?fillupAllField");
}
?>