<?php

require_once("../../php/conect_database.php");

if (isset($_REQUEST['password']) &&  isset($_REQUEST['password2']) &&   isset($_REQUEST['id'])) {
    
    $id = htmlentities($_REQUEST['id']);

    $newPass = md5(sha1($_REQUEST['newPass']));
    $newPass2 = md5(sha1($_REQUEST['newPass2']));

    if ($newPass == $newPass2) {
        $sql="UPDATE `users` SET `password` = '$newPass'  WHERE `id`='$id' ";
        $result=mysqli_query($connect, $sql);
        if ($result == true) {
            header("location:../manageCustomer.php?userPasswordchanged");
        } else {
            header("location:../manageCustomer.php?error :".mysqli_error($sql));
        }
    } else {
        header("location:../manageCustomer.php?RetypePasswordNotMatched");
    }
}
?>