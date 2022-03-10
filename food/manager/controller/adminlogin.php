<?php
session_start();
require_once("../../php/conect_database.php");

$manager_id=$_POST['userID'];
$password =$_POST['password'];




if (isset($_POST['userID']) && isset($_POST['password']) ) {
	$sql="SELECT * FROM `manager` WHERE  `manager_id`='$manager_id' AND `password`='$password' ";
	$result=mysqli_query($connect,$sql);

	if(mysqli_num_rows($result) > 0)
	{
		$_SESSION['managerId']=$manager_id;
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
