<?php require_once 'header.php';?>

    <!-- Page Content -->
    <div style="height: auto;" class="container">

        <?php
            require_once 'saathesap.php';


        if (isset($_SESSION['users'])) {
            $veri=$db->qSql("SELECT musteri.musteri_name,musteri.musteri_number,business.musteri_id,business.business_kacdk,business.business_fiyat FROM `business` INNER JOIN musteri ON musteri.musteri_id=business.musteri_id WHERE musteri.users_id={$users_id} ORDER BY business.business_datetime DESC ");
            $wageveri=$db->reada("wage","wage_id,musteri_id,wage_isname,wage_birimfiyat,wage_datetime",
                [
                    "columns_name"=>"wage_datetime",
                    "columns_sort"=>"DESC"

                ]);

            $seferveri=$db->reada("transportation","musteri_id,transportation_acıklama,transportation_adet,transportation_birimfiyat,transportation_datetime",
                [
                    "columns_name"=>"transportation_datetime",
                    "columns_sort"=>"DESC"

                ]);

        }elseif (isset($_SESSION['personel'])){
            $veri=$db->qSql("SELECT musteri.musteri_name,musteri.musteri_number,business.musteri_id,business.business_kacdk,business.business_fiyat FROM `business` INNER JOIN musteri ON musteri.musteri_id=business.musteri_id WHERE musteri.users_id={$users_id} AND business.personel_id={$_SESSION['personel']['personel_id']}  ORDER BY business.business_datetime DESC ");
            $wageveri=$db->wread("wage","personel_id",$_SESSION['personel']['personel_id'],"wage_id,musteri_id,wage_isname,wage_birimfiyat,wage_datetime");
            $seferveri=$db->wread("transportation","personel_id",$_SESSION['personel']['personel_id'],"musteri_id,transportation_acıklama,transportation_adet,transportation_birimfiyat,transportation_datetime");
        }



        $musteri=$db->reada("musteri","musteri_id,musteri_number,musteri_name",
            [
                "columns_name"=>"musteri_name",
                "columns_sort"=>"ASC"
            ]);
        foreach ($musteri as $musteris){
            $musteriveri[]=$musteris;
        }

        ?>


        <h1 class="my-4">Son Yapılan İşler</h1>


        <?php if (isset($_GET['sonis_insert'])){ ?>
            <div class="row">
                <!--
                <div class="col-lg-6 mb-2">
                    <div class="card h-100">
                        <h4 class="card-header">Otomatik Saat Hesaplama</h4>
                        <div class="card-body">
                            <p class="card-text">
                                Girilen Müşteri Numarası Sistemimizde Kayıtlı değilse Yeni Müşteri Kayıtı Açılır.<br>
                                Numara Sistemimizde Kayıtlıysa hesabına eklenir.<br>
                                Numara Yazmamışsanız Saati Hesaplar.

                            </p>
                            <form action="" method="post">

                                <div class="row mb-2">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" name="musteri_name" placeholder="Müşteri Adı Soyadı">
                                        <smal>Doldurmak zorunlu değil</smal>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" id="phone1" name="musteri_number" placeholder="Müşteri Telefon Numarası">
                                        <smal>Doldurmak zorunlu değil</smal>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" name="musteri_adres" placeholder="Adres">
                                        <smal>Doldurmak zorunlu değil</smal>
                                    </div>
                                </div>


                                <div class="row mb-2">
                                    <div class="col-lg-12">
                                        <input class="form-control"  type="number" name="business_birimfiyat" placeholder="Ne kadara çalışağınızı birim fiyatıyla yazın">
                                    </div>

                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" type="datetime"  id="date5" name="mola_baslangic" placeholder="Mola verildiyse başlangıç saati">
                                    </div>
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" type="datetime"  id="date6" name="mola_bitis" placeholder="Mola verildiyse başlangıç saati">
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        Başlangıç Saati:  <?php if (!empty($_COOKIE['otosaat'])){ echo $_COOKIE['otosaat'];} ?>  <br>
                                        Bitiş Saati: <?php if (!empty($_COOKIE['otosaatbitis'])){ echo $_COOKIE['otosaatbitis'];} ?><br>
                                        Çalışılan Saat: <?php if (isset($hesap['saatdk'])){ echo $hesap['saatdk']/60;}?><br>
                                        Mola:<?php if (isset($_POST['business_moladk'])){ echo $_POST['business_moladk']/60 ;}?><br>
                                        Fiyat: <?php if (isset($hesap['fiyat'])){ echo $hesap['fiyat'];}?>
                                    </div>
                                </div>




                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <button type="submit" name="otosaat" class="btn btn-success">Saat için Tıkla</button>
                                <button type="submit" name="otosaathesap"  class="btn btn-primary">Hesabı Hesapla</button>
                                <button type="submit" name="otosaatdelete"  class="btn btn-warning">Saatleri Temizleme</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>-->


                <div class="col-lg-6 mb-2">
                    <div class="card h-100">
                        <h4 class="card-header">Saat Hesaplama</h4>
                        <div class="card-body">
                            <p class="card-text">
                                Girilen Müşteri Numarası Sistemimizde Kayıtlı değilse Yeni Müşteri Kayıtı Açılır.<br>
                                Numara Sistemimizde Kayıtlıysa hesabına eklenir.<br>
                                Numara Yazmamışsanız Saati Hesaplar.
                            </p>
                            <form action="" method="post">


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
                                        <input class="form-control" type="text" type="datetime"  id="date3" name="mola_baslangic" placeholder="Mola verildiyse başlangıç saati">
                                    </div>
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" type="datetime"  id="date4" name="mola_bitis" placeholder="Mola verildiyse bitiş saati">
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

            </div>

        <?php } ?>

        <!-- Marketing Icons Section -->
        <div class="row">

            <div class="col-lg-12">


            <div class="row">
                <div class="col-lg-12" align="right"><a class="btn btn-success btn-sm" href="?sonis_insert">Yeni İş Ekle</a> </div>
            </div>
                <?php if ($veri->rowCount()>0){ ?>
                <div class="table-responsive">
            <table class="table table-striped">

                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Adı Soyadı</th>
                        <th scope="col">Numarası</th>
                        <th scope="col">Çalışılan Saat</th>
                        <th scope="col">Hesap</th>
                        <th width="50px" scope="col"></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $say=1;
                    foreach ($veri as $veris){
                        ?>

                        <tr>
                            <th width="50" scope="row"><?php echo $say++; ?></th>
                            <td><?php echo $veris['musteri_name']; ?></td>
                            <td><?php echo $veris['musteri_number']; ?></td>
                            <td><?php echo $veris['business_kacdk']/60; ?></td>
                            <td><?php echo $veris['business_fiyat']." TL"; ?></td>
                            <?php if (isset($_SESSION['users'])){ ?>
                            <td width="50px"><a class="btn btn-success btn-sm" href="detay-<?php echo $veris['musteri_id'];?>">Detay</a></td>
                            <?php }else{?>
<td></td>
                           <?php } ?>
                        </tr>

                    <?php } ?>


                    </tbody>

            </table>
                </div>
                <?php } ?>

            </div>

            <?php if ($wageveri->rowCount()>0){ ?>
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped">

                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Yapılan İş</th>
                            <th scope="col">Günlük Yevmiye</th>
                            <th scope="col">Tarih</th>
                            <th width="50px" scope="col"></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $say=1;
                        foreach ($wageveri as $veris){
                            ?>

                            <tr>
                                <th width="50" scope="row"><?php echo $say++; ?></th>
                                <td><?php echo $veris['wage_isname']; ?></td>
                                <td><?php echo $veris['wage_birimfiyat']; ?></td>
                                <td><?php echo $veris['wage_datetime']; ?></td>
                                <?php if (isset($_SESSION['users'])){ ?>
                                <td width="50px"><a class="btn btn-success btn-sm" href="detay-<?php echo $veris['musteri_id'];?>">Detay</a></td>
                                <?php }else{?>
                                    <td></td>
                                <?php } ?>
                            </tr>

                        <?php } ?>


                        </tbody>

                    </table>
                </div>
            </div>
            <?php } ?>

            <?php if ($seferveri->rowCount()>0){ ?>
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped">

                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Sefer Açıklama</th>
                            <th scope="col">Sefer Adeti</th>
                            <th scope="col">Sefer Tarih</th>
                            <th scope="col">Hesap</th>
                            <th width="50px" scope="col"></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $say=1;
                        foreach ($seferveri as $veris){
                            ?>

                            <tr>
                                <th width="50" scope="row"><?php echo $say++; ?></th>
                                <td><?php echo $veris['transportation_acıklama']; ?></td>
                                <td><?php echo $veris['transportation_adet']; ?></td>
                                <td><?php echo $veris['transportation_datetime']; ?></td>
                                <td><?php echo $veris['transportation_adet']*$veris['transportation_birimfiyat']." "."TL"; ?></td>
                                <?php if (isset($_SESSION['users'])){ ?>
                                    <td width="50px"><a class="btn btn-success btn-sm" href="detay-<?php echo $veris['musteri_id'];?>">Detay</a></td>
                                <?php }else{?>
                                    <td></td>
                                <?php } ?>
                            </tr>

                        <?php } ?>


                        </tbody>

                    </table>
                </div>
            </div>
            <?php } ?>

       


        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

<?php require_once 'footer.php';?>


