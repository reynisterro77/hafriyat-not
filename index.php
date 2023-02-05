<?php require_once 'header.php';?>


<!-- Page Content -->
<div style="height: auto;" class="container">
    <?php

        $musteri=$db->reada("musteri","musteri_id,musteri_number,musteri_name",
            [
                    "columns_name"=>"musteri_name",
                "columns_sort"=>"ASC"
            ]);
        foreach ($musteri as $musteris){
            $musteriveri[]=$musteris;
        }

    $musteri_sayi=$musteri->rowCount();


        $paid=$db->reada("paid","paid_odenen");


    foreach ($paid as $paids){
        $paidodenen+=$paids['paid_odenen'];
    }

        $sonisler=$db->reada("business","business_fiyat");


    $sonisler_sayi=$sonisler->rowCount();

    foreach ($sonisler as $sonislers){
        $tophesap+=$sonislers['business_fiyat'];
    }


        $yevmiye=$db->reada("wage","wage_birimfiyat");


    $yevmiye_sayi=$yevmiye->rowCount();

    foreach ($yevmiye as $yevmiyes){
        $topyevmiye+=$yevmiyes['wage_birimfiyat'];
    }


    $seferveri=$db->qSql("SELECT transportation_adet,transportation_birimfiyat  FROM transportation WHERE users_id={$users_id}");
    foreach ($seferveri as $seferveris){
        $topsefer+=$seferveris['transportation_adet']*$seferveris['transportation_birimfiyat'];
    }


    require_once 'saathesap.php';

if (isset($_POST['expense_insert'])){
    if(isset($_SESSION['personel'])){
        $_POST['personel_id']=$_SESSION['personel']['personel_id'];
    }

    $_POST['users_id']=$users_id;
    $_POST['expense_date']=$date;




    $sonuc=$db->insert("expense",$_POST,
        [
            "form_name"=>"expense_insert"
        ]);

    if ($sonuc){?>
        <div class="alert alert-success">Başarıyla Gider Eklendi.</div>
    <?php  }

}

    if (isset($_POST['transportation_insert'])){
        if(isset($_SESSION['personel'])){
            $_POST['personel_id']=$_SESSION['personel']['personel_id'];
        }

        $_POST['users_id']=$users_id;
        $_POST['transportation_datetime']=$date;



        $sonuc=$db->insert("transportation",$_POST,
            [
                "form_name"=>"transportation_insert"
            ]);

        if ($sonuc){?>
            <div class="alert alert-success">Başarıyla Sefer Eklendi.</div>
        <?php  }

    }



    ?>


    <h1 class="my-4">Sayfamıza Hoşgeldiniz<?php if (isset($_SESSION['users'])){ echo " ".$_SESSION['users']['users_name']; }elseif (isset($_SESSION['personel'])){echo " ".$_SESSION['personel']['personel_name'];}?>...</h1>

    <!-- Marketing Icons Section -->






