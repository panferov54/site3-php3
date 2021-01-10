
<div style="margin:0 auto; width: 600px;border-radius: 40px;" class="bg-info">
<h2 style="padding-left: 50px;padding-top: 30px" class="text-white">Форма Регистрации</h2>
<?php
if (!isset($_POST['regbtn'])){
    ?>
    <form action="index.php?page=3" method="post" class="my-5" enctype="multipart/form-data">
        <div class="form-group pl-5">
            <label for="login"></label>Login:
            <input type="text" class="form-control w-50 " name="login" id="login">
        </div>
        <div class="form-group pl-5">
            <label for="pass1"></label>Password:
            <input type="password" class="form-control w-50" name="pass1" id="pass1">
        </div>
        <div class="form-group pl-5">
            <label for="pass2"></label>Password:
            <input type="password" class="form-control w-50" name="pass2" id="pass2">
        </div>
        <div class="form-group pl-5">Image upload:
            <input type="file" class="form-control w-50" name="imagepath" id="imagepath">
        </div>




        <input type="submit" name="regbtn" class="btn btn-primary mb-5 ml-5" value="Register">
    </form>
</div>
    <?php
} else {

    if(is_uploaded_file($_FILES['imagepath']['tmp_name'])){
        $path="images/users/".$_FILES['imagepath']['name'];
        move_uploaded_file($_FILES['imagepath']['tmp_name'],$path);
    }
   if  ($_POST['pass1']===$_POST['pass2']){
       $customer= new Customer($_POST['login'],$_POST['pass1'],$path);
       if($customer->register()){
           echo '<h3>Пользователь добавлен</h3>';
   }

   }

}