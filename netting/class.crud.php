<?php
ob_start();
session_start();
require_once 'dbconfig.php';
$urlhome="/hafrnot/";//url /index

class crud {

    private $db;
    private $dbhost=DBHOST;
    private $dbuser=DBUSER;
    private $dbpass=DBPWD;
    private $dbname=DBNAME;


    function __construct() {

        try {

            $this->db=new PDO('mysql:host='.$this->dbhost.';dbname='.$this->dbname.';charset=utf8',$this->dbuser,$this->dbpass);

            // echo "Bağlantı Başarılı";

        } catch (Exception $e) {

            die("Bağlantı Başarısız:".$e->getMessage());
        }

    }

    public function addValue($argse) {

        $values=implode(',',array_map(function ($item){
            return $item.'=?';
        },array_keys($argse)));

        return $values;
    }


    public function insert($table,$values,$options=[]) {

        try {

            if (!empty($_FILES[$options['file_name']]['name'])) {

                $name_y=$this->imageUpload(
                    $_FILES[$options['file_name']]['name'],
                    $_FILES[$options['file_name']]['size'],
                    $_FILES[$options['file_name']]['tmp_name'],
                    $options['dir']
                );

                $values+=[$options['file_name'] => $name_y];
            }


/*
            if (isset($options['pass'])) {
                $values[$options['pass']]=md5($values[$options['pass']]);
            }
*/


            if (isset($options['users_id'])){
                $values['users_id']=$options['users_id'];
            }

            if (isset($values['otosaathesap'])){
                unset($values['business_birimfiyat']);
                unset($values['business_moladk']);
            }

            if (isset($values['saathesap'])){
                unset($values['business_birimfiyat']);
                unset($values['business_moladk']);
                unset($values['business_baslangic']);
                unset($values['business_bitis']);
            }

            if (isset($options['business_birimfiyat'])){
                $values['business_birimfiyat']=$options['business_birimfiyat'];
                $values['business_moladk']=$options['business_moladk'];
            }
            if (isset($options['business_baslangic'])){
                $values['business_baslangic']=$options['business_baslangic'];
                $values['business_bitis']=$options['business_bitis'];
            }



            unset($values[$options['form_name']]);



            /*
            echo "<pre>";
            print_r($values);
            print_r($_POST);
            print_r($options);
            exit;
            */







            $stmt=$this->db->prepare("INSERT INTO $table SET {$this->addValue($values)}");
            $stmt->execute(array_values($values));



            return ['status' => TRUE];

        } catch (Exception $e) {

            return ['status' => FALSE, 'error' => $e->getMessage()];
        }

    }


    public function update($table,$values,$options=[]) {

        try {



            if (isset($options['slug'])) {

                if (empty($values[$options['slug']])) {
                    $values[$options['slug']]=$this->seo($values[$options['title']]);
                } else {
                    $values[$options['slug']]=$this->seo($values[$options['slug']]);
                }
            }



            if (!empty($_FILES[$options['file_name']]['name'])) {


                $name_y=$this->imageUpload(
                    $_FILES[$options['file_name']]['name'],
                    $_FILES[$options['file_name']]['size'],
                    $_FILES[$options['file_name']]['tmp_name'],
                    $options['dir'],
                    $values[$options['file_delete']]
                );

                // print_r($name_y);
                // exit;

                $values+=[$options['file_name'] => $name_y];

            }

            //Eski Resim Dosyasının Değerini Temizleme...
            unset($values[$options['file_delete']]);

/*
            if (isset($options['pass'])) {//md5 çevirme
                $values[$options['pass']]=md5($values[$options['pass']]);
            }

*/



if (isset($values['pass'])){
    if ($values['pass']===$values['pass1']){
        $values['users_password']=$values['pass'];
        unset($values['pass1']);
        unset($values['pass']);
    }else{
        return ['status'=>'Şifre hatalı'];
    }
}




            $columns_id=$values[$options['columns']];
            unset($values[$options['form_name']]);
            unset($values[$options['columns']]);
            $valuesExecute=$values;
            $valuesExecute+=[$options['columns'] => $columns_id];



/*
            echo "<pre>";
            print_r($values);
            print_r($_POST);
            print_r($options);
            print_r($valuesExecute);
             echo "<pre>";
            exit;
*/








            $stmt=$this->db->prepare("UPDATE $table SET {$this->addValue($values)} WHERE {$options['columns']}=?");
            $stmt->execute(array_values($valuesExecute));

            return ['status' => TRUE];

        } catch (Exception $e) {

            return ['status' => FALSE, 'error' => $e->getMessage()];
        }

    }


    public function delete ($table,$columns,$values) {


        try {


            $stmt=$this->db->prepare("DELETE FROM $table WHERE $columns=?");
            $stmt->execute([htmlspecialchars($values)]);

            return ['status' => TRUE];

        } catch (Exception $e) {

            return ['status' => FALSE, 'error' => $e->getMessage()];
        }

    }

