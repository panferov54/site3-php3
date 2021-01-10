<?php


class Tools{
   static public function connect($host="localhost:3306",$user="root",$pass="root",$dbname="shop"){

      //PDO(PHP data object)- механизм взаимодействия с СУБД
       //ПДО позволяет облегчить рутинные задачи при выполнение запросов и содержит защитные механизмы при работе с субд


       //определим DSN - сведения для подключения к БД
        $cs="mysql:host=$host;dbname=$dbname;charset=utf8";
        //массив опций для создания PDO
       $option=[
           PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION,
           PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC,
           PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'
       ];


       try {
           $pdo=new PDO($cs,$user,$pass,$option);
           return $pdo;

       }catch (PDOException $e){
           echo $e->getMessage();
           return false;
       }
    }
};

class Customer {
    public $id;
    public $login;
    public $pass;
    public $roleid;
    public $discount;
    public $total;
    public $imagepath;

    function __construct($login,$pass,$imagepath,$id=0){
        $this->login=trim($login);
        $this->pass=trim($pass);
        $this->imagepath=$imagepath;
        $this->id=$id;

        $this->total=0;
        $this->discount=0;
        $this->roleid=2;
    }

    function register(){
        if ($this->login===''||$this->pass===''){
            echo '<h3 class="text-danger">заполните все поля</h3>';
            return false;
        }
        if (strlen($this->login)<3||strlen($this->login)>32||strlen($this->pass)>64){
            echo "<h4 class='text-danger'>не корректрна длина полей</h4>";
            return false;

        }
$this->intoDb();
     //   $_SESSION['ruser'] = $this->login;
        return true;

    }

    static function login ($login,$pass){
        if (strlen($login)<3||strlen($login)>32||strlen($pass)>64){
            echo "<h4 class='text-danger'>Некорректная длинна полей!!</h4>";
            return false;
        }

        $pdo=Tools::connect();
        $ps = $pdo->query("SELECT * FROM customers where login='$login' and pass='$pass'");
        while($row = $ps->fetch()) {
            if ($row['login'] == $login && $pass == $row['pass']) {
                $_SESSION['ruser'] = $login;
                echo '<script>window.location=document.URL</script>';

                if ($row['roleid'] == 1) {
                    $_SESSION['radmin'] = $login;
                    echo '<script>window.location=document.URL</script>';
                }
            }


        }  echo "<h3 class='text-danger'>Пользователь не найден!</h3>";
        return false;

    }

    function intoDb(){
        try {
            $pdo=Tools::connect();
            //подготовим запрос на добавление польхователя
            $ps=$pdo->prepare("INSERT INTO customers(login,pass,roleid,discount,total,imagepath) values (:login,:pass,:roleid,:discount,:total,:imagepath)");
           //разименовывание объекта this и преобразование к массиву
           $ar=(array)$this;
           array_shift($ar);//удаляем первый элемент массива
        $ps->execute($ar);

        }catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
};

class Item {
    public $id;
    public $itemname;
    public $catid;
    public $pricein;
    public $pricesale;
    public $info;
    public $rate;
    public $imagepath;
    public $rezerv;
    public $action;

    function __construct($itemname,$catid,$pricein,$pricesale,$info,$imagepath,$rezerv,$rate=0,$action=0,$id=0)
    {
        $this->id=$id;
        $this->itemname=$itemname;
        $this->catid=$catid;
        $this->pricein=$pricein;
        $this->pricesale=$pricesale;
        $this->info=$info;
        $this->rate=$rate;
        $this->imagepath=$imagepath;
        $this->rezerv=$rezerv;
        $this->action=$action;
    }

