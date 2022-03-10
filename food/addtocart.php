<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>home</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css?h=1f8afc18ec3ce05d9a2e38380bd93365">
    <style>
        .bg-color{
            /* background: radial-gradient(circle,#0075b9 0,#002c5d 100%); */
            background: radial-gradient(circle,#0a3769 0,#000000 100%)!important;
        }
    </style>
</head>
<body >
<!-- ......................header file included..................... -->
<?php include 'header.php';?>
<?php


$total = 0;


if (isset($_SESSION['userid'])) {
    
$user_id=$_SESSION['userid'];
$sql="SELECT * FROM `users` WHERE `studentid`='$user_id'";
$Result=mysqli_query($connect,$sql);
 
while($row=mysqli_fetch_array($Result))
    { 
        $uerName=$row['username'];
        $address=$row['address']; 
        $user_role=$row['user_role']; 
    }
}


//   ============  for add to cart Start==============
 if(isset($_POST["add_to_cart"]))
{
	if(isset($_SESSION["shopping_cart"]))
	{
		$item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
		if(!in_array($_GET["id"], $item_array_id))
		{
        $_SESSION["countproduct"]  ++;
		$count = count($_SESSION["shopping_cart"]);
		$item_array = array(
            'item_id'	    	=>	$_GET["id"],
            'item_image'		=>	$_GET["image_product"],
            'item_name'		    =>	$_GET["pro_name"],
            'item_price'		=>	$_GET["pro_price"],
            'item_quantity'		=>	$_POST["quantity"]
		);
        $_SESSION["shopping_cart"][$count] = $item_array;
        header("location:home.php?addedNewItem");
		}
		else
		{
		    header("location:home.php?ItemAlreadyAdded");
		}
	}
	else
	{   
        
        $_SESSION["countproduct"] = 0;
        $_SESSION["countproduct"] ++;

		$item_array = array(
            'item_id'		=>	$_GET["id"],
            'item_image'	=>	$_GET["image_product"],
            'item_name'		=>	$_GET["pro_name"],
            'item_price'	=>	$_GET["pro_price"],
            'item_quantity'	=>	$_POST["quantity"]
		);
        $_SESSION["shopping_cart"][0] = $item_array;
        header("location:home.php?addedNewItem");
	}
}
 
if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $keys => $values)
		{
		if($values["item_id"] == $_GET["id"])
		{
        $_SESSION["countproduct"] --;
		unset($_SESSION["shopping_cart"][$keys]);
		header("location:addtocart.php?Deleted");
		}
		}
	}
}
//   ============  for add to cart End==============
?>

<div class="container  py-5 ">
    
    <div class="py-2 pl-1 font-weight-bold border border-info text-center text-info" style="font-size:30px; ">
      Add to cart
    </div>
    <form action="php/order/placeorder.php" method="post" >
        <div class="d-md-flex flex-md-row">
            <div class="col-md-6 m-0 p-0 border border-info w-100" style="font-size:13px;width:100%;">
                <table class="table table-stripped w-100">
                    <thead class="bg-info w-100 pr-0" style="width:100%!important;">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Image</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="border border-info">
                    <?php
                if(!empty($_SESSION["shopping_cart"]))
                {
                
                foreach($_SESSION["shopping_cart"] as $keys => $values)
                { 
                ?>
                        <tr style="border-bottom : 2px solid  #17a2b8;">
                            <td><?php echo $values["item_name"]; ?></td>
                            <td><img src="assets/img/product/<?php echo $values["item_image"];?>.jpg" alt="Product_image" class="img-fluid mx-auto p-0 m-0" style="height:60px;width:60px;"></td>
                            <td><?php echo $values["item_price"]; ?> tk</td>
                            <td><?php echo $values["item_quantity"]; ?></td>
                            <td><?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
                            <td><a href="addtocart.php?action=delete&id=<?php echo $values["item_id"]; ?>">Remove</a></td>
                        </tr>
                        </tr>
                <?php
                $total = $total + ($values["item_quantity"] * $values["item_price"]);
                }
                ?>
                <tr>
                <td colspan="4" class="text-center text-md-right font-weight-bold">Total : </td>
                <td colspan="2" class="float-left">$ <?php echo number_format($total, 2); ?></td>
                <td></td>
                </tr>
                <?php
                }
                ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6 m-0 p-0 border border-info p-2">
                <div class="form-group">
                    <input class="form-control border border-info" type="text" required placeholder="Enter Full Name" name="username" value="<?php echo $uerName;?>" readonly>
                </div>
                <div class="form-group">
                    <input class="form-control border border-info" type="number" required placeholder="Eenter Your ID" name="studentID" value="<?php echo $user_id;?>" readonly>
                </div> 
                <div class="form-group">
                    <input class="form-control border border-info" type="text" required placeholder="User Type" name="userType" value="<?php echo $user_role;?>" readonly>
                </div> 
                <div class="form-group">
                    <input class="form-control border border-info" type="text" required placeholder="Delivery Addres" name="deliveryAddres" value="<?php echo $address;?>">
                </div> 
                <label >Payment Method :</label>
                <div class="form-group " >
                    <input type="radio" required name="paymentMethod" Value="balance" class="ml-2 p-3" id="Radioinput">
                    <label class="ml-2 font-weight-bold " id="Radiolabel1">Balance </label><br>
                    <label id="show_low_msg" class="text-danger font-weight-bold pl-2" style="display:none;">Disabled Balance For Low Balance</label>
                    <input type="radio" required name="paymentMethod" Value="cod"  class="ml-2 p-3" >
                    <label class="ml-2 font-weight-bold ">Cash On Delivery </label>
                </div>
                <div class="text-center text-danger font-weight-bold border border-danger">Current Balance : <?php echo $current_money; ?></div> 
            </div>
        </div>
        <?php if ($total > 0 ) {
            echo ' <input type="submit" name="ConfirmOrder" class="btn btn-lg btn-outline-danger w-100 font-weight-bold d-block mt-1" value="Confirm Order " > ' ;
            if ($current_money < $total) {
                echo "
                <script>
                    window.alert('Low Balance');
                    document.getElementById('Radioinput').style.display='none'; 
                    document.getElementById('Radiolabel1').style.display='none'; 
                    document.getElementById('show_low_msg').style.display='block'; 
                </script>
                ";
            }
        }
        else{
            echo '<input type="submit" name="ConfirmOrder" class="btn btn-lg btn-outline-danger w-100 font-weight-bold d-block mt-1" value="Confirm Order "  disabled> ' ;
            
            echo "
            <script>
            window.alert('Empty Cart'); 
            </script>
            ";
        }?>


    </form>
</div>
<!-- $current_money -->


<div>

<!-- ......................footer file included..................... -->
<?php include 'footer.php';?>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.min.js?h=43583f9c06d57d8535a11a9e2f5a6a7c"></script>
</body>

</html>