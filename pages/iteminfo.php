<?php
session_start();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Item Info</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!--    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
    <!--    <script-->
    <!--            src="https://code.jquery.com/jquery-3.5.1.js"-->
    <!--            integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="-->
    <!--            crossorigin="anonymous"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <!--    <script src="css/jquery-3.5.1.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="../js/jquery_cookie.js"></script>
    <!--        <script src="css/bootstrap.min.js"></script>-->

</head>
<body class="bg-warning">
<?php
include_once ('classes.php');
$pdo=Tools::connect();
if(isset($_GET['name'])) {
    $productID = $_GET['name'];

    $ps=$pdo->prepare("select * from items where id=?");
    $ps->execute([$productID]);
while ($row=$ps->fetch()) {
    echo "<h1 class='text-center'>Карточка товара :</h1>";
    echo "<h1 class=' text-info text-center ' style='font-size: 4rem;'>{$row['itemname']}</h1>";

echo "<h3 class='text-center'>Товар куплен :</h3>";
    echo "<h4 class='text-center text-info'>{$row['pricein']}</h4>";
    echo "<h3 class='text-center'>Товар продан :</h3>";
    echo "<h4 class='text-center text-info'>{$row['pricesale']}</h4>";
    echo "<h3 class='text-center'>Фотография товара :</h3>";
    echo "<div class='text-center'><img src='../{$row['imagepath']}' alt='photo' class='img-fluid' style='max-width: 400px;'></div>";
    echo "<h3 class='text-center'>Описание товара :</h3>";
    echo "<h4 class='text-center text-info'>{$row['info']}</h4>";
    echo "<h3 class='text-center'>Рейтинг товара :</h3>";
    echo "<h4 class='text-center text-info'>{$row['rate']}</h4>";

   // $item = new Item($row['itemname'], $row['catid'], $row['pricein'], $row['pricesale'], $row['info'], $row['imagepath'], $row['rate'], $row['action'], $row['id']);
}



}
?>








</body>
</html>
