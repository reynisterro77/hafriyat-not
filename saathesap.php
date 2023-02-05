<?php
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



    if(!empty($_POST['musteri_number'])){

        $number=$db->qSql("SELECT musteri_id,musteri_number,users_id FROM `musteri` WHERE musteri_number='{$_POST['musteri_number']}' AND users_id='{$_SESSION['users']['users_id']}'");
        foreach ($number as $numbers){}
        $business_birimfiyat=$_POST['business_birimfiyat'];
        $business_moladk=$_POST['business_moladk'];

        if ($number->rowCount()==0){


            $musteri_insert=$db->insert("musteri",$_POST,[

                "form_name"=>"otosaathesap",
                "users_id"=>$_SESSION['users']['users_id']
            ]);




            $sonid=$db->qSql("SELECT musteri_id AS musteri_id FROM musteri WHERE musteri_id = @@Identity");//insert edilen son idyi alır
            foreach ($sonid as $son){
            }

            unset($_POST['musteri_name']);
            unset($_POST['musteri_number']);
            unset($_POST['musteri_adres']);




            $_POST['musteri_id']=$son['musteri_id'];
            $_POST['business_baslangic']=$_COOKIE['otosaat'];
            $_POST['business_bitis']=$_COOKIE['otosaatbitis'];
            $_POST['business_kacdk']=$hesap['saatdk'];
            $_POST['business_fiyat']=$hesap['fiyat'];

            if(isset($_SESSION['personel'])){
                $_POST['personel_id']=$_SESSION['personel']['personel_id'];
            }



            $businessekle=$db->insert('business',$_POST,
                [
                    "form_name" =>"otosaathesap",
                    "users_id"=>$_SESSION['users']['users_id'],
                    "business_birimfiyat"=>$business_birimfiyat,
                    "business_moladk"=>$business_moladk
                ]);


            if ($musteri_insert){?>
                <div class="alert alert-success"><a href="musteri.php">Müşteri Başarıyla Kayıt Edildi Müşterilerim Sayfasından Hesabına Bakabilirsiniz.Yada buraya Tıklayın</a></div>
            <?php  }
        }else{

            unset($_POST['musteri_name']);
            unset($_POST['musteri_number']);
            unset($_POST['musteri_adres']);

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






    }


}
*/


if (isset($_POST['saathesap'])){

    $dk=$db->dkhesap($_POST['mola_baslangic'],$_POST['mola_bitis']);
    $_POST['business_moladk']=$dk;
    unset($_POST['mola_baslangic']);
    unset($_POST['mola_bitis']);

    $hesap=$db->saathesapla($_POST['business_baslangic'],$_POST['business_bitis'],$_POST['business_birimfiyat'],$_POST['business_moladk']);

    if(!empty($_POST['musteri_number'])){

        if(isset($_SESSION['personel'])){

            $_POST['users_id']=$users_id;
        }elseif (isset($_SESSION['users'])){
            $users_id=$_SESSION['users']['users_id'];
        }


            $number=$db->qSql("SELECT musteri_id,musteri_number,users_id FROM `musteri` WHERE musteri_number='{$_POST['musteri_number']}' AND users_id='{$users_id}'");


        foreach ($number as $numbers){}
        $business_birimfiyat=$_POST['business_birimfiyat'];
        $business_moladk=$_POST['business_moladk'];
        $business_baslangic=$_POST['business_baslangic'];
        $business_bitis=$_POST['business_bitis'];


        if ($number->rowCount()==0){


            $musteri_insert=$db->insert("musteri",$_POST,[

                "form_name"=>"saathesap",
                "users_id"=>$users_id
            ]);





            $sonid=$db->qSql("SELECT musteri_id AS musteri_id FROM musteri WHERE musteri_id = @@Identity");//insert edilen son idyi alır
            foreach ($sonid as $son){
            }

            unset($_POST['musteri_name']);
            unset($_POST['musteri_number']);
            unset($_POST['musteri_adres']);




            $_POST['musteri_id']=$son['musteri_id'];
            $_POST['business_kacdk']=$hesap['saatdk'];
            $_POST['business_fiyat']=$hesap['fiyat'];

            if(isset($_SESSION['personel'])){
                $_POST['personel_id']=$_SESSION['personel']['personel_id'];
                $_POST['users_id']=$users_id;
            }



            $businessekle=$db->insert('business',$_POST,
                [
                    "form_name" =>"saathesap",
                    "users_id"=>$users_id,
                    "business_birimfiyat"=>$business_birimfiyat,
                    "business_moladk"=>$business_moladk,
                    "business_baslangic"=>$business_baslangic,
                    "business_bitis"=>$business_bitis

                ]);


            if ($musteri_insert){?>
                <div class="alert alert-success"><a href="musteri.php">Müşteri Başarıyla Kayıt Edildi Müşterilerim Sayfasından Hesabına Bakabilirsiniz.Yada buraya Tıklayın</a></div>
            <?php  }
        }else{

            unset($_POST['musteri_name']);
            unset($_POST['musteri_number']);
            unset($_POST['musteri_adres']);


            $_POST['musteri_id']=$numbers['musteri_id'];
            $_POST['business_kacdk']=$hesap['saatdk'];
            $_POST['business_fiyat']=$hesap['fiyat'];
            if(isset($_SESSION['personel'])){
                $_POST['personel_id']=$_SESSION['personel']['personel_id'];
            }



            $businessekle=$db->insert('business',$_POST,
                [
                    "form_name" =>"saathesap",
                    "users_id"=>$users_id,
                    "business_birimfiyat"=>$business_birimfiyat,
                    "business_moladk"=>$business_moladk,
                    "business_baslangic"=>$business_baslangic,
                    "business_bitis"=>$business_bitis

                ]);

            if ($businessekle['status']){?>
                <div class="alert alert-success"><a href="musteri.php">Müşterinin Yeni Kayıdı Eklendi.</a> </div>
            <?php }
        }






    }

}


