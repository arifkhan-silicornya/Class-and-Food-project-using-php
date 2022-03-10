<?php 
require_once("../../php/conect_database.php");

   
   $User_id  = htmlentities($_POST['User_id']);
   $rechrg_Amount  = htmlentities($_POST['rechrg_Amount']);
   $pinNumber  = htmlentities($_POST['pinNumber']); 
   $userType  = htmlentities($_POST['userType']); 

   

if (empty($User_id)) {
    header("location:../dashboard.php?User_Not_Found");
}
else{
    if ($pinNumber== "12345") {
        if (isset($_POST['User_id']) && isset($_POST['rechrg_Amount']) && isset($_POST['rechrg_Amount']) && isset($_POST['userType'])) {
            $searchActiveUser = "SELECT * FROM `user_account` WHERE `disabled` ='0' AND `user_institute_id` = '$User_id' ";
            $checkActiveUser = mysqli_query($connect, $searchActiveUser);
            while ($balanceFetch =mysqli_fetch_array($checkActiveUser)) {
                $currentBalance =  $balanceFetch['current_money'];
                $total_Amount  = $rechrg_Amount + $currentBalance ;
                $user_name =  $balanceFetch['user_name']; 
                $account_number =  $balanceFetch['id']; 

            }
            
            if ($checkActiveUser == true) {
                $updateBalance =" UPDATE `user_account` SET `current_money`='$total_Amount'  WHERE `user_institute_id` ='$User_id' " ;

                $rechargeHistory ="INSERT INTO `recharge_users` (`id`, `user_name`, `user_id`, `user_role`, `account_number`, `amount`) 
                VALUES (NULL, '$user_name', '$User_id', '$userType', '$account_number', '$rechrg_Amount')" ;

                
                $balanceUpdated = mysqli_query($connect, $updateBalance);

                $historyCreated = mysqli_query($connect, $rechargeHistory);

                if ($balanceUpdated == true) {
                    header("location:../dashboard.php?Recharge_succesful");
                }
                else {
                    header("location:../dashboard.php?Operation_Not_Allowed");
                }
            }
            else {
                header("location:../dashboard.php?User_Not_Active");
            }

        } else {
            header("location:../dashboard.php?operation_Failed");
        }
    }
    else {
        header("location:../dashboard.php?Wrong_Pin_Number");
    }
}

?>