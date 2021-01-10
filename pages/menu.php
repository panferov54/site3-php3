
<ul class="nav nav-pills justify-content-around w-100" role="tablist" >
    <li class="nav-item"><a href="index.php?page=1" class="nav-link <?php echo ($_GET['page']==='1')?"active":""?> text-white" role="tab" >Каталог</a></li>
    <li class="nav-item"><a href="index.php?page=2"  class="nav-link <?php echo ($_GET['page']==='2')?"active":""?> text-white" role="tab">Корзина</a></li>
    <li class="nav-item"><a href="index.php?page=3"  class="nav-link <?php echo ($_GET['page']==='3')?"active":""?> text-white" role="tab">Регистрация</a></li>
    <li class="nav-item"><a href="index.php?page=4"   class="nav-link <?php echo ($_GET['page']==='4')?"active":""?> text-white" role="tab">Панель Администрирования</a></li>

</ul>




<!--JQUERY ANALOG-->
<!--<ul class="nav nav-pills justify-content-around w-100">-->
<!--    <li class="nav-item"><a href="index.php?page=1" class="nav-link" data-link="1">Catalog</a></li>-->
<!--    <li class="nav-item"><a href="index.php?page=2" class="nav-link" data-link="2">Cart</a></li>-->
<!--    <li class="nav-item"><a href="index.php?page=3" class="nav-link" data-link="3">Registration</a></li>-->
<!--    <li class="nav-item"><a href="index.php?page=4" class="nav-link" data-link="4">Admin Forms</a></li>-->
<!--</ul>-->
<!---->
<!--<script>-->
<!---->
<!--    $(function () {-->
<!--        $("a").click(function() {-->
<!--            let linkNumber = $(this).attr("href").slice(-1);-->
<!--            $("a").removeClass('active');-->
<!--            $(this).addClass('active');-->
<!--            localStorage.active = linkNumber;-->
<!--        });-->
<!---->
<!--        $(`a[data-link="${localStorage.active}"]`).addClass('active');-->
<!--    });-->
<!--</script>-->


<?php
