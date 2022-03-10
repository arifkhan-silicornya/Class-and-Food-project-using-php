<?php
session_start();
$userID=$_SESSION['userid'];
require_once("conect_database.php");

if (isset($_POST['picture_file'])) {
    $uploads_dir = "../assets/img/profilePicture/";
    $tmp_name = $_FILES["avatar_file"]["tmp_name"];
    $name =md5($_FILES["avatar_file"]["name"]);
    $uniqName = $name.uniqid();
    $moveToFolder = move_uploaded_file($tmp_name, "$uploads_dir/$uniqName.jpg");
    if ($moveToFolder ==true)
        {
            $sql="UPDATE `users` SET `profile_picture`='$uniqName'  WHERE `studentid`='$userID' ";
            $result=mysqli_query($connect,$sql); 

        if ($result == true){
            header("location:../dashboard.php?imageUploaded");
        } 
    }
    else{
            header("location:../dashboard.php?error :".mysqli_error($sql));
        }
}



?>