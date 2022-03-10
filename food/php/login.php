<?php
session_start();
require_once("conect_database.php");

$userID=$_REQUEST['userID'];
$password = md5(sha1($_REQUEST['password']));

$sql="SELECT * FROM users WHERE  `studentid`='$userID' AND `password`='$password' AND `deleted` = '0' ";
$result=mysqli_query($connect,$sql);


if(mysqli_num_rows($result) > 0)
{
	$_SESSION['userid']=$userID;
	$_SESSION['password']=$password;
	header("location:../home.php?Successfully_Login");
}
else
{
	header("location:../index.php?Login_Failed");
}


?>