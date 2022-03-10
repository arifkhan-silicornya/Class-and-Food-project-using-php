<?php
session_start();

	unset($_SESSION["exmUserid"]);
	unset($_SESSION["exmUsertype"]);
	header("location:../index.php");



?>