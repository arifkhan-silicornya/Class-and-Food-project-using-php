<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" >

    <title>main page!</title>
  </head>
  <body>
    <div class="container bg-light">
        <h1 class="h1 text-center mb-0 " style="font-size: 80px;">WELCOME</h1> 
        <h6 class="text-center">ABC International University</h6>
        <div class="row d-flex justify-content-center align-items-center align-self-center " style="height: 100vh;"> 
            <div class="box1 border border-success m-1 bg-white" style="max-width: 18rem;">
                <div class="card-body">
                    <a href="food/index.php"><img src="image/food.jpg" alt="img" class="img-fluid"></a>
                </div>
                <div class="card-footer bg-success">
                    <div class="text-center">Food</div>
                </div>
            </div>
            <div class="box2 border border-dark m-1 bg-white" style="max-width: 18rem;">
                <div class="card-body">
                    <a href="exam/index.php"><img src="image/exam.jpg" alt="img" class="img-fluid"></a>
                </div>
                <div class="card-footer bg-dark">
                    <div class="text-center text-light">Class</div>
                </div>
            </div>
            <div class="box3 border border-info m-1 bg-white" style="max-width: 18rem;">
                <div class="card-body">
                    <a onclick="alert('You can see only class and food part')" href="#"><img src="image/social.jpeg" alt="img" class="img-fluid"></a>
                </div>
                <div class="card-footer bg-info">
                    <div class="text-center">Social</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" ></script>
  </body>
</html>