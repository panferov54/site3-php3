<h3 class="text-info">Каталог товаров</h3>
<div id="productAdd" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title text-info">Товар добавлен в корзину</h4>
            </div>


                <button type="button" class="btn btn-default" data-dismiss="modal">х</button>

        </div>

    </div>
</div>
<form action="index.php?page=1" method="post">
    <div>
        <h4 class="text-info mt-3">Выберите категорию товара :</h4>
        <select name="catid" class="mb-3" id="catid" onchange="getItemsCat(this.value)">
            <?php
            echo "<option value='0'>Выберите категорию</option>";

            $pdo=Tools::connect();
            $ps=$pdo->prepare("SELECT * FROM categories");
            $ps->execute();
            //Добавляем все категории в option
            while($row=$ps->fetch()) {
                echo "<option value=".$row['id'].">".$row['category']."</option>";
            }
            ?>
        </select>
    </div>

<?php
echo "<div id='message'></div>";
echo '<div id="result" class="row d-flex justify-content-around">';
$items = Item::getItems();
foreach ($items as $item) {
    $item->drawItem();
}
echo '</div>';

?>
</form>






<!--echo '<div id="result" class="row justify-content-between" >';-->
<!--//$items=Item::getItems();-->
<!--//foreach ($items as $item){-->
<!--//    $item->drawItem();-->
<!--//}-->
<!--echo '</div>';-->

<!--?>-->

<script>
    function createCookie(ruser,id){


        console.log(ruser);
        $.cookie(ruser,id,{expires:2,path:'/'});
    }

    function getItemsCat(cat) {
        let res = {
            loader: $('<div />', {class:'loader'}),
            container: $('#result')
        };

        $.ajax({
            url:'catalog.php',
            beforeSend:function () {
                res.container.append(res.loader);
            },
            success: function (data) {
                res.container.html(data);
                res.container.find(res.loader).remove();
            }
        });

        if(window.XMLHttpRequest) {
            ac = new XMLHttpRequest();
        } else {
            ac = new ActiveXObject('Microsoft.XMLHTTP');
        }
        ac.onreadystatechange = function () {

            if(ac.readyState === 4 && ac.status === 200) {
                document.getElementById('result').innerHTML = ac.responseText;
            }
        }
        ac.open('POST', 'pages/get_items.php', true);
        ac.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ac.send("cat="+cat);
    }

</script>
