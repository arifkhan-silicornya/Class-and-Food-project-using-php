<?php
session_start();
$userID=$_SESSION['userid'];


require_once("conect_database.php");

$username = htmlentities($_REQUEST['username']);
$department = htmlentities($_REQUEST['department']);
$batch  = htmlentities($_REQUEST['batch']);
$designation  = htmlentities($_REQUEST['designation']);
$email = htmlentities($_REQUEST['email']);
$Phn_num  = htmlentities($_REQUEST['Phn_num']);
$deliveryAdd = htmlentities($_REQUEST['deliveryAdd']);

$sql="UPDATE `users` SET `user_role`='$designation' ,`username`='$username',`email`='$email',`department`='$department' ,`batch`='$batch', `address`='$deliveryAdd' ,`contact`='$Phn_num'  WHERE `studentid`='$userID' ";
$user_acc_update= "UPDATE `user_account` SET `user_name`='$username' WHERE `user_institute_id` = '$userID' ";
$recharge_users_update = "UPDATE `recharge_users` SET `user_name`='$username' WHERE `user_id` = '$userID' ";

mysqli_query($connect,$user_acc_update);
mysqli_query($connect,$recharge_users_update);
$result=mysqli_query($connect,$sql);

if($result == true)
       {
        header("location:../dashboard.php?ProfileUpdated");
        } 
    else {
        header("location:../dashboard.php?error :".mysqli_error($sql));
    }
?>