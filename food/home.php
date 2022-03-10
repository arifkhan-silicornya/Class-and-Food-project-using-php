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
        @media screen and (max-width: 767px) {
            .search_cat_home{
                width : 100%!important;
            }
        }
        @media screen and (min-width: 768px) {
            .search_cat_home{
                width : 60%!important;
            }
        }
    </style>
</head>
<body >
<!-- ......................header file included..................... -->
<?php include 'header.php';?>

    <div class="text-dark text-center font-weight-bold bg-warning" style="font-size:2vw;margin-top:-48px;">
        <?php
            $_SESSION["doCancel"] = 0;
            if (isset($_REQUEST['yourOrderProcessing'])) {
                $_SESSION["doCancel"] = 1;
            }
            if (isset($_REQUEST['AddNewItem'])) {
                echo 'Add New Item';
            }
            if (isset($_REQUEST['addedNewItem'])) {
                echo 'Nice ! You Added an Item, To Confirm Your Order Go To Cart ';
            }
            if (isset($_REQUEST['ItemAlreadyAdded'])) {
                echo 'Add Another Item Or Delete This Item From Cart. Then Add Again';
            }
            
            $user_id = $_SESSION['userid'];
            $checkPreviousOrder = "SELECT `status` FROM `orders` WHERE `status` ='processing' AND `customer_id` = '$user_id' " ;
            $runquery_checkPreviousOrder = mysqli_query($connect, $checkPreviousOrder);
            if (mysqli_fetch_array($runquery_checkPreviousOrder) > -1) {
                
                header("location: dashboard.php?YouHadAOrder");
            }

        ?>
    </div>
<div class="container  py-5 text-capitalize">
    <span class="my-1 d-inline-flex flex-row-reverse float-right search_cat_home">
    <span class="btn btn-info" readonly> Search By Category </span>
    <select class="custom-select border border-info" id="selectCategory" onchange="categoryChange();">
        <option value="allCategory">All Category</option>
        <option value="breakfast">Breakfast</option>
        <option value="lunch">Lunch</option>
        <option value="drinks">Drinks</option>
        <option value="dryfood">Dry Food</option>
        <option value="others">Others</option>
    </select>
    </span>
    <!-- First Row [Prosucts]-->
 
<div id="breakfast" style="display:block;">
    <h2 class="font-weight-bold mb-2 text-dark text-capitalize">breakfast</h2>
    <p class="font-italic text-muted mb-4">Breakfast item available till 11.00 A.M</p>
    <div class="row py-2 mb-4 text-white" >
    <?php
        $productQuery = "SELECT * FROM `products` ";
        $pro_qry_Result = mysqli_query($connect, $productQuery);
        while ($row3=mysqli_fetch_array($pro_qry_Result)) {
            $pid=$row3['id'];
            $pro_name=$row3['pro_name'];
            $pro_img_name=$row3['pro_img_name'];
            $pro_quantity=$row3['pro_quantity'];
            $pro_price=$row3['pro_price'];
            $pro_details=$row3['pro_details'];
            $pro_category=$row3['pro_category'];

            if ($pro_category == "breakfast" && $pro_quantity > 0) {
        ?>   
        <div class="col-lg-3 col-md-6 mb-4 mb-lg-1 ">
            <!-- Card-->
            <div class="card rounded shadow-sm border-0 bg-color text-white">
                <div class="card-body p-3 d-flex flex-column text-white">
                    <img src="assets/img/product/<?php echo $pro_img_name ; ?>.jpg" alt="Product_image" class="img-fluid d-block mx-auto border border-light mb-3" style="height:150px;width:220px;">
                    <h5 class=" "> <?php echo $pro_name  ; ?> </h5>
                    <p class=" ">Price : <?php echo $pro_price  ; ?>tk</p>
                    <p class="small font-italic m-0 mb-1 ">Stock : <?php echo $pro_quantity  ; ?> </p>
                    <p class="small font-italic m-0 mb-1 ">Details : <?php echo $pro_details  ; ?> </p>
                    <form action="addtocart.php?action=add&id=<?php echo $pid; ?>&image_product=<?php echo $pro_img_name; ?>&pro_name=<?php echo $pro_name; ?>&pro_price=<?php echo $pro_price; ?>" method="POST">
                        <div class="form-group">
                            <input class="form-control border border-info m-0" type="number" min="1" placeholder="Quantity" name="quantity" required><br>
                            <input type="submit" name="add_to_cart" class="btn btn-outline-light w-100" value="Add to Cart" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

<?php
    }
}