    public function deletes ($table,$columns,$values,$usersname,$usersid) {


        try {


            $stmt=$this->db->prepare("DELETE FROM $table WHERE $columns=? AND $usersname=$usersid");
            $stmt->execute([htmlspecialchars($values)]);

            return ['status' => TRUE];

        } catch (Exception $e) {

            return ['status' => FALSE, 'error' => $e->getMessage()];
        }

    }


    public function imageUpload($name,$size,$tmp_name,$dir) {


        try {

            $izinli_uzantilar=[
                'jpg',
                'jpge',
                'png',
                'ico'
            ];

            $ext=strtolower(substr($name, strpos($name, '.')+1));

            if (in_array($ext, $izinli_uzantilar)===false) {
                throw new Exception('Bu dosya türü kabul edilmemektedir...');
            }

            if ($size>1048576) {
                throw new Exception('Dosya boyutu çok büyük...');
            }


            $name_y=uniqid().".".$ext;

            if (!@move_uploaded_file($tmp_name, "dimg/$dir/$name_y")) {
                throw new Exception('Dosya yükleme hatası...');
            }

            return $name_y;

        } catch (Exception $e) {

            return ['status' => FALSE, 'error' => $e->getMessage()];
        }
    }

    public function adminInsert($users_mail,$users_name,$users_password,$users_telno) {

        try {

            /*
            echo "<br>";
            print_r($_POST);
            echo "</br>";
            exit();
            */


            $row=$this->wread("users","users_mail",$users_mail);



            if ($row->rowCount()==0){//eğer users tablosundaki eşleşen mail yoksa kayıdı yap


                $stmt=$this->db->prepare("INSERT INTO users SET users_mail=?,users_password=?,users_name=?,users_telno=?");
                $stmt->execute([$users_mail,$users_password,$users_name,$users_telno]);

                return ['status' => TRUE];

            }else{
                return ['status' => 2];//kullanılmış eposta uyarısı
            }




        } catch (Exception $e) {


            return ['status' => FALSE, 'error' => $e->getMessage()];
        }

    }


    public function adminsLogin($users_mail,$users_password,$remember_me=null) {//rememberı kullanamyacam için boş dursun

        try {


            $stmt=$this->db->prepare("SELECT * FROM users WHERE users_mail=? AND users_password=?");

                $stmt->execute([$users_mail,$users_password]);



            if ($stmt->rowCount()==1) {//varmı öyle satır diye bakıyor



                $row=$stmt->fetch(PDO::FETCH_ASSOC);

                if ($row['users_status']==0) {
                    return ['status' => FALSE];
                    exit;
                }

                $_SESSION["users"]=[
                    "users_mail" => $users_mail,//posttan gelen veri
                    "users_name" => $row['users_name'],//tablodan çekilen veri
                    "users_telno" => $row['users_telno'],//tablodan çekilen veri
                    "users_id" => $row['users_id']//tablodan çekilen veri
                ];





                return ['status' => TRUE];


            } else {



                return ['status' => FALSE ];

            }


        } catch (Exception $e) {

            return ['status' => FALSE, 'error' => $e->getMessage()];

        }


    }


    public function personelsLogin($personel_kadi,$personel_pass,$remember_me=null) {//rememberı kullanamyacam için boş dursun

        try {


            $stmt=$this->db->prepare("SELECT * FROM personel WHERE personel_kadi=? AND personel_pass=?");

            $stmt->execute([$personel_kadi,$personel_pass]);



            if ($stmt->rowCount()==1) {//varmı öyle satır diye bakıyor



                $row=$stmt->fetch(PDO::FETCH_ASSOC);

                if ($row['personel_status']==0) {
                    return ['status' => FALSE];
                    exit;
                }

                $_SESSION["personel"]=[
                    "personel_kadi" => $personel_kadi,//posttan gelen veri
                    "personel_name" => $row['personel_name'],//tablodan çekilen veri
                    "personel_number" => $row['personel_number'],//tablodan çekilen veri
                    "personel_id" => $row['personel_id'],//tablodan çekilen veri
                    "users_id"=>$row['users_id']
                ];





                return ['status' => TRUE];


            } else {



                return ['status' => FALSE ];

            }


        } catch (Exception $e) {

            return ['status' => FALSE, 'error' => $e->getMessage()];

        }


    }


    public function read($table,$options=[]){//ek parametre görderilmesi için $options=[] kullanılır

        try {

            if (isset($options['columns_name']) && empty($options['limit'])) {

                $stmt=$this->db->prepare("SELECT * FROM $table where users_id={$_SESSION['users']['users_id']} order by {$options['columns_name']} {$options['columns_sort']}");

            } else if (isset($options['columns_name']) && isset($options['limit'])) {


                $stmt=$this->db->prepare("SELECT * FROM $table where users_id={$_SESSION['users']['users_id']} order by {$options['columns_name']} {$options['columns_sort']} limit {$options['limit']}");
            } else {

                $stmt=$this->db->prepare("SELECT * FROM $table where users_id={$_SESSION['users']['users_id']}");

            }


            $stmt->execute();

            return $stmt;


        } catch (Exception $e) {

            echo $e->getMessage();
            return false;
        }

    }

