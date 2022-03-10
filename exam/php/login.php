<?php
session_start();
require_once("connection.php");

$userId=$_REQUEST['userId'];
$userType=$_REQUEST['userType'];
$password = md5(sha1($_REQUEST['password']));



$sql="SELECT * FROM user WHERE  `versityid`='$userId' AND `usertype`='$userType' AND `password`='$password' AND `delete` = '0' ";
$result=mysqli_query($conn,$sql);


if(mysqli_num_rows($result) > 0)
{
	$_SESSION['exmUserid']=$userId;
	$_SESSION['exmUsertype']=$userType;

	if ($userType == 'student') {
		header("location:../home.php?Successfully_Login");	
	}
	else {
		header("location:../teacher/home.php?Successfully_Login");	
	}
	
}
else
{
	header("location:../index.php?login_Failed");
}


?>