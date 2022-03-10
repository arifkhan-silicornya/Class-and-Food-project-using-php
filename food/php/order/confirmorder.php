<?php 
session_start();

require_once("../conect_database.php");
$userid = $_SESSION['userid'];

if (isset($_REQUEST['order_id']) && isset($_POST['codenumber']) && isset($_REQUEST['code'])) {
    $order_id = $_REQUEST['order_id'];
    $codenumber = $_POST['codenumber'];
    $code = $_REQUEST['code'];
    if ($codenumber == $code) {
        $check = "SELECT * FROM `orders` WHERE `order_id` = '$order_id' AND `customer_id` = '$userid' AND `status` = 'processing' ";
        $Result=mysqli_query($connect,$check);  
        if ($Result == true) {
            $UPDATE = "UPDATE `orders` SET `status` = 'confirmed' WHERE `order_id`= '$order_id' AND `customer_id` ='$userid' ";
            $Result_update=mysqli_query($connect,$UPDATE);
            if ($Result_update == true) {
                header("location: ../../dashboard.php?orderConfirmed");        
            }else {
                header("location: ../../dashboard.php?orderNotConfirmed");        
            }
        }else {
            header("location: ../../dashboard.php?orderNotFound");        
        }
    }else {
        header("location: ../../dashboard.php?enteredWrongCode");        
    }
}else {
    header("location: ../../dashboard.php?tryAgain");    
}




?>