?>
    </div>
</div>
                                <!-- End of first row -->

    

    <!-- 2nd Row [Prosucts]-->
<div id="lunch" style="display:block;">
    <h2 class="font-weight-bold mb-2 text-dark">Lunch</h2>
    <p class="font-italic text-muted mb-4">Lunch item available till 3.00 P.M</p>
    <div class="row py-2 mb-4 text-white" >
    <?php
        $productQuery = "SELECT * FROM `products` ";
        $pro_qry_Result = mysqli_query($connect, $productQuery);
        while ($row3=mysqli_fetch_array($pro_qry_Result)) {
            $pid=$row3['id'];
            $pro_name=$row3['pro_name'];
            $pro_img_name=$row3['pro_img_name'];
            $pro_quantity=$row3['pro_quantity'];
            $pro_price=$row3['pro_price'];
            $pro_details=$row3['pro_details'];
            $pro_category=$row3['pro_category'];

            if ($pro_category == "lunch" && $pro_quantity > 0) {
        ?>   
        <div class="col-lg-3 col-md-6 mb-4 mb-lg-1 ">
            <!-- Card-->
            <div class="card rounded shadow-sm border-0 bg-color text-white">
                <div class="card-body p-3 d-flex flex-column text-white">
                    <img src="assets/img/product/<?php echo $pro_img_name ; ?>.jpg" alt="Product_image" class="img-fluid d-block mx-auto border border-light mb-3" style="height:150px;width:220px;">
                    <h5 class=" "> <?php echo $pro_name  ; ?> </h5>
                    <p class=" ">Price : <?php echo $pro_price  ; ?>tk</p>
                    <p class="small font-italic m-0 mb-1 ">Stock : <?php echo $pro_quantity  ; ?> </p>
                    <p class="small font-italic m-0 mb-1 ">Details : <?php echo $pro_details  ; ?> </p>
                    <form action="addtocart.php?action=add&id=<?php echo $pid; ?>&image_product=<?php echo $pro_img_name; ?>&pro_name=<?php echo $pro_name; ?>&pro_price=<?php echo $pro_price; ?>" method="POST">
                        <div class="form-group">
                            <input class="form-control border border-info m-0" type="number" min="1" placeholder="Quantity" name="quantity" required><br>
                            <input type="submit" name="add_to_cart" class="btn btn-outline-light w-100" value="Add to Cart" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

<?php
    }
}

?>
    </div>
</div>
<!-- end of second row -->
                        
                        
                            <!-- Third Row [Prosucts]-->
