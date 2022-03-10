<?php 
session_start();

require_once("../conect_database.php");
$userid = $_SESSION['userid'];
$totalTtk = 0;
$payment_type = $_REQUEST['payment_type'];

if (isset($_REQUEST['order_id'])) {
    $order_id = $_REQUEST['order_id'] ;
    $check = "SELECT * FROM `orders` WHERE `order_id` = '$order_id' AND `customer_id` = '$userid' AND `status` = 'processing' ";
    $Result=mysqli_query($connect,$check);

    if ($Result == true) {
        $UPDATE = "UPDATE `orders` SET `status` = 'cancel' WHERE `order_id`= '$order_id' AND `customer_id` ='$userid' ";
        $Result_update=mysqli_query($connect,$UPDATE);
        if ($Result_update == true) {
            $selecetOrder = "SELECT * FROM `order_details` WHERE `order_id` = '$order_id' ";
            $Result_selecetOrder=mysqli_query($connect,$selecetOrder);
            if ($Result_selecetOrder == true) {
                while($row=mysqli_fetch_array($Result_selecetOrder)){ 
                    $item_id = $row['item_id'];
                    $quantity = $row['quantity'];
                    $totalTtk = $totalTtk + $row['totalprice'];
                    
                    $itemSearch = "SELECT * FROM `products` WHERE `id` = '$item_id' ";
                    $Result_itemSearch=mysqli_query($connect,$itemSearch);
                    if ($Result_itemSearch == true) {
                        while($row2=mysqli_fetch_array($Result_itemSearch)){ 
                            $pro_quantity = $row2['pro_quantity'];
                            $pro_quantity = $pro_quantity + $quantity;

                            $quantity_update= "UPDATE `products` SET `pro_quantity`='$pro_quantity' WHERE `id` = '$item_id' ";
                            mysqli_query($connect, $quantity_update);
                        }
                    }
                }
                if ($payment_type == "balance") {
                    $searchActiveUser = "SELECT * FROM `user_account` WHERE `disabled` ='0' AND `user_institute_id` = '$userid' ";
                    $checkActiveUser = mysqli_query($connect, $searchActiveUser);
                    
                    if ($checkActiveUser == true) {
                        while ($balanceFetch = mysqli_fetch_array($checkActiveUser)) {
                            $currentBalance =  $balanceFetch['current_money'];
                            $total_Amount  = $totalTtk + $currentBalance ;
                            $user_name =  $balanceFetch['user_name']; 
                            $account_number =  $balanceFetch['id']; 
    
                        }
                        $updateBalance ="UPDATE `user_account` SET `current_money`='$total_Amount'  WHERE `user_institute_id` ='$userid' " ;
                        
                        $balanceUpdated = mysqli_query($connect, $updateBalance);

                        if ($balanceUpdated == true) {
                            header("location: ../../dashboard.php?youCancelYourOrder");
                        }else {
                            header("location:../dashboard.php?Operation_Not_Allowed");
                        }
                    }else {
                        header("location:../dashboard.php?User_Not_Active");
                    }
                }else {
                    header("location: ../../dashboard.php?youCancelYourOrder");
                }
            }else {
                header("location: ../../dashboard.php?OrderDetailsNotFound");    
            }
        }else {
            header("location: ../../dashboard.php?orderStatusNotUpdated");
        }
    }else {
        header("location: ../../dashboard.php?operationFailed");
    }
}
?>