<?php 
session_start();

require_once("../conect_database.php");



// user info
$userType  = htmlentities($_POST['userType']);
$username = htmlentities($_POST['username']);
$studentID  = htmlentities($_POST['studentID']);
$deliveryAddres = htmlentities($_POST['deliveryAddres']);
$paymentMethod = htmlentities($_POST['paymentMethod']);

$lowItemcount = 0 ;
$total = 0;
// ==== check for availble product Start=====
foreach ($_SESSION["shopping_cart"] as $keys => $values) {
    
    $item_id = $values["item_id"];
    $item_price = $values["item_price"];
    $item_quantity = $values["item_quantity"];

    
    $total = $total + ($values["item_quantity"] * $values["item_price"]);

    $runIntoProduct = "SELECT * FROM `products` WHERE `id` = '$item_id' " ;
    $runProductTable = mysqli_query($connect, $runIntoProduct);
    if ($runProductTable == true) {
        while ($row=mysqli_fetch_array($runProductTable)) {
            $quantity_table=$row['pro_quantity'];
            if ($quantity_table < $item_quantity) {
                $lowItemcount ++ ;
                // header("location: ../../addtocart.php?sryStockLow");
            }
        }
    }
}
// ==== check for availble product End=====

if (!empty($_SESSION["shopping_cart"]) ) {
    
    if ($paymentMethod == "balance") {
        if ($lowItemcount == 0) {
            $createtOrderstable = "INSERT INTO `orders` (`customer_id`, `customer_name`, `usertype`, `address`, `payment_type`, `total`, `status`)
            VALUES ('$studentID', '$username', '$userType', '$deliveryAddres', '$paymentMethod', '$total', 'processing')";
            $runCreatetOrderstable = mysqli_query($connect, $createtOrderstable);

            foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                $item_id = $values["item_id"];
                $item_price = $values["item_price"];
                $item_quantity = $values["item_quantity"];

                $subTotalPrice = $item_price * $item_quantity;
            
                $runIntoProduct = "SELECT * FROM `products` WHERE `id` = '$item_id' " ;
                $runProductTable = mysqli_query($connect, $runIntoProduct);
                if ($runProductTable == true ) {
                    while ($row=mysqli_fetch_array($runProductTable)) {
                        $quantity_table=$row['pro_quantity'];
                        $quantity_table = $quantity_table - $item_quantity;

                        $quantity_update= "UPDATE `products` SET `pro_quantity`='$quantity_table' WHERE `id` = '$item_id' ";
                        mysqli_query($connect, $quantity_update);
                    }
                    $takeOrderID = "SELECT * FROM `orders` WHERE `customer_id` = '$studentID' AND `status` = 'processing' " ;
                    $runTakeOrderID = mysqli_query($connect, $takeOrderID);
                    if ($runTakeOrderID == true) {
                        while ($fetch_order_id = mysqli_fetch_array($runTakeOrderID)) {
                            $order_id = $fetch_order_id['order_id'];
                        }
                        
        
                        $insertOrder_details= "INSERT INTO `order_details` (`customer_id`,`order_id`,`item_id`,`quantity` ,`price`, `totalprice`)
                        VALUES('$studentID','$order_id','$item_id','$item_quantity','$item_price','$subTotalPrice')";
                        mysqli_query($connect, $insertOrder_details);

                    }
                }
            }
            $checkBalance = "SELECT * FROM `user_account` WHERE `user_institute_id` = '$studentID' " ;
            $runCheckBalance = mysqli_query($connect, $checkBalance);
            if ($runCheckBalance == true) {
                while ($row6=mysqli_fetch_array($runCheckBalance)) {
                    $current_money = $row6['current_money'];
                }
                $current_money = $current_money - $total ;
                $AccountBalanceUpdate= "UPDATE `user_account` SET `current_money`='$current_money' WHERE `user_institute_id` = '$studentID' ";
                $runAccountBalanceUpdate = mysqli_query($connect, $AccountBalanceUpdate);
                if ($runAccountBalanceUpdate == true) {
                    $_SESSION["countproduct"] = 0;
                    unset($_SESSION["shopping_cart"]);
                    header("location: ../../home.php?yourOrderProcessing");
                } else {
                    header("location: ../../home.php?systemFailed");
                }
            } else {
                header("location: ../../addtocart.php?userAccountNotFound");
            }
        }else {
            header("location: ../../addtocart.php?StockLow");
        }

    }else {
        if ($lowItemcount == 0) {
            $createtOrderstable = "INSERT INTO `orders` (`customer_id`, `customer_name`, `usertype`, `address`, `payment_type`, `total`, `status`)
            VALUES ('$studentID', '$username', '$userType', '$deliveryAddres', '$paymentMethod', '$total', 'processing')";
            $runCreatetOrderstable = mysqli_query($connect, $createtOrderstable);

            foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                $item_id = $values["item_id"];
                $item_price = $values["item_price"];
                $item_quantity = $values["item_quantity"];
        
                $runIntoProduct = "SELECT * FROM `products` WHERE `id` = '$item_id' " ;
                $runProductTable = mysqli_query($connect, $runIntoProduct);
                if ($runProductTable == true) {
                    while ($row=mysqli_fetch_array($runProductTable)) {
                        $quantity_table = $quantity_table - $item_quantity;

                        $quantity_update= "UPDATE `products` SET `pro_quantity`='$quantity_table' WHERE `id` = '$item_id' ";
                        $runquery17 = mysqli_query($connect, $quantity_update);
                    }
                    if ($runCreatetOrderstable == true) {
                        $takeOrderID = "SELECT * FROM `orders` WHERE `customer_id` = '$studentID' AND `status` = 'processing' " ;
                        $runTakeOrderID = mysqli_query($connect, $takeOrderID);
                        if ($runTakeOrderID == true) {
                            while ($fetch_order_id = mysqli_fetch_array($runTakeOrderID)) {
                                $order_id = $fetch_order_id['order_id'];
                            }
                            foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                                $item_id = $values["item_id"];
                                $item_price = $values["item_price"];
                                $item_quantity = $values["item_quantity"];
                                $subTotalPrice = $item_price * $item_quantity;
            
                                $insertOrder_details= "INSERT INTO `order_details` (`customer_id`,`order_id`,`item_id`,`quantity` ,`price`, `totalprice`)
                                VALUES('$studentID','$order_id','$item_id','$item_quantity','$item_price','$subTotalPrice')";

                                $runinsertOrder_details = mysqli_query($connect, $insertOrder_details);
                                if ($runinsertOrder_details == false) {
                                    header("location: ../../addtocart.php?orderListCreationFailed");
                                }
                            }
                            $_SESSION["countproduct"] = 0;
                            unset($_SESSION["shopping_cart"]);
                            header("location: ../../home.php?yourOrderProcessing");
                        } else {
                            header("location: ../../home.php?failed");
                        }
                    } else {
                        header("location: ../../addtocart.php?orderCreateFailed");
                    }
                } else {
                    header("location: ../../addtocart.php?ProductNotFound");
                }
            }
        }else {
            header("location: ../../addtocart.php?StockLow");
        }
    }
}
else {
    header("location: ../../addtocart.php?yourcartempty");
}
?>