<div id="drinks" style="display:block;">
    <h2 class="font-weight-bold mb-2 text-dark">Drinks</h2>
    <p class="font-italic text-muted mb-4">Drinks</p>
    <div class="row py-2 mb-4 text-white" >
    <?php
        $productQuery = "SELECT * FROM `products` ";
        $pro_qry_Result = mysqli_query($connect, $productQuery);
        while ($row3=mysqli_fetch_array($pro_qry_Result)) {
            $pid=$row3['id'];
            $pro_name=$row3['pro_name'];
            $pro_img_name=$row3['pro_img_name'];
            $pro_quantity=$row3['pro_quantity'];
            $pro_price=$row3['pro_price'];
            $pro_details=$row3['pro_details'];
            $pro_category=$row3['pro_category'];

            if ($pro_category == "drinks" && $pro_quantity > 0) {
        ?>   
        <div class="col-lg-3 col-md-6 mb-4 mb-lg-1 ">
            <!-- Card-->
            <div class="card rounded shadow-sm border-0 bg-color text-white">
                <div class="card-body p-3 d-flex flex-column text-white">
                    <img src="assets/img/product/<?php echo $pro_img_name ; ?>.jpg" alt="Product_image" class="img-fluid d-block mx-auto border border-light mb-3" style="height:140px;width:160px;">
                    <h5 class=" "> <?php echo $pro_name  ; ?> </h5>
                    <p class=" ">Price : <?php echo $pro_price  ; ?>tk</p>
                    <p class="small font-italic m-0 mb-1 ">Stock : <?php echo $pro_quantity  ; ?> </p>
                    <p class="small font-italic m-0 mb-1 ">Details : <?php echo $pro_details  ; ?> </p>
                    <form action="addtocart.php?action=add&id=<?php echo $pid; ?>&image_product=<?php echo $pro_img_name; ?>&pro_name=<?php echo $pro_name; ?>&pro_price=<?php echo $pro_price; ?>" method="POST">
                        <div class="form-group">
                            <input class="form-control border border-info m-0" type="number" min="1" placeholder="Quantity" name="quantity" required><br>
                            <input type="submit" name="add_to_cart" class="btn btn-outline-light w-100" value="Add to Cart" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

<?php
    }
}

?>
    </div>
</div>

                                        <!-- End Third Row -->
    <!-- Fourth Row [Prosucts]-->

<div id="dryfood" style="display:block;">
    <h2 class="font-weight-bold mb-2 text-dark">DryFood</h2>
    <p class="font-italic text-muted mb-4">DryFood</p>
    <div class="row py-2 mb-4 text-white" >
    <?php
        $productQuery = "SELECT * FROM `products` ";
        $pro_qry_Result = mysqli_query($connect, $productQuery);
        while ($row3=mysqli_fetch_array($pro_qry_Result)) {
            $pid=$row3['id'];
            $pro_name=$row3['pro_name'];
            $pro_img_name=$row3['pro_img_name'];
            $pro_quantity=$row3['pro_quantity'];
            $pro_price=$row3['pro_price'];
            $pro_details=$row3['pro_details'];
            $pro_category=$row3['pro_category'];

            if ($pro_category == "dryfood" && $pro_quantity > 0) {
        ?>   
        <div class="col-lg-3 col-md-6 mb-4 mb-lg-1 ">
            <!-- Card-->
            <div class="card rounded shadow-sm border-0 bg-color text-white">
                <div class="card-body p-3 d-flex flex-column text-white">
                    <img src="assets/img/product/<?php echo $pro_img_name ; ?>.jpg" alt="Product_image" class="img-fluid d-block mx-auto border border-light mb-3" style="height:150px;width:220px;">
                    <h5 class=" "> <?php echo $pro_name  ; ?> </h5>
                    <p class=" ">Price : <?php echo $pro_price  ; ?>tk</p>
                    <p class="small font-italic m-0 mb-1 ">Stock : <?php echo $pro_quantity  ; ?> </p>
                    <p class="small font-italic m-0 mb-1 ">Details : <?php echo $pro_details  ; ?> </p>
                    <form action="addtocart.php?action=add&id=<?php echo $pid; ?>&image_product=<?php echo $pro_img_name; ?>&pro_name=<?php echo $pro_name; ?>&pro_price=<?php echo $pro_price; ?>" method="POST">
                        <div class="form-group">
                            <input class="form-control border border-info m-0" type="number" min="1" placeholder="Quantity" name="quantity" required><br>
                            <input type="submit" name="add_to_cart" class="btn btn-outline-light w-100" value="Add to Cart" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

<?php
    }
}

?>
    </div>
</div>
                                        <!-- end Forth row -->

    <!-- Five Row [Prosucts]-->
