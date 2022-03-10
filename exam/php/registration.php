<?php

require_once("connection.php");
// // To Create Uniq Account Number For User 
   

$department = "NULL";
$batch = "NULL";

if (isset($_REQUEST['name']) &&  isset($_REQUEST['verid']) && isset($_REQUEST['gender']) && isset($_REQUEST['userType']) && isset($_REQUEST['phone']) &&   isset($_REQUEST['password']) && isset($_REQUEST['confirmPass']) ) {

   $name = htmlentities($_REQUEST['name']);
   $verid = htmlentities($_REQUEST['verid']);
   $gender = htmlentities($_REQUEST['gender']);
   $userType = htmlentities($_REQUEST['userType']);
   $phone = htmlentities($_REQUEST['phone']);
   $department = htmlentities($_REQUEST['department']);
   $batch = htmlentities($_REQUEST['batch']);
   $password    = md5(sha1($_REQUEST['password']));
   $confirmPass    = md5(sha1($_REQUEST['confirmPass']));

   if ($userType == "student" && ( $department== "" || $batch == "" )) {
      header("location: ../index.php?fillUpAll");
   }
   else {
      if ($password == $confirmPass) {
         $SELECT= "SELECT `versityid` FROM `user` where `versityid` = ? limit 1";

         //prepare statement
         $stmt = $conn->prepare($SELECT);
         $stmt -> bind_param("i", $verid);
         $stmt -> execute();
         $stmt -> bind_result($verid);
         $stmt -> store_result();
         $rnum = $stmt -> num_rows;
         if ($rnum == 0) {
            $stmt -> close();

            $insertDataInDb= "INSERT INTO `user` (`name`,`versityid`,`gender`,`usertype`,`depertment`,`batch`,`mobile`,`password`) VALUES('$name','$verid','$gender','$userType','$department','$batch','$phone','$password')";
            $runquery = mysqli_query($conn, $insertDataInDb);

            if ($runquery == true) {
                header("location: ../index.php?Registration_Successful"); 
            }

            }else {
               header("location: ../index.php?duplicate_ID");
            }
         }else {
            header("location: ../index.php?passwordNotmMatched");
      }
   }
   $conn -> close();
   }
else{
   header("location: ../index.php?fillupAllField");
}
?>