    public function reada($table,$stuns="*",$options=[]){//ek parametre görderilmesi için $options=[] kullanılır

        try {

            if(isset($_SESSION['personel'])){
                $id=$this->wreadb("personel","personel_id",$_SESSION['personel']['personel_id'],"users_id");
                foreach ($id as $ids){}
                $users_id=$ids['users_id'];
            }elseif (isset($_SESSION['users'])){
                $users_id=$_SESSION['users']['users_id'];
            }

            if (isset($options['columns_name']) && empty($options['limit'])) {

                $stmt=$this->db->prepare("SELECT $stuns FROM $table where users_id={$users_id} order by {$options['columns_name']} {$options['columns_sort']}");

            } else if (isset($options['columns_name']) && isset($options['limit'])) {


                $stmt=$this->db->prepare("SELECT $stuns FROM $table where users_id={$users_id} order by {$options['columns_name']} {$options['columns_sort']} limit {$options['limit']}");
            } else {

                $stmt=$this->db->prepare("SELECT $stuns FROM $table where users_id={$users_id}");

            }


            $stmt->execute();

            return $stmt;


        } catch (Exception $e) {

            echo $e->getMessage();
            return false;
        }

    }




    public function wread($table,$columns,$values,$stuns="*",$options=[]) {


        try {
            if(isset($_SESSION['personel'])){
                $id=$this->wreadb("personel","personel_id",$_SESSION['personel']['personel_id'],"users_id");
                foreach ($id as $ids){}
                $users_id=$ids['users_id'];
            }elseif (isset($_SESSION['users'])){
                $users_id=$_SESSION['users']['users_id'];
            }

            if (isset($options['columns_name'])) {

                $stmt=$this->db->prepare("SELECT $stuns FROM $table where $columns=? AND users_id={$users_id} order by {$options['columns_name']} {$options['columns_sort']}");
            }else{
                $stmt=$this->db->prepare("SELECT $stuns FROM $table WHERE $columns=? AND users_id={$users_id}");
            }



            $stmt->execute([htmlspecialchars($values)]);

            return $stmt;

        } catch (Exception $e) {

            return ['status' => FALSE, 'error' => $e->getMessage()];
        }
    }

    public function wreada($table,$columns,$values,$options=[]) {


        try {

            $stmt=$this->db->prepare("SELECT * FROM $table WHERE $columns=?");
            $stmt->execute([htmlspecialchars($values)]);

            return $stmt;

        } catch (Exception $e) {

            return ['status' => FALSE, 'error' => $e->getMessage()];
        }
    }

    public function wreadb($table,$columns,$values,$stuns="*",$options=[]) {


        try {

                $stmt=$this->db->prepare("SELECT $stuns FROM $table WHERE $columns=?");



            $stmt->execute([htmlspecialchars($values)]);

            return $stmt;

        } catch (Exception $e) {

            return ['status' => FALSE, 'error' => $e->getMessage()];
        }
    }

    public function qSql($sql,$options=[]){ //$options=[] dizi şeklinde ek parametre göndermek istersek yazıyoruz

        try {

            $stmt=$this->db->prepare($sql);
            $stmt->execute();
            return $stmt;//değer döndürme

        } catch (Exception $e) {
            return ['status' => FALSE, 'error' => $e->getMessage()];

        }


    }

    public function saathesapla($baslangic,$bitis,$value=null,$moladk=null,$options=[]){
        $baslangicsaat     = strtotime($baslangic);//unix id alıyor
        $bitissaat        = strtotime($bitis);

        $fark        = abs($bitissaat-$baslangicsaat);
        $dk= $fark/60;


        if(empty($moladk)){
            $moladk=0;
        }
        if(empty($value)){
            $value=0;
        }


            $dk=$dk-$moladk;
            $fiyat=($value/60)*$dk;//gelen birim fiyatı 60 bölerek 1 dk nekadar para olduğunu bularak dkyla çarparak fiyatı çıkar
            return ['fiyat'=>$fiyat,"saatdk"=>$dk];

    }


    public function dkhesap($baslangic,$bitis){
        $baslangicsaat     = strtotime($baslangic);//unix id alıyor
        $bitissaat        = strtotime($bitis);

        $fark        = abs($bitissaat-$baslangicsaat);
        $dk= $fark/60;//dk


        return $dk;

    }


    function replace_tr($text) {
        $text = trim($text);
        $search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü',' ');
        $replace = array('c','c','g','g','i','i','o','o','s','s','u','u',' ');
        $new_text = str_replace($search,$replace,$text);
        return $new_text;
    }

    function saatshow($saat){
        $saat=explode(".",$saat/60);
        if($saat[1]){
            $saat[1]="0.".$saat[1];
            return $saat[0].".".$saat[1]*60;
        }else{
            return $saat[0];
        }
    }







}


?>