<div id="others" style="display:block;">
    <h2 class="font-weight-bold mb-2 text-dark">Others</h2>
    <p class="font-italic text-muted mb-4">Others</p>
    <div class="row py-2 mb-4 text-white" >
    <?php
        $productQuery = "SELECT * FROM `products` ";
        $pro_qry_Result = mysqli_query($connect, $productQuery);
        while ($row3=mysqli_fetch_array($pro_qry_Result)) {
            $pid=$row3['id'];
            $pro_name=$row3['pro_name'];
            $pro_img_name=$row3['pro_img_name'];
            $pro_quantity=$row3['pro_quantity'];
            $pro_price=$row3['pro_price'];
            $pro_details=$row3['pro_details'];
            $pro_category=$row3['pro_category'];

            if ($pro_category == "others" && $pro_quantity > 0) {
        ?>   
        <div class="col-lg-3 col-md-6 mb-4 mb-lg-1 ">
            <!-- Card-->
            <div class="card rounded shadow-sm border-0 bg-color text-white ">
                <div class="card-body p-3 d-flex flex-column text-white">
                    <img src="assets/img/product/<?php echo $pro_img_name ; ?>.jpg" alt="Product_image" class="img-fluid d-block mx-auto border border-light mb-3" style="height:150px;width:220px;">
                    <h5 class=" "> <?php echo $pro_name  ; ?> </h5>
                    <p class=" ">Price : <?php echo $pro_price  ; ?>tk</p>
                    <p class="small font-italic m-0 mb-1 ">Stock : <?php echo $pro_quantity  ; ?> </p>
                    <p class="small font-italic m-0 mb-1 ">Details : <?php echo $pro_details  ; ?> </p>
                    <form action="addtocart.php?action=add&id=<?php echo $pid; ?>&image_product=<?php echo $pro_img_name; ?>&pro_name=<?php echo $pro_name; ?>&pro_price=<?php echo $pro_price; ?>" method="POST">
                        <div class="form-group">
                            <input class="form-control border border-info m-0" type="number" min="1" placeholder="Quantity" name="quantity" required><br>
                            <input type="submit" name="add_to_cart" class="btn btn-outline-light w-100" value="Add to Cart" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

<?php
    }
}

?>
    </div>
</div>


                            <!-- End Five row -->


</div>

<!-- ......................footer file included..................... -->
<?php include 'footer.php';?>



<script>
    
    var b = document.getElementById("breakfast");
    var c = document.getElementById("lunch");
    var d = document.getElementById("drinks");
    var e = document.getElementById("dryfood");
    var f = document.getElementById("others");
    

    function categoryChange(){
        var a = document.getElementById("selectCategory").value;


        if (a == "allCategory") {
            b.style.display = "block" ;
            c.style.display = "block" ;
            d.style.display = "block" ;
            e.style.display = "block" ;
            f.style.display = "block" ;
            
        }
        else if(a == "breakfast"){
            b.style.display = "block" ;
            c.style.display = "none" ;
            d.style.display = "none" ;
            e.style.display = "none" ;
            f.style.display = "none" ;
        }
        else if(a == "lunch"){
            b.style.display = "none" ;
            c.style.display = "block" ;
            d.style.display = "none" ;
            e.style.display = "none" ;
            f.style.display = "none" ;
        }
        else if(a == "drinks"){
            b.style.display = "none" ;
            c.style.display = "none" ;
            d.style.display = "block" ;
            e.style.display = "none" ;
            f.style.display = "none" ;
        }
        else if(a == "dryfood"){
            b.style.display = "none" ;
            c.style.display = "none" ;
            d.style.display = "none" ;
            e.style.display = "block" ;
            f.style.display = "none" ;
        }
        else{
            b.style.display = "none" ;
            c.style.display = "none" ;
            d.style.display = "none" ;
            e.style.display = "none" ;
            f.style.display = "block" ;
        }
    }





</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.min.js?h=43583f9c06d57d8535a11a9e2f5a6a7c"></script>
</body>

</html>