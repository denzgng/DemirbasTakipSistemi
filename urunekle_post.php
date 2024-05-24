<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: giris.php");
    exit;
}

// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$database = "demirbas";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Veritabanına bağlanırken hata oluştu: " . $conn->connect_error);
}

// Giriş yapan kullanıcının personel_id değerini al
$personel_id = $_SESSION["user_id"];

// Formdan gelen verileri al
$marka = $_POST['marka'];
$model = $_POST['model'];
$aciklama = $_POST['aciklama'];
$verildigiTarih = $_POST['verildigiTarih'];

// Veritabanına yeni ürün ekleme
$sql = "INSERT INTO donanim (marka, model, aciklama, verildigiTarih, kullanici_id) VALUES ('$marka', '$model', '$aciklama', '$verildigiTarih', '$personel_id')";

if ($conn->query($sql) === TRUE) {
    echo "Yeni ürün başarıyla eklendi.";
} else {
    echo "Hata: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
