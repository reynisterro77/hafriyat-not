<?php
require_once "netting/class.crud.php";
$db=new crud();

require_once 'fonksiyon.php';

error_reporting(E_ALL & ~E_NOTICE);//undefield kapatma
?>

<?php


if (!empty($_SESSION)){
    header('location:'.$urlhome);///index
    exit();
}
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="vendor/logincss.css" rel="stylesheet">
<!------ Include the above in your HEAD tag ---------->

<div class="wrapper fadeInDown">


    <?php

    if (isset($_POST)){//gelen post verilen güvenliği sağlama htmlspecialchars geçirme

        foreach ($_POST as $item=>$value){
            if (!empty($item)){
                $_POST[$item]=htmlspecialchars($value);
            }
        }
    }

    if(isset($_POST['users_refresh'])){

        $user=$db->wreadb("users","users_mail",$_POST['users_mail'],"users_mail");

        foreach ($user as $val){
            if($val['users_mail'] == $_POST["users_mail"]){
                $random=substr(md5(microtime()),rand(0,26),15);


                $value="http://www/hafrnot/passwordreset.php/".$random;//https://hafriyatnot.com/
                $_POST['value']=$value;
                $ins=$db->insert("respas",$_POST,
                    [
                        "form_name"=>"users_refresh"
                    ]);

                //`mail`, `value`

                if ($ins){
                    $mailKonu='Şifre Yenileme Linkiniz';
                    $mesaj=$value;


                    mailgonder($_POST['users_mail'],$mailKonu,$mesaj);

                    if ($ins){?>

                        <div class="alert alert-success">Şifre Yenileme Linki Gönderilmiştir.</div>

                    <?php  }
                }
            }
        }



    }

    if(isset($_POST['users_login'])||isset($_COOKIE['users_mail'])){

        if(isset($_COOKIE['users_mail'])){
            $_POST['users_mail']=$_COOKIE['users_mail'];
            $_POST['users_password']=base64_decode($_COOKIE['users_password']);
            $_POST['remember_me']='on';
        }

        if (isset($_POST['remember_me'])){
            setcookie('users_mail',$_POST['users_mail'],time() + (60*60*240));
            setcookie('users_password',base64_encode($_POST['users_password']),time() + (60*60*240));
        }else{
            setcookie('users_mail',$_POST['users_mail'],time() - (60*60*240));
            setcookie('users_password',base64_encode($_POST['users_password']),time() - (60*60*240));
        }

        $sonuc=$db->adminsLogin(htmlspecialchars($_POST['users_mail']),htmlspecialchars($_POST['users_password']));
        if ($sonuc["status"]==true){
            header("location:index");
            exit();
        }else{?>
            <div class="alert alert-danger">Kullanıcı Bulunamadı.</div>
        <?php }
    }

    if(isset($_POST['personel_login'])||isset($_COOKIE['personel_kadi'])){

        if(isset($_COOKIE['personel_kadi'])){
            header('/login?personel');
            $_POST['personel_kadi']=$_COOKIE['personel_kadi'];
            $_POST['personel_pass']=base64_decode($_COOKIE['personel_pass']);
            $_POST['personelremember_me']='on';
        }

        if (isset($_POST['personelremember_me'])){
            setcookie('personel_kadi',$_POST['personel_kadi'],time() + (60*60*240));
            setcookie('personel_pass',base64_encode($_POST['personel_pass']),time() + (60*60*240));
        }else{
            setcookie('personel_kadi',$_POST['personel_kadi'],time() - (60*60*240));
            setcookie('personel_pass',base64_encode($_POST['personel_pass']),time() - (60*60*240));
        }


        $sonuc=$db->personelsLogin(htmlspecialchars($_POST['personel_kadi']),htmlspecialchars($_POST['personel_pass']));
        if ($sonuc["status"]==true){
            header("location:index");
            exit();
        }else{?>
            <div class="alert alert-danger">Kullanıcı Bulunamadı.</div>
        <?php }
    }


    ?>




    <div id="formContent">
        <!-- Tabs Titles -->

        <?php
        if (isset($_GET['personel'])){?>

            <form action="" method="post">
                <input type="text" class="fadeIn second" name="personel_kadi" placeholder="Kullanıcı Adınız">
                <input type="password" class="fadeIn third" min="6" name="personel_pass" placeholder="Şifre Giriniz">
                <input type="submit"  class="fadeIn fourth" name="personel_login" value="Giriş Yap">
                <br>
                <input type="checkbox" class="fadeIn fourth" name="personelremember_me">
                <label class="fadeIn fourth">Otomatik Giriş</label>
            </form>
       <?php }elseif (isset($_GET['sifremiunuttum'])){?>
            <!-- Reset  Password -->
            <form action="" method="post">
                <input type="email" class="fadeIn second" name="users_mail" placeholder="Email Giriniz">
                <input type="submit"  class="fadeIn fourth" name="users_refresh" value="Şifremi Emailime Gönder">
            </form>

      <?php  } else {?>

        <!-- Login Form -->
        <form action="" method="post">
            <input type="email" class="fadeIn second" name="users_mail" placeholder="Email Giriniz">
            <input type="password" class="fadeIn third" min="6" name="users_password" placeholder="Şifre Giriniz">
            <input type="submit"  class="fadeIn fourth" name="users_login" value="Giriş Yap">
            <br>
            <input type="checkbox" class="fadeIn fourth" name="remember_me">
            <label class="fadeIn fourth">Otomatik Giriş</label>
        </form>

       <?php } ?>




        <!-- Remind Passowrd -->
        <div id="formFooter">
            <?php
            if (isset($_GET['personel'])){?>
                <a class="underlineHover" href="login">Yönetici Girişi</a>
                <a class="underlineHover" href="#">Personel Kayıtı Yönetici Yapar.</a>
            <?php }else{?>
            <a class="underlineHover" href="?personel">Personel Girişi</a>
            <a class="underlineHover" href="register">Ücretsiz Kayıt Ol</a>
            <a class="underlineHover" href="?sifremiunuttum">Şifremi Unuttum</a>
            <?php } ?>
        </div>

    </div>
</div>