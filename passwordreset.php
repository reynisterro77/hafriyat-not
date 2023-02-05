
<?php
error_reporting(E_ALL & ~E_NOTICE);//undefield kapatma
session_start();
require_once "netting/class.crud.php";
$db=new crud();
date_default_timezone_set('Europe/Istanbul');

$url='http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];//https://

 $sonuc=$db->wreada("respas","value",$url);

foreach ($sonuc as $val){
}
$baslangic     = strtotime($val['time']);//unix id alıyor
$bitis         = strtotime(date('d-m-Y H:i:s'));
 $fark        = abs($bitis-$baslangic);
 $dk= $fark/60;

if ($dk<=1440){//linkin süresi 24 saaten küçükse?>

    <div class="wrapper fadeInDown">
<?php

$users=$db->wreada("users","users_mail",$val['users_mail']);

foreach ($users as $vall){
}

if(isset($_POST['users_resetpassword'])){

    $update=$db->update("users",$_POST,[
            "form_name"=>"users_resetpassword",
        "columns"=>'users_mail'

    ]);

    if ($update['status']){
        $db->delete("respas","value",$url);//şifre değiştirme işleminden sonra respastaki urlyi siliyoruz
        ?>
        <div class="alert alert-success">Şifreniz Başarıyla Değiştirildi.</div>
    <?php header('Refresh: 1; url=login'); }

}
    ?>


        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link href="vendor/logincss.css" rel="stylesheet">
        <!------ Include the above in your HEAD tag ---------->


        <div id="formContent">
            <!-- Tabs Titles -->

    <form action="" method="post">
        <input type="text" class="fadeIn first" name="users_mail" readonly="" value="<?php echo $vall['users_mail']; ?>">
        <input type="text" class="fadeIn third" name="users_password" placeholder="Yeni Şifrenizi Giriniz">
        <input type="submit"  class="fadeIn fourth" name="users_resetpassword" value="Şifremi Yenile">
    </form>


        </div>
    </div>


    <?php

}else{
    $db->delete("respas","value",$url);//eğer link 24 saati geçerse silinecek
    header('location:'.$urlhome);
    exit;
}








?>