<?php require_once 'header.php';
if(isset($_SESSION['users'])){
}else{
    header("location:index");
    exit();
}
?>
    <!-- Page Content -->
    <div style="height: auto;" class="container">


        <h1 class="my-4">Detay</h1>

        <?php

        $veri=$db->wread("musteri","musteri_id",$_GET['id'],"musteri_id,musteri_name,musteri_number,musteri_adres");
        foreach ($veri as $veris) {
        }

        if(isset($veris))
        {

            if(isset($_SESSION['personel'])){
                $id=$db->wreadb("personel","personel_id",$_SESSION['personel']['personel_id'],"users_id");
                foreach ($id as $ids){}
                $users_id=$ids['users_id'];

            }elseif (isset($_SESSION['users'])){
                $users_id=$_SESSION['users']['users_id'];
            }

/*
        if (isset($_POST['otosaathesap'])){

            $dk=$db->dkhesap($_POST['mola_baslangic'],$_POST['mola_bitis']);
            $_POST['business_moladk']=$dk;
            unset($_POST['mola_baslangic']);
            unset($_POST['mola_bitis']);

            if (!empty($_COOKIE['otosaat']) && !empty($_COOKIE['otosaatbitis'])){

                $hesap=$db->saathesapla($_COOKIE['otosaat'],$_COOKIE['otosaatbitis'],$_POST['business_birimfiyat'],$_POST['business_moladk']);
            }



                $number=$db->qSql("SELECT musteri_id FROM `musteri` WHERE musteri_number='{$veris['musteri_number']}' AND users_id='{$_SESSION['users']['users_id']}'");
                foreach ($number as $numbers){}
                $business_birimfiyat=$_POST['business_birimfiyat'];
                $business_moladk=$_POST['business_moladk'];



                    $_POST['musteri_id']=$numbers['musteri_id'];
                    $_POST['business_baslangic']=$_COOKIE['otosaat'];
                    $_POST['business_bitis']=$_COOKIE['otosaatbitis'];
                    $_POST['business_kacdk']=$hesap['saatdk'];
                    $_POST['business_fiyat']=$hesap['fiyat'];



                    $businessekle=$db->insert('business',$_POST,
                        [
                            "form_name" =>"otosaathesap",
                            "users_id"=>$_SESSION['users']['users_id'],
                            "business_birimfiyat"=>$business_birimfiyat,
                            "business_moladk"=>$business_moladk
                        ]);

                    if ($businessekle['status']){?>
                        <div class="alert alert-success"><a href="musteri.php">Müşterinin Yeni Kayıdı Eklendi.</a> </div>
                    <?php }





        }
        */

        if (isset($_POST['saathesap'])){

            $dk=$db->dkhesap($_POST['mola_baslangic'],$_POST['mola_bitis']);
            $_POST['business_moladk']=$dk;
            unset($_POST['mola_baslangic']);
            unset($_POST['mola_bitis']);

            $hesap=$db->saathesapla($_POST['business_baslangic'],$_POST['business_bitis'],$_POST['business_birimfiyat'],$_POST['business_moladk']);


            if(isset($_SESSION['personel'])){
                $_POST['personel_id']=$_SESSION['personel']['personel_id'];
                $_POST['users_id']=$users_id;
            }elseif (isset($_SESSION['users'])){
                $users_id=$_SESSION['users']['users_id'];
            }



            $business_birimfiyat=$_POST['business_birimfiyat'];
            $business_moladk=$_POST['business_moladk'];
            $business_baslangic=$_POST['business_baslangic'];
            $business_bitis=$_POST['business_bitis'];



            $_POST['musteri_id']=$veris['musteri_id'];
            $_POST['business_kacdk']=$hesap['saatdk'];
            $_POST['business_fiyat']=$hesap['fiyat'];



            $businessekle=$db->insert('business',$_POST,
                [
                    "form_name" =>"saathesap",
                    "users_id"=>$_SESSION['users']['users_id'],
                    "business_birimfiyat"=>$business_birimfiyat,
                    "business_moladk"=>$business_moladk,
                    "business_baslangic"=>$business_baslangic,
                    "business_bitis"=>$business_bitis
                ]);

            if ($businessekle['status']){?>
                <div class="alert alert-success"><a href="musteri.php">Müşterinin Yeni Kayıdı Eklendi.</a> </div>
            <?php }

        }


        if (isset($_POST['wage_insert'])){


                $number=$db->qSql("SELECT musteri_id FROM `musteri` WHERE musteri_id='{$_GET['id']}' AND users_id='{$users_id}'");
                foreach ($number as $numbers){}





                $wage_datetime=date('Y-m-d');


                    $_POST['musteri_id']=$numbers['musteri_id'];
                    $_POST['users_id']=$users_id;
                    $_POST['wage_datetime']=$wage_datetime;

                    if (isset($_SESSION['personel'])){
                        $_POST['personel_id']=$_SESSION['personel']['personel_id'];
                    }




                    $wagesekle=$db->insert('wage',$_POST,
                        [
                            "form_name" =>"wage_insert",
                        ]);

                    if ($wagesekle['status']){?>
                        <div class="alert alert-success"><a href="musteri.php">Müşterinin Yeni Kayıdı Eklendi.</a> </div>
                    <?php }
                }

            if (isset($_POST['transportation_insert'])){

                $number=$db->qSql("SELECT musteri_id FROM `musteri` WHERE musteri_id='{$_GET['id']}' AND users_id='{$users_id}'");
                foreach ($number as $numbers){}

                if (isset($numbers['musteri_id'])){

                    if(isset($_SESSION['personel'])){
                        $id=$db->wreadb("personel","personel_id",$_SESSION['personel']['personel_id'],"users_id");
                        foreach ($id as $ids){}
                        $users_id=$ids['users_id'];

                        $_POST['personel_id']=$_SESSION['personel']['personel_id'];

                    }elseif (isset($_SESSION['users'])){
                        $users_id=$_SESSION['users']['users_id'];
                    }


                    $_POST['users_id']=$users_id;
                    $_POST['musteri_id']=$numbers['musteri_id'];
                    $_POST['transportation_datetime']=$date;





                    $sonuc=$db->insert("transportation",$_POST,
                        [
                            "form_name"=>"transportation_insert"
                        ]);

                }

                if ($sonuc){?>
                    <div class="alert alert-success">Başarıyla Sefer Eklendi.</div>
                <?php  }

            }




        if (isset($_GET['delete'])){
            $sonuc=$db->deletes("business","business_id",$_GET['delete_id'],"users_id",$users_id);

            if ($sonuc){?>
                <div class="alert alert-success">Başarıyla Silindi.</div>
            <?php }
        }

        if (isset($_GET['deleteis'])){
            $sonuc=$db->deletes("paid","paid_id",$_GET['delete_id'],"users_id",$users_id);

            if ($sonuc){?>
                <div class="alert alert-success">Başarıyla Silindi.</div>
            <?php }
        }

            if (isset($_GET['deletesefer'])){
                $sonuc=$db->deletes("transportation","transportation_id",$_GET['delete_id'],"users_id",$users_id);

                if ($sonuc){?>
                    <div class="alert alert-success">Başarıyla Silindi.</div>
                <?php }
            }

        if (isset($_GET['deletewage'])){
            $sonuc=$db->deletes("wage","wage_id",$_GET['delete_id'],"users_id",$users_id);

            if ($sonuc){?>
                <div class="alert alert-success">Başarıyla Silindi.</div>
            <?php }
        }

        if(isset($_POST['musteri_ode'])){


            $kontrol=$db->wread("musteri","musteri_id",$_GET['id'],"musteri_id");

            if ($kontrol->rowCount()==1){//musteri tablosundaki bu kişiye ait kayıt varsa kontrol

                    $veri=$db->qSql("SELECT SUM(business_fiyat) as tophesap FROM `business` WHERE users_id={$users_id} AND musteri_id={$_GET['id']} ");
                    $paid=$db->qSql("SELECT SUM(paid_odenen) as topodenen FROM `paid` WHERE users_id={$users_id} AND musteri_id={$_GET['id']} ");
                    $wagetop=$db->qSql("SELECT SUM(wage_birimfiyat) as wagebirim FROM `wage` WHERE users_id={$users_id} AND musteri_id={$_GET['id']} ");
                    $transportation=$db->qSql("SELECT transportation_adet,transportation_birimfiyat from transportation where (musteri_id={$_GET['id']}) and users_id={$users_id}");



                foreach ($veri as $veris){}
                foreach ($paid as $paids){}
                foreach ($wagetop as $wagetop){}
                foreach ($transportation as $transportations){
                    $transportationtop+=$transportations['transportation_adet']*$transportations['transportation_birimfiyat'];
                }



                if ($veris['tophesap']+$wagetop['wagebirim']+$transportationtop>$paids['topodenen']+$_POST['paid_odenen']){

                    $_POST['users_id']=$users_id;
                    if ($_SESSION['personel']){
                        $_POST['personel_id']=$_SESSION['personel']['personel_id'];
                    }
                    $_POST['musteri_id']=$_GET['id'];
                    $sonuc=$db->insert("paid",$_POST,[
                        "form_name"=>"musteri_ode"
                    ]);

                    if ($sonuc){?>
                        <div class="alert alert-success">Ödeme Başarılı</div>
                    <?php  }


                }elseif ($veris['tophesap']+$wagetop['wagebirim']+$transportationtop==$paids['topodenen']+$_POST['paid_odenen']){

                    $_POST['users_id']=$users_id;
                    if ($_SESSION['personel']){
                        $_POST['personel_id']=$_SESSION['personel']['personel_id'];
                    }
                    $_POST['musteri_id']=$_GET['id'];
                    $sonuc=$db->insert("paid",$_POST,[
                        "form_name"=>"musteri_ode"
                    ]);

                    if ($sonuc){?>
                        <div class="alert alert-success">Ödeme Başarılı</div>
                    <?php  }
                }else{?>
                    <div class="alert alert-danger">Girilen Değer Ana Hesaptan Büyüktür.</div>

                <?php }


            }
        }


                $veri=$db->qSql("SELECT business.business_id,business.personel_id,business.musteri_id,business.business_birimfiyat,business.business_moladk,business.business_baslangic,business.business_bitis,business.business_kacdk,business.business_fiyat FROM `business` WHERE business.users_id={$users_id} AND business.musteri_id={$_GET['id']} ORDER BY business.business_datetime DESC ");


                $odenen=$db->qSql("SELECT personel_id,paid_id,paid_odenen,paid_date from paid where (musteri_id={$_GET['id']}) and users_id={$users_id}");


                $wage=$db->wread("wage","musteri_id",$_GET['id'],"personel_id,wage_id,musteri_id,wage_isname,wage_birimfiyat,wage_datetime");



                $wagetop=$db->qSql("SELECT SUM(wage_birimfiyat) as wagebirim FROM `wage` WHERE users_id={$users_id} AND musteri_id={$_GET['id']} ");


            foreach ($wagetop as $wagetops){}

        }

        $transportation=$db->qSql("SELECT personel_id,transportation_id,transportation_acıklama,transportation_adet,transportation_birimfiyat,transportation_datetime from transportation where (musteri_id={$_GET['id']}) and users_id={$users_id}");

        ?>




        <?php
        if (isset($_GET['details_insert'])){?>

            <div class="row mb-2">


                <div class="col-lg-6 mb-2">
                    <div class="card h-100">
                        <h4 class="card-header">Saat Hesaplama</h4>
                        <div class="card-body">
                            <p class="card-text">Başlangıç Bitiş Saatini girip ve birim fiyatını girip hesaplamaya tıklayın.</p>
                            <form action="" method="post">


                                <div class="row mb-2">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="number" name="business_birimfiyat" placeholder="Ne kadara çalışağınızı birim fiyatıyla yazın">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="form-control" required type="datetime" id="date1" value="<?php echo $date;?>" name="business_baslangic">
                                        <small>Başlangıç Saati</small>
                                    </div>
                                    <div class="col-lg-12">
                                        <input class="form-control" required type="datetime"  id="date2"  value="<?php echo $date;?>" name="business_bitis" placeholder="Bitiş Saati">
                                        <small>Bitiş Saati</small>
                                    </div>

                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" type="datetime"  id="date5" name="mola_baslangic" placeholder="Mola verildiyse başlangıç saati">
                                    </div>
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" type="datetime"  id="date6" name="mola_bitis" placeholder="Mola verildiyse bitiş saati">
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        Başlangıç Saati:  <?php if (!empty($_POST['business_baslangic'])){ echo $_POST['business_baslangic'];} ?>  <br>
                                        Bitiş Saati: <?php if (!empty($_POST['business_bitis'])){ echo $_POST['business_bitis'];} ?><br>
                                        Çalışılan Saat: <?php if (isset($hesap['saatdk'])){ $saat=explode(".",$hesap['saatdk']/60);if($saat[1]){ $saat[1]="0.".$saat[1];  echo $saat[0].".".$saat[1]*60;}else{ echo $saat[0];} }?><br>
                                        Mola:<?php if (isset($_POST['business_moladk'])){  $saat=explode(".",$_POST['business_moladk']/60);if($saat[1]){ $saat[1]="0.".$saat[1];  echo $saat[0].".".$saat[1]*60;}else{ echo $saat[0];} }?><br>
                                        Fiyat: <?php if (isset($hesap['fiyat'])){ echo $hesap['fiyat'];}?>
                                    </div>
                                </div>


                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <button type="submit" name="saathesap"  class="btn btn-primary">Hesabı Hesapla</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="card h-100">
                        <h4 class="card-header">Yevmiye Ekle</h4>
                        <div class="card-body">
                            <p class="card-text">
                                Müşterinin telefon numarası sistemimizde kayıtlıysa hesabına kayıt edilir.<br>
                                Müşteri sayfasındanda yevmiye ekleyebilirsiniz.<br>
                                Yevmiye ekle buttonuna basmanız yeterlidir.Bugünün tarihini alarak ekleme yapar
                            </p>

                            <form action="" method="post">


                                <div class="row mb-2">
                                    <div class="col-lg-12">
                                        <input class="form-control"  type="text" name="wage_isname" placeholder="Yapılan İş">
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-lg-12">
                                        <input class="form-control"  type="number" name="wage_birimfiyat" placeholder="Ne kadara çalışağınızı birim fiyatıyla yazın">
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

            </div>


            <div class="row">

                <div class="col-lg-6">
                    <div class="card h-100">
                        <h4 class="card-header">Sefer Ekleme</h4>
                        <div class="card-body">
                            <p class="card-text">
                            </p>

                            <form action="" method="post">

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

                                <div class="row mb-2">
                                    <div class="col-lg-12">
                                        <input class="form-control"  type="text" name="transportation_birimfiyat" placeholder="Sefer Ücreti">
                                        <small>Doldurmak Zorunlu Değil</small>
                                    </div>
                                </div>
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








        <?php }
        ?>


        <!-- Marketing Icons Section -->
        <div class="row">


              <div class="col-lg-12">
          <div class="col-lg-6">

              Müşteri Adı Soyadı: <?php echo  $musteri_name=$veris['musteri_name'];?><br>
              Müşteri Numarası: <?php echo  $musteri_number=$veris['musteri_number'];?><br>
              Müşteri Adresi: <?php echo  $musteri_adres=$veris['musteri_adres'];?>

          </div>
              <div class="col-lg-6">
                  <form action="" method="post">
                      <td><input class="form-control form-control-sm" type="number" name="paid_odenen" placeholder="Ödeme Miktarı"></td>
                      <td><input class="btn btn-primary btn-sm" type="submit" name="musteri_ode" onclick="return confirm('Ödeme Yapılsın mı?')" value="Öde"></td>
                  </form>
              </div>
              </div>