if (isset($_POST['wage_insert'])){
    if(!empty($_POST['musteri_number'])){


            $number=$db->qSql("SELECT musteri_id,musteri_number FROM `musteri` WHERE musteri_number='{$_POST['musteri_number']}' AND users_id='{$users_id}'");


        foreach ($number as $numbers){}


        $wage_datetime=date('Y-m-d');
        $wage_isname=$_POST['wage_isname'];
        $wage_birimfiyat=$_POST['wage_birimfiyat'];

        unset($_POST['wage_isname']);
        unset($_POST['wage_birimfiyat']);



        if ($number->rowCount()==0){



            $musteri_insert=$db->insert("musteri",$_POST,[

                "form_name"=>"wage_insert",
                "users_id"=>$users_id
            ]);




            $sonid=$db->qSql("SELECT musteri_id AS musteri_id FROM musteri WHERE musteri_id = @@Identity");
            foreach ($sonid as $son){
            }

            unset($_POST['musteri_name']);
            unset($_POST['musteri_number']);
            unset($_POST['musteri_adres']);




            $_POST['musteri_id']=$son['musteri_id'];

            $_POST['users_id']=$users_id;
            $_POST['wage_isname']=$wage_isname;
            $_POST['wage_birimfiyat']=$wage_birimfiyat;
            $_POST['wage_datetime']=$wage_datetime;


            if ($_SESSION['personel']){
                $_POST['personel_id']=$_SESSION['personel']['personel_id'];
            }

            $wagesekle=$db->insert('wage',$_POST,
                [
                    "form_name" =>"wage_insert",
                ]);


            if ($musteri_insert){?>
                <div class="alert alert-success"><a href="musteri.php">Müşteri Başarıyla Kayıt Edildi Müşterilerim Sayfasından Hesabına Bakabilirsiniz.Yada buraya Tıklayın</a></div>
            <?php  }
        }else{

            unset($_POST['musteri_name']);
            unset($_POST['musteri_number']);
            unset($_POST['musteri_adres']);

            $_POST['musteri_id']=$numbers['musteri_id'];
            $_POST['users_id']=$users_id;
            if ($_SESSION['personel']){
                $_POST['personel_id']=$_SESSION['personel']['personel_id'];
            }
            $_POST['wage_isname']=$wage_isname;
            $_POST['wage_birimfiyat']=$wage_birimfiyat;
            $_POST['wage_datetime']=$wage_datetime;




            $wagesekle=$db->insert('wage',$_POST,
                [
                    "form_name" =>"wage_insert",
                ]);

            if ($wagesekle['status']){?>
                <div class="alert alert-success"><a href="musteri.php">Müşterinin Yeni Kayıdı Eklendi.</a> </div>
            <?php }
        }

    }else{?>
        <div class="alert alert-danger">Müşteri Seçiniz veya Müşteri Ekleme İşlemi yapınız.</div>
    <?php }
}




?>