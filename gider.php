<?php require_once 'header.php';
if(isset($_SESSION['users'])){
}else{
    header("location:index");
    exit();
}
?>

    <!-- Page Content -->
    <div style="height: auto;" class="container">

        <?php
            require_once 'saathesap.php';




        if (isset($_GET['delete'])){
            $sonuc=$db->deletes("expense","expense_id",$_GET['id'],"users_id",$_SESSION['users']['users_id']);

            if ($sonuc){?>
                <div class="alert alert-success">Başarıyla Silindi.</div>
            <?php }
        }

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


        ?>


        <h1 class="my-4">Giderler</h1>


        <?php if (isset($_GET['gelirgider_insert'])){ ?>
            <div class="row">
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

        <?php } ?>

        <!-- Marketing Icons Section -->
        <div class="row">

            <div class="col-lg-12">


            <div class="row">
                <div class="col-lg-12" align="right"><a class="btn btn-success btn-sm" href="?gelirgider_insert">Yeni Gider Ekle</a> </div>
            </div>
                <div class="table-responsive">
            <table class="table table-striped">

                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Personel Adı Soyadı</th>
                        <th scope="col">Personel Numarası</th>
                        <th scope="col">Gider Açıklama</th>
                        <th scope="col">Gider Tutarı</th>
                        <th scope="col">Gider Birim Fiyat</th>
                        <th scope="col">Tarih</th>
                        <th width="50px" scope="col"></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    if (isset($_SESSION['users'])) {
                        $veri=$db->qSql("SELECT personel.personel_id,personel.personel_name,personel.personel_number,expense.expense_id,expense.expense_acıklama,expense.expense_tutar,expense.expense_birimfiyat,expense.expense_date FROM expense LEFT JOIN personel ON personel.personel_id=expense.personel_id WHERE expense.users_id={$users_id}  ORDER BY expense.expense_date DESC ");
                    }elseif (isset($_SESSION['personel'])){
                    }

                    $say=1;
                    foreach ($veri as $veris){
                       $topgider+=$veris['expense_tutar'];
                        ?>

                        <tr>
                            <th width="50" scope="row"><?php echo $say++; ?></th>
                            <td><?php echo $veris['personel_name']; ?></td>
                            <td><?php echo $veris['personel_number']; ?></td>
                            <td><?php echo $veris['expense_acıklama']; ?></td>
                            <td><?php echo $veris['expense_tutar']; ?></td>
                            <td><?php echo $veris['expense_birimfiyat']; ?></td>
                            <td><?php echo $veris['expense_date']; ?></td>
                            <?php if (isset($_SESSION['users'])){ ?>
                            <td width="50px"><a onclick="return confirm('Silmeyi Onaylıyormusunuz? Bu işlem geri alınamaz.')" href="?delete=ok&&id=<?php echo $veris['expense_id'];?>"><i class="fa fa-trash-o"></i></a></td>
                            <?php }else{?>
<td></td>
                           <?php } ?>
                        </tr>

                    <?php } ?>

                <tfoot>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Toplam Gider:<?php echo abs($topgider)." TL";?></td>
                <td></td>
                <td></td>

                </tfoot>

                    </tbody>

            </table>
                </div>

            </div>


       


        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

<?php require_once 'footer.php';?>


