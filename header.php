<?php
date_default_timezone_set('Europe/Istanbul');



require_once 'netting/class.crud.php';
$db=new crud();//sınıfı çalıştırma
// include 'fonksiyon.php';

$date=date('d-m-Y');


error_reporting(E_ALL & ~E_NOTICE);//undefield kapatma



if (isset($_POST['otosaat'])) {

    if (empty($_COOKIE['otosaat'])){

        setcookie("otosaat",date('d-m-Y H:i'), time() + (60*60*240));
    }else{
        setcookie("otosaatbitis",date('d-m-Y H:i'), time() + (60*60*240));
    }

    //setcookie("otosaat",date('d.m.Y H:i:s'), time() - (60*60*240)); //cookie silme

}

if (isset($_POST['otosaatdelete'])){
    setcookie("otosaat",date('d-m-Y H:i'), time() - (60*60*240));//cookie temizleme
    setcookie("otosaatbitis",date('d-m-Y H:i'), time() - (60*60*240));//cookie temizleme
}

if (isset($_SESSION['users'])) {
    $users_id=$_SESSION['users']['users_id'];
}elseif (isset($_SESSION['personel'])){
    $id=$db->wreadb("personel","personel_id",$_SESSION['personel']['personel_id'],"users_id");
    foreach ($id as $ids){}
    $users_id=$ids['users_id'];
}
else{
    header("location:login");
    exit();
}


if (isset($_POST)){//gelen post verilen güvenliği sağlama htmlspecialchars geçirme

    foreach ($_POST as $item=>$value){
     if (!empty($item)){
         $_POST[$item]=htmlspecialchars($value);
     }
    }
}


?>

<!DOCTYPE html>
<html lang="tr">

<head>

    <meta charset="UTF-8">
    <meta name="description" content="Saat hesaplama,cari hesap,personel takip gibi işlemleri ücretsiz bir şekilde yapabilirsiniz.">
    <meta name="keywords" content="hafriyatnot,HAFRİYATNOT,hafriyat not,HAFRİYAT NOT,hafriyat,nothafriyat,NOTHAFRİYAT,not hafriyat,NOT HAFRİYAT,harfiyatnot,harfiyat not,HARFİYAT NOT,harfriyat cari,harfiyat cari,harfriyat cari hesap,harfiyat cari hesap">
    <meta name="author" content="Melih Kara">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="google-site-verification" content="zZmGVOheEcqj2ISmgNRwG9LsVmjpGNZRsLv3-1XVm28" />

    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  eski metalardan-->

    <title>Hafriyat Not </title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="vendor/custom.js"></script>
    <link rel="stylesheet" href="vendor/bootstrap/css/css.css">


</head>

<body>

<!-- Navigation -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index">Hafriyat Not</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" href="index">Anasayfa</a>
                </li>

                <?php if (isset($_SESSION['users'])){?>

                    <li class="nav-item">
                        <a class="nav-link" href="musteri">Müşterilerim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="personel">Personellerim</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="sonisler">Son Yapılan İşler</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="gider">Giderler</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="isekle">İş Ekle</a>
                    </li>

                <?php } ?>

                <?php if (isset($_SESSION['personel'])){?>



                    <li class="nav-item">
                        <a class="nav-link" href="sonisler">Son Yapılan İşler</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="isekle">İş Ekle</a>
                    </li>

                <?php } ?>


                <!--
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Araçlar
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
                        <?php if (isset($_SESSION['users'])){?> <a class="dropdown-item" href="hesaplama.php.php">M<sup>3</sup> Hesaplama</a>  <?php } ?>
                    </div>
                </li>-->

                <?php

                if (isset($_SESSION['users'])){?>
              <?php  }elseif (isset($_SESSION['personel'])){?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout">Çıkış Yap</a>
                    </li>
                <?php }
                ?>





                <?php
                if (!empty($_SESSION['users'])){?>



                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ayarlar
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
                            <a class="dropdown-item" href="profile">Hesap Bilgilerimi Değiştir</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="logout">Çıkış Yap</a>
                    </li>


               <?php }

                ?>







                <!--
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Portfolio
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">
                        <a class="dropdown-item" href="portfolio-1-col.html">1 Column Portfolio</a>
                        <a class="dropdown-item" href="portfolio-2-col.html">2 Column Portfolio</a>
                        <a class="dropdown-item" href="portfolio-3-col.html">3 Column Portfolio</a>
                        <a class="dropdown-item" href="portfolio-4-col.html">4 Column Portfolio</a>
                        <a class="dropdown-item" href="portfolio-item.html">Single Portfolio Item</a>
                    </div>
                </li>-->


            </ul>
        </div>
    </div>
</nav>
