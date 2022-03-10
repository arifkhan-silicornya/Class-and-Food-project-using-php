<?php
session_start();
$userID=$_SESSION['managerId'];
require_once("../../php/conect_database.php");

if (isset($_POST['pic_file'])) {
    $uploads_dir = "../image/profilePicture/";
    $tmp_name = $_FILES["adminPro"]["tmp_name"];
    $name1 = ($_FILES["adminPro"]["name"]);
    $name = md5($name1);
    $uniqName = $name.uniqid();
    $moveToFolder = move_uploaded_file($tmp_name, "$uploads_dir/$uniqName.jpg");
    if ($moveToFolder == true)
        {
            $sql="UPDATE `manager` SET `profile_pic`='$uniqName'  WHERE `manager_id`='$userID' ";
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