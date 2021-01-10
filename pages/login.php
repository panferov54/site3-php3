<?php
if (isset($_SESSION['ruser'])){
    echo'<form action="index.php';
    if(isset($_GET['page']))echo "?page=".$_GET['page'];
    echo '" class="input-group" method="post">';
    echo "<h4> Привет, ".$_SESSION['ruser'] ."</h4>";
    $login=$_SESSION['ruser'];
    $pdo=Tools::connect();
    $ps = $pdo->query("SELECT total FROM customers where login='$login'");
    while($row = $ps->fetch()){
        $rt=$row['total'];
        echo "<h3 class='ml-3 text-info'>Всего купленно на :</h3>";
        echo "<div class='bg-info text-center pt-2 ml-3' style='border-radius: 40px;width: 100px;height: 40px;'>$rt $</div>";
    }
    echo '<input type="submit" name="exit" value="Log Out" class="btn btn-danger ml-4">';
    echo '</form>';

    //нажатие кнопки ЛОГ АУТ
    if (isset($_POST['exit'])){
        unset($_SESSION['ruser']);
        unset($_SESSION['radmin']);
        echo '<script> window.location.reload();</script>';
    }

}else{
    echo'<form action="index.php';
    if(isset($_GET['page']))echo "?page=".$_GET['page'];
    echo '" class="input-group" method="post">';
    echo '<input type="text" name="login" placeholder="login">';
    echo '<input type="password" name="pass" placeholder="password" class="ml-3">';
    echo '<input type="submit" name="auth" value="Log IN" class="btn btn-success ml-3">';
    echo'</form>';
    //обработчик логина
    if (isset($_POST['auth'])AND $_POST['pass']!==''AND $_POST['login']!==''){
        $log=Customer::login($_POST['login'],$_POST['pass']);

    }
    if (isset($_POST['auth'])AND $_POST['pass']=='' || $_POST['login']==''){
        echo "<h3 class='text-danger'>Заполните все поля!</h3>";

    }


}