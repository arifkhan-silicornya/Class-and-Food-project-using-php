<?php
session_start();


if(isset(($_SESSION["userid"])))
{		
	$_SESSION["countproduct"] = 0;
	unset($_SESSION["countproduct"]);
	unset($_SESSION["userid"]);
	header("location:../index.php");
}


?>