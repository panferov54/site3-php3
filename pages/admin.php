
<div class="bg-info w-50 mx-auto " style="border-radius: 40px; padding-left: 20px">
<h2 class="py-4 text-center text-white">Панель добавления товара</h2>
<?php


if (!isset($_POST['addbtn'])){

?>


    <form action="index.php?page=4" method="post" enctype="multipart/form-data" class="my-2">
        <div class="form-group">
             <input type="text" name="category" placeholder="Новая категория" class="mr-2" id="newcategory">
            <input type="submit" name="addcategory" value="Добавить" class="btn btn-sm btn-warning mr-2">
            <?php
            if (isset($_POST['addcategory'])) {
                $pdo = Tools::connect();
                $category = new Category(trim($_POST['category']));
                $category->intoCategory();
            }

            ?>


        <div class="form-group" style="overflow:hidden; " >

                <div name="catid" id="category" class="ml-auto bg-warning mr-3"  style="border-radius: 40px;padding-left: 40px;height:150px;width:200px;overflow-y:scroll;">
                    <label class="text-info" >Категории:
                    <?php
                    $pdo = Tools::connect();
                    $ps = $pdo->query("SELECT * FROM categories");//выполнить запрос(вместо препаре и экзекют)

                    while ($row = $ps->fetch()) {
                        echo "<p class='text-white'>{$row['category']}</p>";
                    }

                    ?>
                </div>
            </label>
        </div>
        </div>




        <div class="form-group">
            <label for="category">Категории:
                <select name="catid" id="category">
                    <?php
                    $pdo=Tools::connect();
                    $ps=$pdo->query("SELECT *  FROM categories");//выполняем запрос
                   while ($row=$ps->fetch()){
                       echo "<option value='{$row['id']}'>{$row['category']}</option>";
                   }
                    ?>

                </select>
            </label>
        </div>
        <div class="form-group">
            <label for="name">Имя товара:
                <input type="text" name="name" id="name">
            </label>
        </div>
        <hr>
        <div class="form-group">
           <p>внесите цену покупки и продажи товара</p>
            <label for="pricein">Цена покупки:
                <input type="text" name="pricein" id="pricein">
            </label>
            <label for="pricesale">Цена продажи:
                <input type="text" name="pricesale" id="pricedale">
            </label>
        </div>
        <hr>
        <div class="form-group">
            <label for="info">Информация:
                <textarea  name="info" id="info" cols="30" rows="2"></textarea>
            </label>
        </div>
        <hr>
        <div class="form-group">
            <label for="imagepath">Фото товара:
                <input type="file" multiple accept="image/*" name="imagepath[]" id="imagepath">
            </label>
        </div>
        <div class="form-group">
            <label for="rezerv">кол-во штук:
                <input type="text" name="rezerv" id="rezerv">
            </label>
        </div>
        <input type="submit" class="btn btn-warning mb-3" name="addbtn" value="Добавить товар" >
    </form>
</div>
<?php
} else {

    foreach ($_FILES['imagepath']['name'] as $k=>$v) {
        if (is_uploaded_file($_FILES['imagepath']['tmp_name'][$k] !== 0)) {
            echo '<script>alert("Upload file error"' . $v . ')</script>';
            continue;
        } else {
            $path = "images/goods/" . $_FILES['imagepath']['name'][$k];
            move_uploaded_file($_FILES['imagepath']['tmp_name'][$k], $path);
        }
    $item=new Item (trim($_POST['name']),$_POST['catid'],$_POST['pricein'],$_POST['pricesale'],$_POST['info'],$path,$_POST['rezerv']);
    $item->intoDb();
    }
//    if(is_uploaded_file($_FILES['imagepath']['tmp_name'])){
//        $path="images/goods/".$_FILES['imagepath']['name'];
//        move_uploaded_file($_FILES['imagepath']['tmp_name'],$path);
//    }
//    $item=new Item (trim($_POST['name']),$_POST['catid'],$_POST['pricein'],$_POST['pricesale'],$_POST['info'],$path,$_POST['rezerv']);
//    $item->intoDb();
}



?>