<?php if (isset($_SESSION['users'])){ ?>
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php if ($musteri_sayi>0){echo $musteri_sayi;}else{echo $musteri_sayi=0;} ?></h3>

                        <p>Müşteri Sayısı</p>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php if ($paidodenen>0){ echo $paidodenen;}else{ echo $paidodenen=0;}?> TL </h3>

                        <p>Hesabına Ödeme Yapılan Miktar</p>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php if ($sonisler_sayi+$yevmiye_sayi+$seferveri->rowCount()>0){echo $sonisler_sayi+$yevmiye_sayi+$seferveri->rowCount();}else{echo $sayi=0;} ?></h3>

                        <p>İş Sayısı</p>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php echo ($tophesap+$topyevmiye+$topsefer)-$paidodenen; ?> TL</h3>

                        <p>Toplam Alınacak Miktar</p>
                    </div>

                </div>
            </div>
            <!-- ./col -->
        </div>
        <?php } ?>

        <div class="row">
            <div class="col-lg-6">
                <div class="card h-100">
                    <h4 class="card-header">Yevmiye Ekle</h4>
                    <div class="card-body">
                        <p class="card-text">
                            Yevmiye ekle buttonuna basmanız yeterlidir.Bugünün tarihini alarak ekleme yapar
                        </p>

                        <form action=""  method="post">


                            <?php if (!isset($_GET['musteri_ekle'])){?>
                                <div class="row mb-2">
                                    <div class="col-lg-12">
                                        <div align="right"><a class="btn btn-primary btn-sm" href="?musteri_ekle">Müşteri Ekle</a></div>
                                        <select class="form-control" name="musteri_number" id="">
                                            <option selected disabled="">Müşteri Seçiniz</option>
                                            <?php
                                            foreach ($musteriveri as $veris){?>
                                                <option class="form-control" value="<?php echo $veris['musteri_number'];?>"><?php echo $veris['musteri_name'];?>-<?php echo $veris['musteri_number'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>


                            <?php if (isset($_GET['musteri_ekle'])){?>
                                <div class="row mb-2">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" name="musteri_name" placeholder="Müşteri İsmi">
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" id="phone2" name="musteri_number" placeholder="Müşteri Telefon Numarası">
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" name="musteri_adres" placeholder="Adres">
                                    </div>
                                </div>
                            <?php } ?>

                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <input class="form-control"  type="text" name="wage_isname" placeholder="Yapılan İş">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <input class="form-control"  type="number" name="wage_birimfiyat" placeholder="Ne kadara çalışağınızı birim fiyatıyla yazın">
                                <small>Doldurmak Zorunlu Değil</small>
                            </div>
                    </div>
            </div>
                    <div class="card-footer">
                        <div class="row">
                            <button type="submit" name="wage_insert" class="btn btn-success">Yevmiye Ekle</button>
                        </div>
                    </div>
                    </form>
        </div>
            </div>

            <div class="col-lg-6">
                <div class="card h-100">
                    <h4 class="card-header">Gider Ekle</h4>
                    <div class="card-body">
                        <p class="card-text">
                        </p>

                        <form action="" method="post">


                            <div class="row mb-2">
                                <div class="col-lg-12">
                                    <input class="form-control"  type="text" required name="expense_acıklama" placeholder="Gider Açıklama">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-lg-12">
                                    <input class="form-control"  type="number" required name="expense_tutar" placeholder="Tutan Miktar">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-lg-12">
                                    <input class="form-control"  type="text" name="expense_birimfiyat" placeholder="Birim Fiyatı">
                                    <small>Doldurmak Zorunlu Değil</small>
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <button type="submit" name="expense_insert" class="btn btn-success">Gider Ekle</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>


        </div>

    <br>

    <div class="row">

        <div class="col-lg-6">
            <div class="card h-100">
                <h4 class="card-header">Sefer Ekleme</h4>
                <div class="card-body">
                    <p class="card-text">
                    </p>

                    <form action="" method="post">

                        <?php if (!isset($_GET['musteri_ekle'])){?>
                            <div class="row mb-2">
                                <div class="col-lg-12">
                                    <select class="form-control" name="musteri_id" id="">
                                        <option selected disabled="">Müşteri Seçiniz</option>
                                        <?php
                                        foreach ($musteriveri as $veris){?>
                                            <option class="form-control" value="<?php echo $veris['musteri_id'];?>"><?php echo $veris['musteri_name'];?>-<?php echo $veris['musteri_number'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>


                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <input class="form-control"  type="text" required name="transportation_acıklama" placeholder="Malzeme Adı veya Açıklama">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <input class="form-control"  type="number" required name="transportation_adet" placeholder="Toplam Adet">
                            </div>
                        </div>

                        <?php if (isset($_SESSION['users'])){ ?>
                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <input class="form-control"  type="text" name="transportation_birimfiyat" placeholder="Sefer Ücreti">
                            </div>
                        </div>
                        <?php } ?>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <button type="submit" name="transportation_insert" class="btn btn-success">Seferleri Ekle</button>
                    </div>
                </div>
                </form>
            </div>
        </div>




    </div>











    <!-- Features Section -->




</div>
<!-- /.container -->



<?php require_once 'footer.php';?>

