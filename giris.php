<?php
// Oturumu başlatma
session_start();

// Veritabanı bağlantı bilgileri
$servername = "localhost";
$username = "root";
$password = "";
$database = "demirbas";

// Veritabanı bağlantısını oluşturm
$conn = new mysqli($servername, $username, $password, $database);

// Bağlantı kontrolü - bağlantıda bir hata oluşursa mesaj göster
if ($conn->connect_error) {
    die("Veritabanına bağlanırken hata oluştu: " . $conn->connect_error);
}

// Hata mesajı değişkeni başlangıçta boş
$hata_mesaji = "";

// Form gönderildiğinde çalışacak kod bloğu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kullanıcıdan gelen e-posta ve şifre bilgilerini al
    $eposta = $_POST["eposta"];
    $sifre = $_POST["sifre"];

    // Kullanıcıyı veritabanında ara
    $sql = "SELECT * FROM personel WHERE eposta = '$eposta' AND sifre = '$sifre'";
    $result = $conn->query($sql);

    // Kullanıcı bulunduysa oturumu başlat ve kullanıcı bilgilerini oturum değişkenlerine kaydet
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["loggedin"] = true;
        $_SESSION["eposta"] = $row["eposta"];
        $_SESSION["user_id"] = $row["id"];
        // Genel sayfaya yönlendir
        header("Location: genel.php");
        exit;
    } else {
        // Hatalı giriş, kullanıcıya hata mesajı göster
        $hata_mesaji = "Hatalı e-posta veya şifre, lütfen tekrar deneyin!";
    }
}

// Veritabanı bağlantısını kapat
$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demirbaş Takip Sistemi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        /* Giriş kutusu stilleri */
        .login-container{
            border: 1px solid black;
            text-align: center;
            padding: 20px;
            width: 300px;
            margin: auto;
            margin-top: 200px;
        }
        /* Başlık stili */
        .login-header{
            font-size: 20px;
            margin-bottom: 20px;
        }
        /* Form içi input alanlarının stilleri */
        .login-form input{
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }
        /* Submit butonunun stili */
        .login-form input[type="submit"]{
            width: 30%;
            margin-top: 10px;
        }
        /* Hata mesajı stili */
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-header">Demirbaş Takip Sistemi</div>
    <div class="login-form">
        <!-- Giriş formu -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- E-posta alanı -->
            <input type="text" name="eposta" placeholder="E-Posta">
            <br>
            <!-- Şifre alanı -->
            <input type="password" name="sifre" placeholder="Şifre">
            <br>
            <!-- Giriş butonu -->
            <input type="submit" value="Giriş">
        </form>
        <!-- Hata mesajı - eğer hata mesajı varsa gösterilir -->
        <?php if (!empty($hata_mesaji)) { ?>
            <p class="error-message"><?php echo $hata_mesaji; ?></p>
        <?php } ?>
    </div>
</div>
</body>
</html>
