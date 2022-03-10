<?php
session_start();
require_once("../../php/conect_database.php");

$username=$_POST['userID'];
$password = md5(sha1($_POST['password']));




if (isset($_POST['userID']) && isset($_POST['password']) ) {
	$sql="SELECT * FROM `admin` WHERE  `username`='$username' AND `admin_pass`='$password' ";
	$result=mysqli_query($connect,$sql);

	if(mysqli_num_rows($result) > 0)
	{
		$_SESSION['adminId']=$username;
		$_SESSION['password']=$password;
		header("location: ../index.php?Successfully_Login");
	}
	else
	{
		header("location:../index.php?Login_Failed");
	}
}else {
	header("location:../index.php?TryAgain");
}

?>
