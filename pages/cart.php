<h4>Корзина</h4>
<?php
echo '<form action="index.php?page=2" method="post">';
$total=0;

foreach ($_COOKIE as $k=>$v){
    if(substr($k,0,strpos($k,"_"))==='cart'){
       $id=substr($k,strpos($k,"_")+1);
       $item=Item::fromDb($id);
        $total+=$item->pricesale;
    //    $rezerv=$item->rezerv-1;
        $item->drawItemCart();

    }


}
echo '<hr>';
echo "<span class='ml-5 text-primary'>Total Price: $total $</span>";
echo "<button type='submit' class='btn  btn-primary btn-lg ml-5' name='suborder' onclick=eraseAllCookie() >Отправить заказ</button>";

echo '</form>';


//обработчик для оформления заказов
if(isset($_POST['suborder'])){
    $id_result = [];
    $quan = $_POST['quantity'];

    foreach ($_COOKIE as $k =>$v){
       if(substr($k,0,strpos($k,"_"))==='cart'){
           $id = substr($k, strpos($k, "_") + 1);
           $item = Item::fromDb($id);
           array_push($id_result, $item->sale($quan));

       }

    }

    Item::SMTP($id_result);
    echo "<h1 class='text-info'>Заказ успешно оформлен</h1>";




}
?>
<script>
    function eraseCookie(ruser){
        $.removeCookie(ruser,{path:'/'});
    }

    // function eraseAllCookie() {
    //
    //     let allCookies = $.cookie(); // по документации jquery cookie таким образом мы можем получить все куки файлы
    //     let allCookiesKeys = Object.keys(allCookies); // allCookies это объект, я получаю все ключи из него в виде массива
    //     allCookiesKeys.forEach(function(item)  { // перебираю массив
    //         if(item.includes('cart')) { // нахожу все, в которых упоминается cart
    //             $.removeCookie(item, {path: '/'}); // удаляю эти элементы
    //         }
    //     });
    // }




    function deleteAllCookies() {
        var cookies = document.cookie.split(";");

        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i];
            var eqPos = cookie.indexOf("=");
            var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
            document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
        }
    }
</script>
