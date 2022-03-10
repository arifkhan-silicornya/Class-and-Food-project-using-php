<?php
session_start();
$userID=$_SESSION['userid'];


require_once("conect_database.php");

$sql="SELECT * FROM `users` WHERE `studentid`='$userID' ";
$result=mysqli_query($connect,$sql);
while($row=mysqli_fetch_array($result))
    { 
    $dbpassword=$row['password'];
    }

$oldPass = md5(sha1($_REQUEST['oldPass']));
$newPass = md5(sha1($_REQUEST['newPass']));
$newPass2 = md5(sha1($_REQUEST['newPass2']));


if ($dbpassword != $oldPass) {
    
    header("location:../dashboard.php?passwordNotMatch");
}
else{
   if($newPass == $newPass2 ){
    $sql="UPDATE `users` SET `password`='$newPass'  WHERE `studentid`='$userID' ";
    $result=mysqli_query($connect,$sql);
    
    
    if($result === TRUE)
       {
        header("location:../dashboard.php?passwordChanged");
        } 
    else {
            header("location:../dashboard.php?error :".mysqli_error($sql));
            
        }
    }
    else{
        header("location:../dashboard.php#changePassword?failed");
    }
}





?>