    function intoDb(){

        try {
            $pdo=Tools::connect();
            $ps=$pdo->prepare("insert into items(itemname,catid,pricein,pricesale,info,rate,imagepath,rezerv,action) values (:itemname,:catid,:pricein,:pricesale,:info,:rate,:imagepath,:rezerv,:action)");
        $ar=(array)$this;
            array_shift($ar);
            $ps->execute($ar);
        }catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }
    static function fromDb($id){
        try {
            $pdo=Tools::connect();
            $ps=$pdo->prepare("select * from items where id=?");
        $ps->execute([$id]);
        $row=$ps->fetch();
        $item= new Item($row['itemname'],$row['catid'],$row['pricein'],$row['pricesale'],$row['info'],$row['imagepath'],$row['rezerv'],$row['rate'],$row['action'],$row['id']);
     return $item;
        }catch (PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    //метод формирования списка товаров
  static function getItems($catid=0){
       try {
           $pdo=Tools::connect();
          //если категория не выбрана, то показываем все товары
           if ($catid===0){
               $ps=$pdo->query("select * from items");

           } else {
               //если catid есть, то фильтруем по нему
               $ps=$pdo->prepare("select * from items where catid=?");
               $ps->execute([$catid]);
           }
           while ($row=$ps->fetch()){
               $item= new Item($row['itemname'],$row['catid'],$row['pricein'],$row['pricesale'],$row['info'],$row['imagepath'],$row['rezerv'],$row['rate'],$row['action'],$row['id']);
              //создаем массив экземпляров класса Item
               $items[]=$item;
           }
           return $items;
       }catch (PDOException $e){
           echo $e->getMessage();
           return false;
       }

   }

    //  метод отрисовки товаров
    function drawItem(){
        echo '<div class="col-sm-6 col-md-3  item-card m-3 bg-info text-white box-shadow" style="border-radius: 40px;" id="divItem">';
        //шапка товара
echo '<div class="m-1 bg-dark">';

echo "<a href='pages/iteminfo.php?name={$this->id}' target='_blank' class='m-2 float-left text-white' >$this->itemname</a>";
echo "<span class='mr-2 float-right'>$this->rate</span>";
        echo '</div>';


        //изображение товара
        echo '<div class="mt-4 item-card__img">';
echo "<img src='{$this->imagepath}' alt='image' class='img-fluid' style='max-height: 400px'>";
        echo '</div>';
        //цена товара
        echo '<div class="mt-1 item-card__price bg-warning w-50 text-center" style="border-radius: 45px">';
      echo "<span class='lead text-white'>$this->pricesale $</span>";
        echo '</div>';
        //описание товара
        echo '<div class="mt-1 item-card__info ">';
        echo '<h6>Описание товара:</h6>';

        echo '<p class="float-left">&quot;</p>';

        echo "<span class='lead '> $this->info </span>";

        echo '<br>';
        echo '<p class="float-right">&quot;</p>';
        echo '</div>';
        echo '<br>';
        //кнопка добавления в корзину
        echo '<h6>Остаток товара :</h6>';
        echo "<span class='lead '> $this->rezerv шт.</span>";
if($this->rezerv>0) {


    echo '<div class="mt-3 text-center ">';
    // $ruser="cort_";
    $ruser = 'cart_' . $this->id;
    echo "<button class='btn btn-primary btn-lg w-75 btn-block mb-3 mx-auto' data-toggle='modal' data-target='#productAdd' onclick=createCookie('" . $ruser . "','" . $this->id . "') style='white-space: normal;'>Добавить в корзину</button>";

    echo '</div>';
}else{
    echo '<h6 class="text-danger">товар закончился</h6>';
}

        echo '</div>';
    }
function drawItemCart(){
        echo '<div class="row m-2 bg-light" style="border-radius: 40px;">';
echo "<span class='col-1 ml-3 mt-2'>$this->id</span>";
    echo "<img src='{$this->imagepath}' alt='image' class='col-1 img-fluid'>";
    echo "<span class='col-3'>$this->itemname</span>";
    echo "<input name='quantity' id='quantity' placeholder='Сколько шт.' class='item-cart__quantity'>";
    echo "<span class='col-3'>$this->pricesale $</span>";
    $ruser='cart_'.$this->id;

    echo "<button class='btn btn-danger text-uppercase my-auto' onclick=eraseCookie('".$ruser."') style='max-height: 100px'>удалить</button>";
    echo '</div>';
}
static function addCategory(){
    try {

        $pdo=Tools::connect();
        $catval=$_POST['addcat'];
        $ps=$pdo->prepare("insert into categories(category) VALUES (?)");

        $ps->execute($catval);

        echo '<script>location.href=location.href;</script>';
    }catch (PDOException $e){
        echo $e->getMessage();
        return false;
    }
}
function sale($quan){
    try {

        //уменьшение кол-ва
        $pdo=Tools::connect();
        $newRezerv = $this->rezerv - $quan;
        $updQuan="UPDATE items SET rezerv=$newRezerv WHERE id=?";
        $ps=$pdo->prepare($updQuan);
        $ps->execute([$this->id]);

        //увелечение рейтингпа
        $newRate=$this->rate+1;
        $updRate="update items set rate=$newRate where id=?";
        $ps=$pdo->prepare($updRate);
        $ps->execute([$this->id]);

        $upd="update customers set total=total+? where login=?";
        $ps=$pdo->prepare($upd);
        $login=$_SESSION['ruser'];
        $ps->execute([$this->pricesale,$login]);
        //добавиьт записть в таблицу
        $ins="insert into sales(customername,itemname,pricein,pricesale,datasale) values(?,?,?,?,?)";
        $ps=$pdo->prepare($ins);
        $ps->execute([$login,$this->itemname,$this->pricein,$this->pricesale,@date("Y/m/d H:i:s")]);
        return $this->id;

    }catch (PDOException $e){
        echo $e->getMessage();
        return false;
    }
}
static function SMTP($id_result){
        require_once ("PHPMailer/PHPMailerAutoload.php");
        require_once ("private/private_data.php");
        $mail=new PHPMailer;
        //настройка протокола SMTP
        $mail->CharSet="UTF-8";
        $mail->isSMTP();
        $mail->SMTPAuth=true;
        $mail->Host='smtp.gmail.com';
        $mail->Port=25;
        $mail->Username=MAIL;
        $mail->Password=PASS;

        //от кого
    $mail->setFrom(MAIL,'SHOP test');

    //кому
    $mail->addAddress(MAIL,'From site by_noff');

    //тема письма

    $mail->Subject='Новый заказ на сайте Shop by_noff';

    //тело письма
    $body="<table cellspacing='0' cellpadding='0' border='2' width='800' style='background-color: lavender!important;'>";
    $arr_items=[];

    $i=0;

    foreach ($id_result as $id){
        $item=self::fromDb($id);
    array_push($arr_items,$item->itemname,$item->pricesale,$item->info);//для csv файла
        $mail->addEmbeddedImage($item->imagepath,'item'.++$i);
        $body.="<tr>
<th>$item->itemname</th>
<td style='padding-left: 20px;'>$item->pricesale</td>
<td style='padding-left: 20px;'>$item->info</td>
<td><img src='cid:item{$i}' alt='item' height='100'></td>


                </tr>";

    }

    $body.='</table>';
    $mail->msgHTML($body);
    try {

        $mail->send();
    } catch (phpmailerException $e) {
        echo $e->getMessage();

    }

//вызов и создание .csv файла
    try {
        $csv=new CSV('private/excel_file.csv');
        $csv->setCSV($arr_items);
    }catch (Exception $e){
        echo $e->getMessage();
    }
}

}

class Category {
    public $id;
    public $category;

    function __construct($category, $id=0)
    {
        $this->id = $id;
        $this->category = $category;
    }

    function intoCategory() {
        try {
            $pdo = Tools::connect();
            $ps =$pdo->prepare("INSERT INTO categories(category) VALUES (:category)");
            $ar =(array)$this;
            array_shift($ar);
            $ps->execute($ar);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

}

class CSV {
    private $csv_file=null;
    public function __construct($csv_file){
        $this->csv_file=$csv_file;
    }



    function setCSV($arr_item){
        $file=fopen($this->csv_file,'a+');
        foreach ($arr_item as $item){
            fputs($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file,[$item],';');
        }
        fclose($file);
    }

}