<div class="col-lg-12">

    <div class="row">
        <div class="col-lg-12" align="right">
            <a class="btn btn-success btn-sm" href="details.php?id=<?php echo $_GET['id']?>&&details_insert" >Müşterinin Hesabına İş Ekle</a>
        </div>
    </div>
    <div class="table-responsive">
    <table class="table table-striped">

        <?php if($veri->rowCount()>0){ ?>
            <thead>
            <tr>
                <th scope="col">#</th>

                <?php if (isset($_SESSION['users'])){ ?>
                <th scope="col">Personel Adı Soyadı</th>
                <?php } ?>
                <th scope="col">Başlangıç Saati</th>
                <th scope="col">Bitiş Saati</th>
                <th scope="col">Birim Fiyat</th>
                <th scope="col">Çalışılan Saat</th>
                <th scope="col">Mola</th>
                <th scope="col">Hesap</th>
                <th scope="col"></th>

            </tr>
            </thead>
            <tbody>

            <?php
            $say=1;



            foreach ($veri as $veris){

                $hesap=$db->dkhesap($veris['business_baslangic'],$veris['business_bitis'],$veris['business_moladk']);
                $personel=$db->wread("personel","personel_id",$veris['personel_id'],"personel_name");
                foreach ($personel as $personels){}

                $topsaat+=$veris['business_kacdk'];
                ?>

                <tr>
                    <th scope="row"><?php echo $say++; ?></th>
                    <?php if (isset($_SESSION['users'])){ ?>
                    <td><a href="personel?personel_id=<?php echo $veris['personel_id']?>"><?php echo $personels['personel_name'];?></a></td>
                    <?php } ?>
                    <td><?php echo $veris['business_baslangic']; ?></td>
                    <td><?php echo $veris['business_bitis']; ?></td>
                    <td><?php echo $veris['business_birimfiyat']; ?></td>
                    <td><?php echo $db->saatshow($veris['business_kacdk']); ?></td>
                    <td><?php echo $db->saatshow($veris['business_moladk']); ?></td>
                    <td><?php echo $veris['business_fiyat']." TL"; ?></td>
                    <?php if (isset($_SESSION['users'])){ ?>
                    <td><a onclick="return confirm('Ödemesi Yapılsınmı?')" href="details?id=<?php echo $_GET['id']?>&&delete=ok&&delete_id=<?php echo $veris['business_id'];?>"><i class="fa fa-trash-o"></i></a></td>
                    <?php }else{?>
                        <td></td>
                   <?php } ?>
                </tr>



                <?php $topfiyat+=$veris['business_fiyat'];


                $pdf_export[]=$veris;
            } ?>


            </tbody>
        <?php } ?>


        <tfoot>

            <?php if (!empty($wage->rowCount()>0)){ ?>
        <thead>
        <tr>


            <th scope="col">#</th>
            <?php if (isset($_SESSION['users'])){ ?>
                <th scope="col">Personel Adı Soyadı</th>
            <?php } ?>
            <th scope="col"></th>

            <th scope="col">Yapılan İş</th>
            <th scope="col">Tarih</th>
            <th scope="col">Günlük Yevmiye</th>
            <th scope="col"></th>
            <th scope="col"></th>



        </tr>
        </thead>

        <tbody>

        <?php
        foreach ($wage as $wages){
            $topwage+=$wages['wage_birimfiyat'];
        $personel=$db->wread("personel","personel_id",$wages['personel_id'],"personel_name");
        foreach ($personel as $personels){}

        if (isset($_POST['wage_update'])){
            $kontrol=$db->wread("wage","wage_id",$_POST['wage_id'],"wage_id");
            if (isset($kontrol)){
                $sonuc=$db->update("wage",$_POST,[
                    "form_name"=>"wage_update",
                    "columns"=>"wage_id"
                ]);
                if ($sonuc){
                    header("Refresh: 0;");
                }
            }
        }

            ?>
        <tr>

            <th scope="row"><?php echo $say++; ?></th>
            <?php if (isset($_SESSION['users'])){ ?>
                <td><a href="personel?personel_id=<?php echo $wages['personel_id']?>"><?php echo $personels['personel_name'];?></a></td>
           <?php } ?>
            <td></td>

            <td><?php echo $wages['wage_isname']?></td>
            <td><?php echo $wages['wage_datetime']?></td>
            <?php
            if (empty($wages['wage_birimfiyat'])){?>
                <form action="" method="post">
                    <td><input class="form-control"  type="text" name="wage_birimfiyat" placeholder="Yevmiye Ücreti"><input class="form-control"  type="hidden" name="wage_id" value="<?php echo $wages['wage_id'];?>"><button type="submit" name="wage_update" class="btn btn-success">Yevmiye Ücretini Ekle</button></td>
                </form>
            <?php }else{
                ?>
            <td><?php echo $wages['wage_birimfiyat']?></td>
                <?php } ?>

            <td></td>
            <?php if (isset($_SESSION['users'])){?>
            <td><a onclick="return confirm('Ödemesi Yapılsınmı?')" href="details?id=<?php echo $_GET['id']?>&&deletewage=ok&&delete_id=<?php echo $wages['wage_id'];?>"><i class="fa fa-trash-o"></i></a></td>
        <?php }else{?>
                <td></td>
           <?php  } ?>
            <?php
            $pdf_exportwage[]=$wages;
        } ?>


        </tr>
        </tbody>

        <?php } ?>

        <tbody>

        </tbody>

        <?php if (!empty($odenen->rowCount()>0)){ ?>
        <thead>
        <tr>
            <th scope="col">#</th>
            <?php if (isset($_SESSION['users'])){ ?>
                <th scope="col">Personel Adı Soyadı</th>
            <?php } ?>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>

            <th scope="col">Tarih</th>
            <th scope="col">Ödenen Miktar</th>
            <th scope="col"></th>
        </tr>
        </thead>

        <tbody>

<?php
foreach ($odenen as $odenens){
    $personel=$db->wread("personel","personel_id",$odenens['personel_id'],"personel_name");
    foreach ($personel as $personels){}

    $topodenen+=$odenens['paid_odenen'];
if (!empty($topodenen)){



?>
    <tr>
        <th scope="row"><?php echo $say++; ?></th>
    <?php if (isset($_SESSION['users'])){ ?>
        <td><a href="personel?personel_id=<?php echo $odenens['personel_id']?>"><?php echo $personels['personel_name'];?></a></td>
        <?php } ?>
        <td></td>
        <td></td>
        <td></td>
        <td><?php echo $odenens['paid_date'];?></td>
        <td><?php echo $odenens['paid_odenen'];?></td>
        <?php if (isset($_SESSION['users'])){?>
        <td><a onclick="return confirm('Silmeyi Onaylıyormusunuz?')" href="details?id=<?php echo $_GET['id']?>&&deleteis=ok&&delete_id=<?php echo $odenens['paid_id'];?>"><i class="fa fa-trash-o"></i></a></td>
<?php  }else{?>
            <td></td>
       <?php } ?>
    </tr>

<?php

    $pdf_exportodenen[]=$odenens;


}}?>
        </tbody>

        <?php } ?>



        <?php if ($transportation->rowCount()>0){ ?>
        <thead>
        <tr>
            <th scope="col">#</th>
            <?php if (isset($_SESSION['users'])){ ?>
                <th scope="col">Personel Adı Soyadı</th>
            <?php } ?>
            <th scope="col">Sefer Açıklama</th>
            <th scope="col">Sefer Adet</th>
            <th scope="col">Sefer Birim Fiyat</th>
            <th scope="col">Sefer Tarih</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
        </thead>
        <?php } ?>

        <tbody>

        <?php

        foreach ($transportation as $transportations){
            $personel=$db->wread("personel","personel_id",$transportations['personel_id'],"personel_name");
            foreach ($personel as $personels){}

                ?>
                <tr>
                    <th scope="row"><?php echo $say++; ?></th>
                    <?php if (isset($_SESSION['users'])){ ?>
                        <td><a href="personel?personel_id=<?php echo $transportations['personel_id']?>"><?php if (!empty($transportations['personel_id'])){echo $personels['personel_name'];}?></a></td>
                    <?php } ?>
                    <td><?php echo $transportations['transportation_acıklama'];?></td>
                    <td><?php echo $transportations['transportation_adet']; $sefertop+=$transportations['transportation_adet']; ?></td>

                    <?php
                    if (isset($_POST['transportation_update'])){
                        $kontrol=$db->wread("transportation","transportation_id",$_POST['transportation_id'],"transportation_id");
                        if (isset($kontrol)){
                            $sonuc=$db->update("transportation",$_POST,[
                                "form_name"=>"transportation_update",
                                "columns"=>"transportation_id"
                            ]);
                            if ($sonuc){
                                header("Refresh: 0;");
                            }
                        }
                    }
                    if (empty($transportations['transportation_birimfiyat'])){?>
                        <form action="" method="post">
                        <td><input class="form-control"  type="text" name="transportation_birimfiyat" placeholder="Sefer Ücreti"><input class="form-control"  type="hidden" name="transportation_id" value="<?php echo $transportations['transportation_id'];?>"><button type="submit" name="transportation_update" class="btn btn-success">Seferi Ekle</button></td>
                        </form>
                   <?php }else{
                    ?>
                    <td><?php echo $transportations['transportation_birimfiyat'];$sefertophesap+=$transportations['transportation_birimfiyat']*$transportations['transportation_adet'];?></td>
                    <?php } ?>

                    <td><?php echo $transportations['transportation_datetime'];?></td>
                    <td></td>
                    <?php if (isset($_SESSION['users'])){?>
                        <td><a onclick="return confirm('Silmeyi Onaylıyormusunuz?')" href="details?id=<?php echo $_GET['id']?>&&deletesefer=ok&&delete_id=<?php echo $transportations['transportation_id'];?>"><i class="fa fa-trash-o"></i></a></td>
                    <?php  }else{?>
                        <td></td>
                    <?php } ?>
                </tr>

                <?php
            $pdf_exportransportation[]=$transportations;
        }
            ?>
        </tbody>



            <td></td>
            <td></td>
            <td></td>

        <td></td>
            <form action="export" method="post">
                <?php
                $id=0;
                if (!empty($pdf_export)){
                foreach ($pdf_export as $pdf_exports){?>

                    <input type="hidden" name="business_baslangic-<?php echo $id;?>" value="<?php echo $pdf_exports['business_baslangic'];?>">
                    <input type="hidden" name="business_bitis-<?php echo $id;?>" value="<?php echo $pdf_exports['business_bitis'];?>">
                    <input type="hidden" name="business_birimfiyat-<?php echo $id;?>" value="<?php echo $pdf_exports['business_birimfiyat'];?>">
                    <input type="hidden" name="business_kacdk-<?php echo $id;?>" value="<?php echo $db->saatshow($pdf_exports['business_kacdk']);?>">
                    <input type="hidden" name="business_moladk-<?php echo $id;?>" value="<?php echo $db->saatshow($pdf_exports['business_moladk']);?>">
                    <input type="hidden" name="business_fiyat-<?php echo $id;?>" value="<?php echo $pdf_exports['business_fiyat']." TL";?>">

               <?php $id++; }}

                $ids=0;
              if (!empty($pdf_exportodenen)){
                  foreach ($pdf_exportodenen as $pdf_exportodenens){?>
                      <input type="hidden" name="paid_date-<?php echo $ids;?>" value="<?php echo $pdf_exportodenens['paid_date'];?>">
                      <input type="hidden" name="paid_odenen-<?php echo $ids;?>" value="<?php echo $pdf_exportodenens['paid_odenen'];?>">

                <?php $ids++;  }} ?>

                <?php

                $idss=0;
                if (!empty($pdf_exportwage)){
                foreach ($pdf_exportwage as $pdf_exportwages){?>
                <input type="hidden" name="wage_isname-<?php echo $idss;?>" value="<?php echo $pdf_exportwages['wage_isname'];?>">
                <input type="hidden" name="wage_birimfiyat-<?php echo $idss;?>" value="<?php echo $pdf_exportwages['wage_birimfiyat'];?>">
                <input type="hidden" name="wage_datetime-<?php echo $idss;?>" value="<?php echo $pdf_exportwages['wage_datetime'];?>">

                <?php $idss++;  }} ?>

                <?php
                $idsss=0;
                if (!empty($pdf_exportransportation)){
                    foreach ($pdf_exportransportation as $pdf_exportransportations){?>
                        <input type="hidden" name="transportation_acıklama-<?php echo $idsss;?>" value="<?php echo $pdf_exportransportations['transportation_acıklama'];?>">
                        <input type="hidden" name="transportation_adet-<?php echo $idsss;?>" value="<?php echo $pdf_exportransportations['transportation_adet'];?>">
                        <input type="hidden" name="transportation_birimfiyat-<?php echo $idsss;?>" value="<?php echo $pdf_exportransportations['transportation_birimfiyat'];?>">
                        <input type="hidden" name="transportation_datetime-<?php echo $idsss;?>" value="<?php echo $pdf_exportransportations['transportation_datetime'];?>">
                    <?php $idsss++; }
                }
                ?>






                <input type="hidden" name="say2" value="<?php echo $ids;?>">
                <input type="hidden" name="say3" value="<?php echo $idss;?>">
                <input type="hidden" name="say4" value="<?php echo $idsss;?>">
                <input type="hidden" name="topodenen" value="<?php echo $topodenen;?>">
                <input type="hidden" name="topwage" value="<?php echo $topwage;?>">


                <input type="hidden" name="say" value="<?php echo $id;?>">
                <input type="hidden" name="musteri_name" value="<?php echo $musteri_name;?>">
                <input type="hidden" name="musteri_number" value="<?php echo $musteri_number;?>">
                <input type="hidden" name="topfiyat" value="<?php echo $topfiyat;?>">
                <input type="hidden" name="topsaat" value="<?php  $saat=explode(".",$topsaat/60);if($saat[1]){ $saat[1]="0.".$saat[1];  echo $saat[0].".".$saat[1]*60;}else{ echo $saat[0];}  ?>">


                <input type="hidden" name="sefertop" value="<?php echo $sefertop;?>">
                <input type="hidden" name="sefertophesap" value="<?php echo $sefertophesap;?>">




                <td>Toplam Sefer:<?php echo $sefertop;?></td>
                <td>Toplam Saat:<?php $saat=explode(".",$topsaat/60);if($saat[1]){ $saat[1]="0.".$saat[1];  echo $saat[0].".".$saat[1]*60;}else{ echo $saat[0];}  ?></td>

            <td>Toplam Hesap:<?php echo abs(($topfiyat+$wagetops['wagebirim']+$sefertophesap)-$topodenen)."TL";?></td>
            <td><button type="submit" class="btn btn-primary btn-sm">Görüntüle</button></td>
            </form>
            </tfoot>

    </table>
    </div>
</div>


        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->


    <div class="row">


    </div>
    <!-- /.container -->


<?php require_once 'footer.php';?>


