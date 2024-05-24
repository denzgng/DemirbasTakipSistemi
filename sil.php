<?php
// Oturumu başlat
session_start();

// Oturum doğrulama kontrolü
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Kullanıcı oturum açmamışsa giriş sayfasına yönlendir
    header("location: giris.php");
    exit;
}

// Veritabanı bağlantı bilgileri
$servername = "localhost";
$username = "root";
$password = "";
$database = "demirbas";

// Veritabanına bağlan
$conn = new mysqli($servername, $username, $password, $database);

// Bağlantı hatası kontrolü
if ($conn->connect_error) {
    die("Veritabanına bağlanırken hata oluştu: " . $conn->connect_error);
}

// ID parametresini kontrol et
if (isset($_GET['id'])) {
    // ID parametresini tamsayıya çevir
    $id = intval($_GET['id']);

    // Güvenlik önlemleri için kaçış dizisi ekle
    $id = $conn->real_escape_string($id);

    // Silme sorgusu oluştur
    $sql = "DELETE FROM donanim WHERE id = '$id'";

    // Sorguyu çalıştır ve sonucu kontrol et
    if ($conn->query($sql) === TRUE) {
        // Başarılı mesajını görüntüle
        echo "Kayıt başarıyla silindi.";
    } else {
        // Hata mesajını görüntüle
        echo "Kayıt silinirken hata oluştu: " . $conn->error;
    }

    // Veritabanı bağlantısını kapat
    $conn->close();

    // Donanım sayfasına yönlendir
    header("location: donanım.php");
    exit;
} else {
    // Geçersiz istek hatası
    echo "Geçersiz istek.";
    $conn->close();
}
?>
