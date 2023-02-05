<?php
require_once 'netting/class.crud.php';
$db=new crud();//sınıfı çalıştırma

date_default_timezone_set('Europe/Istanbul');

if(isset($_SESSION['personel'])){
    $id=$db->wreadb("personel","personel_id",$_SESSION['personel']['personel_id'],"users_id");
    foreach ($id as $ids){}
    $usersname=$db->wreadb("users","users_id",$ids['users_id'],"users_name");
    foreach ($usersname as $usersnames){}
    $users_name=$usersnames['users_name'];

}elseif (isset($_SESSION['users'])){
    $users_name=$_SESSION['users']['users_name'];
}

require('fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage('L','A4',0);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,$db->replace_tr('Firma Adı:').$db->replace_tr($users_name));
$pdf->SetX(215);
$pdf->Cell(10,10,"Belge Tarihi:".date('d-m-Y'));
$pdf->Ln(10);
$pdf->Cell(10,10,"Musteri Adi Soyadi:".$db->replace_tr($_POST['musteri_name']));
$pdf->Ln(10);
$pdf->Cell(10,10,"Musteri Numarasi:".$_POST['musteri_number']);


if (!empty($_POST['topfiyat'])) {
    $pdf->Ln(10);
    $pdf->SetFont('Times','B',16);

    $pdf->Cell(60, 10, 'Baslangic Saati', 1);
    $pdf->Cell(60, 10, 'Bitis Saati', 1);
    $pdf->Cell(30, 10, 'Birim Fiyat', 1);
    $pdf->Cell(30, 10, 'Saat', 1);
    $pdf->Cell(30, 10, 'Mola', 1);
    $pdf->Cell(60, 10, 'Hesap', 1);

    $pdf->SetFont('Times', '', 16);


    $pdf->Ln(10);
    for ($i = 0; $i < $_POST['say']; $i++) {
        $pdf->Cell(60, 10, $_POST['business_baslangic-' . $i], 1);
        $pdf->Cell(60, 10, $_POST['business_bitis-' . $i], 1);
        $pdf->Cell(30, 10, $_POST['business_birimfiyat-' . $i], 1);
        $pdf->Cell(30, 10, $_POST['business_kacdk-' . $i], 1);
        $pdf->Cell(30, 10, $_POST['business_moladk-' . $i], 1);
        $pdf->Cell(60, 10, $_POST['business_fiyat-' . $i], 1);
        $pdf->Ln(10);

    }
}


if(empty($_POST['topodenen'])){
    $_POST['topodenen']=0;
}
if(empty($_POST['topfiyat'])){
    $_POST['topfiyat']=0;
}
if(empty($_POST['topwage'])){
    $_POST['topwage']=0;
}






if (!empty($_POST['topwage'])){
    $pdf->Ln(10);

    $pdf->SetFont('Times', 'B', 16);

    $pdf->Cell(60, 10, 'Tarih', 1);
    $pdf->Cell(60, 10, $db->replace_tr('Yapılan İş'), 1);
    $pdf->Cell(30, 10, '', 1);
    $pdf->Cell(30, 10, '', 1);
    $pdf->Cell(30, 10, '', 1);
    $pdf->Cell(60, 10, $db->replace_tr('Yevmiye Miktarı'), 1);

    $pdf->SetFont('Times', '', 16);


    $pdf->Ln(10);

    for ($i=0;$i<$_POST['say3'];$i++){
        $pdf->Cell(60, 10, $_POST['wage_datetime-' . $i], 1);
        $pdf->Cell(60, 10, $db->replace_tr($_POST['wage_isname-' . $i]), 1);
        $pdf->Cell(30, 10, '', 1);
        $pdf->Cell(30, 10, '', 1);
        $pdf->Cell(30, 10, '', 1);
        $pdf->Cell(60, 10, $_POST['wage_birimfiyat-' . $i]." TL", 1);
        $pdf->Ln(10);
    }

}


if(!empty($_POST['topodenen'])) {
    $pdf->Ln(10);
    $pdf->SetFont('Times', 'B', 16);

    $pdf->Cell(60, 10, 'Tarih', 1);
    $pdf->Cell(60, 10, '', 1);
    $pdf->Cell(30, 10, '', 1);
    $pdf->Cell(30, 10, '', 1);
    $pdf->Cell(30, 10, '', 1);
    $pdf->Cell(60, 10, 'Odenen Miktar', 1);

    $pdf->SetFont('Times', '', 16);


    $pdf->Ln(10);

    for ($i = 0; $i < $_POST['say2']; $i++) {

        $pdf->Cell(60, 10, $_POST['paid_date-' . $i], 1);
        $pdf->Cell(60, 10, '', 1);
        $pdf->Cell(30, 10, '', 1);
        $pdf->Cell(30, 10, '', 1);
        $pdf->Cell(30, 10, '', 1);
        $pdf->Cell(60, 10, $_POST['paid_odenen-' . $i]." TL", 1);
        $pdf->Ln(10);

    }
}

if (!empty($_POST['sefertop'])){
    $pdf->Ln(10);
    $cellsay=67;

    $pdf->SetFont('Times', 'B', 16);

    $pdf->Cell($cellsay, 10, $db->replace_tr('Sefer Açıklama'), 1);
    $pdf->Cell($cellsay, 10, $db->replace_tr('Sefer Adet'), 1);
    $pdf->Cell($cellsay, 10, $db->replace_tr('Birim Fiyat'), 1);
    $pdf->Cell($cellsay, 10, $db->replace_tr('Sefer Tarih'), 1);
    $pdf->SetFont('Times', '', 16);

    $pdf->Ln(10);


    for ($i = 0; $i < $_POST['say4']; $i++) {

        $pdf->Cell($cellsay, 10,  $db->replace_tr($_POST['transportation_acıklama-' . $i]), 1);
        $pdf->Cell($cellsay, 10, $_POST['transportation_adet-' . $i], 1);
        $pdf->Cell($cellsay, 10, $_POST['transportation_birimfiyat-' . $i], 1);
        $pdf->Cell($cellsay, 10, $_POST['transportation_datetime-' . $i], 1);
        $pdf->Ln(10);
    }

}







$pdf->SetFont('Times','B',16);

$pdf->SetX(58);

$pdf->Cell(60,10,"Toplam Sefer:".$_POST['sefertop'],1);
$pdf->Cell(60,10,"Toplam Saat:".$_POST['topsaat'],1);

$pdf->SetX(178);
$pdf->Cell(40,10,"Toplam Hesap:",1);
$pdf->SetX(218);
$pdf->Cell(60,10,abs(($_POST['topfiyat']+$_POST['topwage']+$_POST['sefertophesap'])-$_POST['topodenen'])." TL",1);






$pdf->Output();
?>
