<?php require_once 'header.php';?>


<!-- Page Content -->
<div style="height: auto;" class="container">
    <?php

    if (isset($_POST['users_update'])){
        $mevcutsifre=$db->wread("users","users_id",$_SESSION['users']['users_id'],"users_password");

        foreach ($mevcutsifre as $mevcutsifres){
            $sifre=$mevcutsifres['users_password'];
        }


        if ($_POST['pass_mevcut']===$sifre && !empty($_POST['pass'])){

            $_POST['users_id']=$_SESSION['users']['users_id'];

            unset($_POST['pass_mevcut']);

            $sonuc=$db->update("users",$_POST,
                [
                    "form_name"=>"users_update",
                    "columns"=>"users_id",

                ]);

            if ($sonuc['status']==1){
                $users_id=$_SESSION['users']['users_id'];
                $_SESSION["users"]=[
                    "users_mail" => $_POST['users_mail'],
                    "users_name" => $_POST['users_name'],
                    "users_telno" => $_POST['users_telno'],
                    "users_id" => $users_id
                ];
                ?>
                <div class="alert alert-success">Başarıyla Güncellendi.</div>
            <?php }else{?>
                <div class="alert alert-danger">Kayıt Edilmedi Hata Yaptınız.</div>
            <?php }

        }elseif ($_POST['pass_mevcut']===$sifre && empty($_POST['pass'])){
            unset($_POST['pass_mevcut']);
            unset($_POST['pass']);
            unset($_POST['pass1']);


            $_POST['users_id']=$_SESSION['users']['users_id'];

            $sonuc=$db->update("users",$_POST,
                [
                    "form_name"=>"users_update",
                    "columns"=>"users_id",

                ]);

            if ($sonuc['status']){
                $users_id=$_SESSION['users']['users_id'];
                $_SESSION["users"]=[
                    "users_mail" => $_POST['users_mail'],
                    "users_name" => $_POST['users_name'],
                    "users_telno" => $_POST['users_telno'],
                    "users_id" => $users_id
                ];
                ?>
                <div class="alert alert-success">Başarıyla Güncellendi.</div>
            <?php }

        } else{?>
            <div class="alert alert-danger">Mevcut Şifrenizi Girmediniz.</div>
       <?php }
    }

    ?>

    <h1 class="my-4">Hesap Bilgilerimi Değiştirme</h1>

    <!-- Marketing Icons Section -->
    <div class="row">




        <div class="col-lg-6 mb-2">
            <div class="card h-100">
                <h4 class="card-header">Şifremi Değiştirme</h4>
                <div class="card-body">
                    <!--
                    <p class="card-text">

                    </p>-->

                    <form action="" method="post">

                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <input class="form-control" type="text" name="users_name" value="<?php echo $_SESSION['users']['users_name']; ?>">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <input class="form-control" type="text" readonly=""  name="users_mail" value="<?php echo $_SESSION['users']['users_mail']; ?>" >
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <input class="form-control" type="text" id="phone1" name="users_telno" value="<?php echo $_SESSION['users']['users_telno']; ?>" >
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <input class="form-control" min="6" type="password" name="pass_mevcut" placeholder="Mevcut Şifreyi Giriniz">
                                <small>Mevcut Şifrenizi Girmeden Değişiklik Yapamassınız.</small>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <input class="form-control" min="6" type="password" name="pass" placeholder="Yeni Şifrenizi Giriniz">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <input class="form-control" min="6" type="password" name="pass1" placeholder="Yeni Şifrenizi Tekrar Giriniz">
                            </div>
                        </div>



                </div>
                <div class="card-footer">
                    <div class="row">
                        <button type="submit" name="users_update" class="btn btn-success">Bilgilerimi Güncelle</button>

                        </form>
                    </div>
                </div>

            </div>
        </div>

<!--
        <div class="col-lg-6 mb-2">
            <div class="card h-100">
                <h4 class="card-header">Saat Hesaplama</h4>
                <div class="card-body">
                    <p class="card-text">Başlangıç Bitiş Saatini girip ve birim fiyatını girip hesaplamaya tıklayın.</p>
                    <form action="" method="post">
                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <input class="form-control" type="number" name="value" placeholder="Ne kadara çalışağınızı birim fiyatıyla yazın">
                            </div>
                        </div>




                        <div class="row">
                            <div class="col-lg-12">
                                <input class="form-control" type="datetime" name="ilk-zaman" placeholder="Başlangıç Saati">
                            </div>
                            <div class="col-lg-12">
                                <input class="form-control" type="datetime" name="son-zaman" placeholder="Bitiş Saati">


                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                Başlangıç Saati:  <?php if (!empty($_POST['ilk-zaman'])){ echo $_POST['ilk-zaman'];} ?>  <br>
                                Bitiş Saati: <?php if (!empty($_POST['son-zaman'])){ echo $_POST['son-zaman'];} ?><br>
                                Kaç DK:<?php if (isset($dka)){ echo $dka;}?><br>
                                Fiyat: <?php if (isset($fiyata)){ echo $fiyata;}?>
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
        </div> -->


    </div>
    <!-- /.row -->



    <!-- Features Section -->




</div>
<!-- /.container -->

<?php require_once 'footer.php';?>

