<?php
session_start();
require_once ("pages/classes.php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Site 3. Shop</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!--    <link rel="stylesheet" href="css/bootstrap.min.css">-->

<!--    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
<!--    <script-->
<!--            src="https://code.jquery.com/jquery-3.5.1.js"-->
<!--            integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="-->
<!--            crossorigin="anonymous"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <!--    <script src="css/jquery-3.5.1.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!--    <script src="js/jquery_cookie.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
<!--        <script src="css/bootstrap.min.js"></script>-->

</head>
<body class="bg-warning">
<div class="container-fluid">
    <div class="row">
        <header class="col-12 my-4">
            <?php
            include_once ("pages/login.php");
            ?>
        </header>
    </div>
    <div class="row">
        <nav class="col-12 nav-fill  bg-info w-100 text-black" style="color: white!important;">
            <?php
            include_once ("pages/menu.php");
            ?>

        </nav>
    </div>
    <div class="row">
        <section class="col-12 my-5">
            <?php
            if (isset($_GET['page'])){
                $page=$_GET['page'];
                if ($page==1)include_once ("pages/catalog.php");
                if ($page==2)include_once ("pages/cart.php");
                if ($page==3)include_once ("pages/registration.php");
                if ($page==4)include_once ("pages/admin.php");

            }
            ?>
        </section>
    </div>



    <footer class=" p-2 row bg-info justify-content-center text-white text-center">
        Step Academy &copy; by Mikhail Panferov 2020
    </footer>
</div>









</body>
</html>
