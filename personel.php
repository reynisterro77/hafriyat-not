<?php require_once 'header.php';?>

    <!-- Page Content -->
    <div style="height: auto;" class="container">


        <h1 class="my-4">Personellerim</h1>


        <?php

        if($_GET['delete']==="ok"){//Silme işleminde kontrol yap
            $delete=$db->deletes("personel","personel_id",$_GET['delete_id'],"users_id",$users_id);
            if ($delete){?>
                <div class="alert alert-success">Başarıyla Silindi.</div>
            <?php }
        }

        if (isset($_POST['personel_insert'])){

            $number=$db->qSql("SELECT personel_kadi FROM `personel` WHERE personel_kadi='{$_POST['personel_kadi']}'");

            if ($number->rowCount()==0){

                $_POST['personel_name']=$_POST['personel_name']." ".$_POST['personel_surname'];
                unset($_POST['personel_surname']);
                $_POST['users_id']=$_SESSION['users']['users_id'];

                $sonuc=$db->insert("personel",$_POST,[

                    "form_name"=>"personel_insert"
                ]);
                if ($sonuc){?>
                    <div class="alert alert-success">Kayıt Başarılı</div>
                <?php  }
            }else{?>
                <div class="alert alert-danger">Bu kullanıcı adı sistemde kayıtlı.</div>
            <?php }
        }

        if (isset($_GET['personel_update'])){
            $veri=$db->wread("personel","personel_id",$_GET['id'],"personel_id,personel_kadi,personel_pass,personel_name,personel_number,personel_gorev,personel_datetime");
            foreach ($veri as $veris) {
            }
        }

        if (isset($_POST['personel_update'])) {

            $number = $db->qSql("SELECT personel_kadi,personel_id FROM `personel` WHERE personel_kadi='{$_POST['personel_kadi']}'");

            if ($number->rowCount() == 0) {

                if(empty($_POST['personel_kadi'])){
                    unset($_POST['personel_kadi']);
                }
                $_POST['personel_name']=$_POST['personel_name']." ".$_POST['personel_surname'];
                unset($_POST['personel_surname']);

                $_POST['personel_id']=$veris['personel_id'];

                $sonuc=$db->update("personel",$_POST,
                    [
                        "form_name"=>"personel_update",
                        "columns"=>"personel_id",
                    ]);
                if ($sonuc){?>
                    <div class="alert alert-success">Güncelleme Başarılı</div>
                <?php header('Refresh: 1; url=personel');  }
            }else{?>
                <div class="alert alert-danger">Kullanıcı Adı Sistemimizde kayıtlı</div>
            <?php }
            }

        if(isset($_GET['personel_id'])){
            $business=$db->wread("business","personel_id",$_GET['personel_id'],"business_id,musteri_id,business_birimfiyat,business_moladk,business_baslangic,business_bitis,business_kacdk,business_fiyat");
            $paidshow=$db->wread("paid","personel_id",$_GET['personel_id'],"paid_id,musteri_id,paid_odenen,paid_date");
            $wageshow=$db->wread("wage","personel_id",$_GET['personel_id'],"wage_id,musteri_id,wage_isname,wage_birimfiyat,wage_datetime");
            $sefershow=$db->wread("transportation","personel_id",$_GET['personel_id'],"musteri_id,transportation_acıklama,transportation_adet,transportation_birimfiyat,transportation_datetime");

            ?>

            <div class="row">

                <?php if ($business->rowCount()>0){?>
                <div class="col-lg-12">
                    Yaptığı İşler
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Müşteri Adı Soyadı</th>
                                <th scope="col">Müşteri Numarası</th>
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
                            <?php $say=1; foreach ($business as $businesss){

                                $musteri=$db->wread("musteri","musteri_id",$businesss['musteri_id'],"musteri_name,musteri_number");
                                foreach ($musteri as $musteris){}
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $say++; ?></th>
                                    <td><?php echo $musteris['musteri_name'];?></td>
                                    <td><?php echo $musteris['musteri_number'];?></td>
                                    <td><?php echo $businesss['business_baslangic']; ?></td>
                                    <td><?php echo $businesss['business_bitis']; ?></td>
                                    <td><?php echo $businesss['business_birimfiyat']; ?></td>
                                    <td><?php echo $businesss['business_kacdk']/60; ?></td>
                                    <td><?php echo $businesss['business_moladk']/60; ?></td>
                                    <td><?php echo $businesss['business_fiyat']." TL"; ?></td>
                                    <td><a class="btn btn-outline-success btn-sm" href="detay-<?php echo $businesss['musteri_id'];?>">Detay</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php } ?>

                <?php if ($wageshow->rowCount()>0){?>
                <div class="col-lg-12">
                    Yevmiyeler
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Müşteri Adı Soyadı</th>
                                <th scope="col">Müşteri Numarası</th>
                                <th scope="col">Yapılan İş</th>
                                <th scope="col">Tarih</th>
                                <th scope="col">Günlük Yevmiye</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $say=1; foreach ($wageshow as $wageshows){
                                $musteri=$db->wread("musteri","musteri_id",$wageshows['musteri_id'],"musteri_name,musteri_number");
                                foreach ($musteri as $musteris){}
                                ?>
                            <tr>

                                <th scope="row"><?php echo $say++; ?></th>
                                <td><?php echo $musteris['musteri_name'];?></td>
                                <td><?php echo $musteris['musteri_number'];?></td>
                                <td><?php echo $wageshows['wage_isname']?></td>
                                <td><?php echo $wageshows['wage_datetime']?></td>
                                <td><?php echo $wageshows['wage_birimfiyat']?></td>
                                <td><a class="btn btn-outline-success btn-sm" href="detay-<?php echo $wageshows['musteri_id'];?>">Detay</td>


                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php } ?>


                <?php if ($sefershow->rowCount()>0){?>
                <div class="col-lg-12">
                    Seferler
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Müşteri Adı Soyadı</th>
                                <th scope="col">Müşteri Numarası</th>
                                <th scope="col">Sefer Açıklama</th>
                                <th scope="col">Sefer Adet</th>
                                <th scope="col">Sefer Birim Fiyat</th>
                                <th scope="col">Sefer Tarih</th>
                                <th scope="col">Hesap</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $say=1; foreach ($sefershow as $sefershows){
                                $musteri=$db->wread("musteri","musteri_id",$sefershows['musteri_id'],"musteri_name,musteri_number");
                                foreach ($musteri as $musteris){}
                                ?>
                                <tr>

                                    <th scope="row"><?php echo $say++; ?></th>
                                    <td><?php echo $musteris['musteri_name'];?></td>
                                    <td><?php echo $musteris['musteri_number'];?></td>
                                    <td><?php echo $sefershows['transportation_acıklama']?></td>
                                    <td><?php echo $sefershows['transportation_adet']?></td>
                                    <td><?php echo $sefershows['transportation_birimfiyat']?></td>
                                    <td><?php echo $sefershows['transportation_datetime']?></td>
                                    <td><?php echo $sefershows['transportation_adet']*$sefershows['transportation_birimfiyat']." "."TL"; ?></td>
                                    <td><a class="btn btn-outline-success btn-sm" href="detay-<?php echo $sefershows['musteri_id'];?>">Detay</td>


                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php } ?>

                <?php if ($paidshow->rowCount()>0){?>
                <div class="col-lg-12">
                    Yapılan Ödemeler
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>

                                <th scope="col">#</th>
                                <th scope="col">Müşteri Adı Soyadı</th>
                                <th scope="col">Müşteri Numarası</th>
                                <th scope="col">Tarih</th>
                                <th scope="col">Ödenen Miktar</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $say=1; foreach ($paidshow as $paidshows){
                                $musteri=$db->wread("musteri","musteri_id",$paidshows['musteri_id'],"musteri_name,musteri_number");
                                foreach ($musteri as $musteris){}?>
                                <tr>
                                    <th scope="row"><?php echo $say++; ?></th>
                                    <td><?php echo $musteris['musteri_name'];?></td>
                                    <td><?php echo $musteris['musteri_number'];?></td>
                                    <td><?php echo $paidshows['paid_date'];?></td>
                                    <td><?php echo $paidshows['paid_odenen'];?></td>
                                    <td><a class="btn btn-outline-success btn-sm" href="detay-<?php echo $paidshows['musteri_id'];?>">Detay</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php } ?>

            </div>

        <?php } ?>





        <?php if (isset($_GET['personel_insert'])){ ?>
        <div class="row">

            <div class="col-lg-6">
                <form action="" method="post">

                    <div class="form-group">
                        <input class="form-control" type="text" required name="personel_kadi" placeholder="Personel Kullanıcı Adı">
                        <input class="form-control" type="text" required name="personel_pass" placeholder="Personel Password">
                    </div>

                    <div class="form-group">
                            <input class="form-control" type="text" required name="personel_name" placeholder="Personel Adı">
                            <input class="form-control" type="text" required name="personel_surname" placeholder="Personel Soyadı">
                    </div>

                    <div class="form-group">
                        <input class="form-control" type="text" required name="personel_gorev" placeholder="Personel Görevi">
                    </div>

                    <div class="form-group">
                            <input class="form-control" type="text"  required  id="phone1" name="personel_number" placeholder="Personel Telefon Numarası">
                    </div>

                    <button type="submit"  class="btn btn-primary" name="personel_insert">Personeli Kaydet</button>
                </form>
            </div>

        </div>

        <?php } ?>

        <?php if (isset($_GET['personel_update'])){ ?>
            <div class="row">

                <div class="col-lg-6">
                    <form action="" method="post">

                        <div class="form-group">
                            <input class="form-control" type="text"  name="personel_kadi" placeholder="<?php echo $veris['personel_kadi'];?>">
                            <input class="form-control" type="text"  name="personel_pass" value="<?php echo $veris['personel_pass'];?>">
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text"  name="personel_name" value="<?php $personel_name=explode(' ',$veris['personel_name']);echo $personel_name[0];?>">
                            <input class="form-control" type="text"  name="personel_surname" value="<?php $personel_name=explode(' ',$veris['personel_name']);echo $personel_name[1];?>">
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text"  name="personel_gorev" value="<?php echo $veris['personel_gorev'];?>">
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text"   id="phone1" name="personel_number" value="<?php echo $veris['personel_number'];?>">
                        </div>

                        <button type="submit"  class="btn btn-primary" name="personel_update">Güncelle</button>
                    </form>
                </div>

            </div>

        <?php } ?>

        <!-- Marketing Icons Section -->
        <div class="row">

        <div class="col-lg-12">

            <div class="row">
                <div class="col-lg-12" align="right"><a class="btn btn-success btn-sm" href="?personel_insert">Yeni Personel Ekle</a> </div>
            </div>
            <div class="table-responsive">
            <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Adı Soyadı</th>
                        <th scope="col">Numarası</th>
                        <th scope="col">Görevi</th>
                        <th scope="col">Çalıştığı Saat</th>
                        <th scope="col"> </th>
                        <th scope="col"> </th>
                        <th scope="col"> </th>

                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $veri=$db->qSql("SELECT SUM(business.business_fiyat) as topfiyat,personel.personel_id,personel.personel_kadi,personel.personel_pass,personel.personel_name,personel.personel_number,personel.personel_gorev,business.musteri_id FROM `personel` LEFT JOIN business ON personel.personel_id=business.personel_id WHERE personel.users_id={$_SESSION['users']['users_id']} GROUP BY personel.personel_id ");

                    $say=1;
                    foreach ($veri as $veris){
                        $paid=$db->qSql("SELECT SUM(paid_odenen) as topodenen FROM `paid` WHERE users_id={$_SESSION['users']['users_id']} AND personel_id={$veris['personel_id']} ");
                        foreach ($paid as $paids){}

                        $wage=$db->qSql("SELECT SUM(wage_birimfiyat) as wagebirim FROM `wage` WHERE users_id={$_SESSION['users']['users_id']} AND personel_id={$veris['personel_id']} ");

                        $seferveri=$db->qSql("SELECT transportation_adet,transportation_birimfiyat  FROM transportation WHERE users_id={$_SESSION['users']['users_id']} AND personel_id={$veris['personel_id']} ");

                        foreach ($wage as $wages){
                        }

                        $topsefer=0;
                        foreach ($seferveri as $seferveris){
                            $topsefer+=$seferveris['transportation_adet']*$seferveris['transportation_birimfiyat'];
                        }




                        if (empty($wages['wagebirim'])){
                            $wages['wage_birimfiyat']=0;
                        }
                        ?>

                        <tr>
                            <th scope="row"><?php echo $say++; ?></th>
                            <td><?php echo $veris['personel_name'] ;?></td>
                            <td><?php echo $veris['personel_number'] ;?></td>
                            <td><?php echo substr($veris['personel_gorev'],0,30) ;?></td>
                            <td height="50"><?php if (($veris['topfiyat']+$wages['wagebirim']+$topsefer)-$paids['topodenen']>0){?><a href="?personel_id=<?php echo $veris['personel_id']; ?>"><button class="btn btn-outline-success btn-sm">Kazancı:<?php echo (($veris['topfiyat']+$wages['wagebirim']+$topsefer)-$paids['topodenen'])." TL"; ?>(Tümü)</button></a> <?php }?></td>
                            <td><a href="?personel_update&&id=<?php echo $veris['personel_id'];?>"><i class="fa fa-user-circle-o" aria-hidden="true"></i></a></td>
                            <td><a href="?personel_id=<?php echo $veris['personel_id']; ?>"><i class="fa fa-address-book-o" aria-hidden="true"></i></a></td>
                            <td><a onclick="return confirm('Müşteri Silinmesini istiyormusunuz?')" href="?delete=ok&&delete_id=<?php echo $veris['personel_id'];?>"><i class="fa fa-trash-o"></i></a></td>

                        </tr>

                    <?php } ?>


                    </tbody>
            </table>
            </div>
        </div>

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

<?php require_once 'footer.php';?>



