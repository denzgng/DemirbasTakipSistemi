<?php
// Oturumu başlat
session_start();

// Oturum değişkenlerini boşalt
$_SESSION = array();

// Oturumu sonlandır
session_destroy();

// Kullanıcıyı giriş sayfasına yönlendir
header("Location: giris.php");
exit;
?>
