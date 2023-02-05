<?php
session_start();
if (isset($_SESSION['users'])){
unset($_SESSION['users']);
    setcookie('users_mail',$_POST['users_mail'],time() - (60*60*240));
    setcookie('users_password',base64_encode($_POST['users_password']),time() - (60*60*240));
}elseif (isset($_SESSION['personel'])){
    unset($_SESSION['personel']);
    setcookie('personel_kadi',$_POST['personel_kadi'],time() - (60*60*240));
    setcookie('personel_pass',base64_encode($_POST['personel_pass']),time() - (60*60*240));
}


header("location:index");
exit();
?>
