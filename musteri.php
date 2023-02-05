<?php require_once 'header.php';
if(isset($_SESSION['users'])){
}else{
    header("location:index");
    exit();
}
?>

    <!-- Page Content -->
    <div style="height: auto;" class="container">


        <h1 class="my-4">Müşterilerim</h1>


        <?php
        if (isset($_SESSION['users'])){
        if($_GET['delete']==="ok"){//Silme işleminde kontrol yap
            $delete=$db->deletes("musteri","musteri_id",$_GET['delete_id'],"users_id",$_SESSION['users']['users_id']);
            $deletea=$db->deletes("business","musteri_id",$_GET['delete_id'],"users_id",$_SESSION['users']['users_id']);
            $deleteb=$db->deletes("paid","musteri_id",$_GET['delete_id'],"users_id",$_SESSION['users']['users_id']);
            $deleted=$db->deletes("wage","musteri_id",$_GET['delete_id'],"users_id",$_SESSION['users']['users_id']);
            $transportationdelete=$db->deletes("transportation","musteri_id",$_GET['delete_id'],"users_id",$_SESSION['users']['users_id']);
            if ($delete){?>
                <div class="alert alert-success">Başarıyla Silindi.</div>
            <?php }
        }

        if($_GET['odeme']==="ok") {
            $deleteb=$db->deletes("paid","musteri_id",$_GET['id'],"users_id",$_SESSION['users']['users_id']);
            $businessdelete=$db->deletes("business","musteri_id",$_GET['id'],"users_id",$_SESSION['users']['users_id']);
            $deleteb=$db->deletes("paid","musteri_id",$_GET['id'],"users_id",$_SESSION['users']['users_id']);
            $deleted=$db->deletes("wage","musteri_id",$_GET['id'],"users_id",$_SESSION['users']['users_id']);
            $transportationdelete=$db->deletes("transportation","musteri_id",$_GET['id'],"users_id",$_SESSION['users']['users_id']);
            if ($businessdelete){?>
                <div class="alert alert-success">Ödeme İşlemi Gerçekleşti</div>
            <?php }
        }
        }

        if (isset($_POST['musteri_insert'])){


                $number=$db->qSql("SELECT musteri_number,users_id FROM `musteri` WHERE musteri_number='{$_POST['musteri_number']}' AND users_id='{$users_id}'");

            if ($number->rowCount()==0){
                $sonuc=$db->insert("musteri",$_POST,[

                    "form_name"=>"musteri_insert",
                    "users_id"=>$users_id
                ]);
                if ($sonuc){?>
                    <div class="alert alert-success">Kayıt Başarılı</div>
                <?php  }
            }else{?>
                <div class="alert alert-danger">Müşteri Numarası Sistemimizde kayıtlı</div>
            <?php }
        }

        if (isset($_GET['musteri_update'])){
            $veri=$db->wread("musteri","musteri_id",$_GET['id'],"musteri_id,musteri_name,musteri_number,musteri_adres");
            foreach ($veri as $veris) {
            }
        }

        if (isset($_POST['musteri_update'])) {

            if (empty($_POST['musteri_number'])){
                unset($_POST['musteri_number']);
            }

            $number = $db->qSql("SELECT musteri_number FROM `musteri` WHERE musteri_number='{$_POST['musteri_number']}' AND users_id='{$users_id}'");

            if ($number->rowCount() == 0) {

                $_POST['musteri_id']=$veris['musteri_id'];
                $sonuc=$db->update("musteri",$_POST,
                    [
                        "form_name"=>"musteri_update",
                        "columns"=>"musteri_id",
                    ]);
                if ($sonuc){?>
                    <div class="alert alert-success">Güncelleme Başarılı</div>
                <?php header('Refresh: 1; url=musteri');  }
            }else{?>
                <div class="alert alert-danger">Müşteri Numarası Sistemimizde kayıtlı</div>
            <?php }
            }




            ?>


        <?php if (isset($_GET['musteri_insert'])){ ?>
        <div class="row">

            <div class="col-lg-6">
                <form action="" method="post">

                    <div class="form-group">
                            <input class="form-control" type="text" required name="musteri_name" placeholder="Müşteri Adı Soyadı">
                    </div>

                    <div class="form-group">
                            <input class="form-control" type="text"  required  id="phone1" name="musteri_number" placeholder="Müşteri Telefon Numarası">
                    </div>

                    <div class="form-group">
                            <input class="form-control" type="text" name="musteri_adres" placeholder="Adres">
                    </div>

                    <button type="submit"  class="btn btn-primary" name="musteri_insert" >Kaydet</button>
                </form>
            </div>

        </div>

        <?php } ?>

        <?php if (isset($_GET['musteri_update'])){ ?>
            <div class="row">

                <div class="col-lg-6">
                    <form action="" method="post">

                        <div class="form-group">
                            <input class="form-control" type="text" required name="musteri_name" value="<?php echo $veris['musteri_name']; ?>">
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" id="phone1" name="musteri_number" placeholder="<?php echo $veris['musteri_number']; ?>">
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="text" name="musteri_adres" value="<?php echo $veris['musteri_adres']; ?>">
                        </div>

                        <button type="submit"  class="btn btn-primary" name="musteri_update" >Güncelle</button>
                    </form>
                </div>

            </div>

        <?php } ?>

        <!-- Marketing Icons Section -->
        <div class="row">

        <div class="col-lg-12">

            <div class="row">
                <div class="col-lg-12" align="right"><a class="btn btn-success btn-sm" href="?musteri_insert">Yeni Müşteri Ekle</a> </div>
            </div>
            <div class="table-responsive">
            <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Adı Soyadı</th>
                        <th scope="col">Numarası</th>
                        <th scope="col">Adres</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php

                        $veri=$db->qSql("SELECT SUM(business.business_fiyat) as topfiyat,musteri.musteri_id,musteri.musteri_name,musteri.musteri_number,musteri.musteri_adres FROM `musteri` LEFT JOIN business ON musteri.musteri_id=business.musteri_id WHERE musteri.users_id={$users_id} GROUP BY musteri.musteri_id ORDER BY musteri.musteri_name ASC ");



                    $say=1;
                    foreach ($veri as $veris){

                        $paid = $db->qSql("SELECT SUM(paid_odenen) as topodenen FROM `paid` WHERE users_id={$users_id} AND musteri_id={$veris['musteri_id']} ");
                        $wage = $db->qSql("SELECT SUM(wage_birimfiyat) as wagebirim FROM `wage` WHERE users_id={$users_id} AND musteri_id={$veris['musteri_id']} ");
                        $seferveri=$db->qSql("SELECT transportation_adet,transportation_birimfiyat  FROM transportation WHERE users_id={$users_id} AND musteri_id={$veris['musteri_id']}");
                        $wagesayi = $db->qSql("SELECT wage_birimfiyat  FROM `wage` WHERE users_id={$users_id} AND musteri_id={$veris['musteri_id']} ");



                        foreach ($paid as $paids) {
                        }
                        foreach ($wage as $wages) {
                        }

                        foreach ($wagesayi as $wagesayis){
                            if (empty($wagesayis['wage_birimfiyat'])){
                               $wagenullbirim+=1;


                            }
                        }

                        $topsefer=0;

                        foreach ($seferveri as $seferveris){
                            $topsefer+=$seferveris['transportation_adet']*$seferveris['transportation_birimfiyat'];

                            if (empty($seferveris['transportation_birimfiyat'])){
                                $sefernullbirim+=1;
                            }
                        }

                        if (empty($wages['wagebirim'])){
                            $wages['wage_birimfiyat']=0;
                        }


                        ?>

                        <tr>
                            <th scope="row"><?php echo $say++; ?></th>
                            <td><?php echo $veris['musteri_name'] ;?></td>
                            <td><?php echo $veris['musteri_number'] ;?></td>
                            <td><?php echo substr($veris['musteri_adres'],0,30) ;?></td>
                            <td height="50"><?php if (($veris['topfiyat']+$wages['wagebirim']+$topsefer)-$paids['topodenen']>0){?><a href="detay-<?php echo $veris['musteri_id'];?>"> <button class="btn btn-danger btn-sm">Borcu:<?php echo (($veris['topfiyat']+$wages['wagebirim']+$topsefer)-$paids['topodenen'])." TL"; ?></button></a> <?php }?></td>
                            <td><?php if (!empty($wagenullbirim) || !empty($sefernullbirim)) {?><a href="detay-<?php echo $veris['musteri_id'];?>"> <button class="btn btn-warning btn-sm">Hesaplanmayan İş Var</button></a><?php $wagenullbirim=null; $sefernullbirim=null; }?></td>
                            <?php if (isset($_SESSION['users'])){ ?>
                            <td height="50"> <a class="btn btn-success btn-sm" onclick="return confirm('Ödeme İşlemi Gerçekleşsinmi? Bütün Hesap Silinecektir.')" href="?odeme=ok&&id=<?php echo $veris['musteri_id'];?>">Tüm Hesabı Sil</a></td>
                            <?php }else{?><td height="50"></td><?php  } ?>
                            <td><a href="?musteri_update&&id=<?php echo $veris['musteri_id'];?>"><i class="fa fa-user-circle-o" aria-hidden="true"></i></a></td>
                            <td><a href="detay-<?php echo $veris['musteri_id'];?>"><i class="fa fa-address-book-o" aria-hidden="true"></i></a></td>
                            <?php if (isset($_SESSION['users'])){ ?>
                            <td><a onclick="return confirm('Müşteri Silinmesini istiyormusunuz?')" href="?delete=ok&&delete_id=<?php echo $veris['musteri_id'];?>"><i class="fa fa-trash-o"></i></a></td>
                            <?php }else{?><td></td><?php  } ?>
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



