<?php
// Oturumu başlat
session_start();

// Kullanıcı giriş yapmamışsa giriş sayfasına yönlendir
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: giris.php");
    exit;
}

// Veritabanı bağlantı bilgileri
$servername = "localhost";
$username = "root";
$password = "";
$database = "demirbas";

// Veritabanı bağlantısını oluştur
$conn = new mysqli($servername, $username, $password, $database);

// Bağlantı kontrolü - bağlantıda bir hata oluşursa mesaj göster
if ($conn->connect_error) {
    die("Veritabanına bağlanırken hata oluştu: " . $conn->connect_error);
}

// Oturumdan e-posta ve kullanıcı ID'sini al
$eposta = $_SESSION["eposta"];
$user_id = $_SESSION["user_id"];

// Kullanıcı verilerini sorgula
$sql = "SELECT ad, soyad, sicil_no, eposta, oda_numarasi, unvan, bolum, baslama_tarihi, notlar, resim FROM personel WHERE eposta='$eposta'";
$result = $conn->query($sql);

// Kullanıcı verilerini kontrol et ve al
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Kullanıcı verileri bulunamadı.";
}

// Form gönderildiğinde çalışacak kod bloğu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["degistir"])) {
        // Profil resmini değiştirme işlemi
        if (isset($_FILES["resim"]["name"]) && !empty($_FILES["resim"]["name"])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["resim"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["resim"]["tmp_name"]);

            // Dosyanın bir resim olup olmadığını kontrol et
            if ($check === false) {
                echo "Seçilen dosya bir resim değil.";
                $uploadOk = 0;
            }

            // Dosya yükleme işlemi
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["resim"]["tmp_name"], $target_file)) {
                    $resim = $target_file;

                    // Veritabanında resim yolunu güncelle
                    $sql_update = "UPDATE personel SET resim='$resim' WHERE eposta='$eposta'";
                    
                    if ($conn->query($sql_update) === TRUE) {
                        echo "Görsel değiştirildi.";
                        // Sayfayı yeniden yükle
                        header("Refresh:0");
                    } else {
                        echo "Veritabanına kaydedilirken hata oluştu: " . $conn->error;
                    }
                } else {
                    echo "Dosya yüklenirken bir hata oluştu.";
                }
            }
        } else {
            echo "Görsel seçilmedi.";
        }
    } elseif (isset($_POST["kaydet"])) {
        // Kullanıcı bilgilerini güncelleme işlemi
        $ad = $_POST['ad'];
        $soyad = $_POST['soyad'];
        $sicil_no = $_POST['sicil_no'];
        $eposta = $_POST['eposta'];
        $oda_numarasi = $_POST['oda_numarasi'];
        $unvan = $_POST['unvan'];
        $bolum = $_POST['bolum'];
        $baslama_tarihi = $_POST['baslama_tarihi'];
        $notlar = $_POST['notlar'];

        $sql_update = "UPDATE personel SET ad='$ad', soyad='$soyad', sicil_no='$sicil_no', eposta='$eposta', oda_numarasi='$oda_numarasi', unvan='$unvan', bolum='$bolum', baslama_tarihi='$baslama_tarihi', notlar='$notlar' WHERE eposta='$eposta'";
        
        if ($conn->query($sql_update) === TRUE) {
            echo "Veritabanına kaydedildi.";
            // Sayfayı yeniden yükle
            header("Refresh:0");
        } else {
            echo "Veritabanına kaydedilirken hata oluştu: " . $conn->error;
        }
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
        /* Profil resmi konteyneri stili */
        .img-container {
            display: flex;
            justify-content: center;
            margin-bottom: 50px;
            margin-top: 40px;
        }
        /* Profil resmi stili */
        .img-container img {
            max-width: 250px;
            max-height: 250px;
            width: auto;
            height: auto;
        }
        /* Form grup stili */
        .form-group {
            margin-left: 335px;
        }
        /* Kapat butonu stili */
        .kapat {
            margin-left: 1500px;
        }
        /* Form grup resim stili */
        .form-group-resim {
            text-align: center;
            margin-bottom: 50px;
        }
        /* Uyarı mesajı stili */
        #uyari_mesaji {
            color: red;
        }
        /* Genel body stili */
        body {
            margin: 0px;
        }
        /* Form grup içi stili */
        .form-group {
            margin-top: 20px;
            display: flex;
            text-align: center;
            margin-bottom: 20px;
        }
        /* Form grup içi label stili */
        .form-group label {
            flex: 0 0 10%;
        }
        /* Buton konteyner stili */
        .btn-container {
            margin-top: 50px;
            margin-left: 1550px;
            margin-bottom: 50px;
        }
        /* Buton stili */
        .btn {
            border-radius: 5px; 
            padding: 10px 15px;
            background-color: black;
            color: white; 
        }
        /* Başlık stili */
        h1 {
            text-align: center;
        }
        /* Navbar stili */
        .navbar {
            background-color: black;
        }
        /* Navbar ul stili */
        .navbar ul {
            display: flex;
            justify-content: flex-end;
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        /* Navbar ul li stili */
        .navbar ul li {
            margin-right: 20px;
        }
        /* Navbar ul son li stili */
        .navbar ul li:last-child {
            margin-right: 0;
        }
        /* Navbar ul a stili */
        .navbar ul li a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>

<!-- Başlık -->
<h1>Demirbaş Takip Sistemi</h1>

<!-- Navbar -->
<nav class="navbar">
    <ul>
        <li><a href="genel.php">Genel</a></li>
        <li><a href="donanım.php">Donanım</a></li>
        <li><a class="kapat" href="cikis.php">Kapat</a></li>
    </ul>
</nav>

<!-- Profil bilgilerini ve resim yükleme formunu içeren form -->
<form method="POST" enctype="multipart/form-data">

<!-- Profil resmi konteyneri -->
<div class="img-container">
    <?php 
        // Kullanıcının mevcut profil resmi varsa göster, yoksa varsayılan resmi göster
        if(isset($row['resim']) && !empty($row['resim'])) {
            echo '<img src="' . $row['resim'] . '" alt="Profil Resmi" style="width: 200px; height: auto;">';
        } else {
            echo '<img src="profil.png" alt="Profil Resmi" style="width: 200px; height: auto;">';
        }
    ?>
</div>

<!-- Profil resmi değiştirme form grubu -->
<div class="form-group-resim">
    <label for="resim">Profil Resmi Seç:</label>
    <input type="file" id="resim" name="resim">
    <button type="submit" class="btn" name="degistir">Değiştir</button>
    <br><br>
    <div id="uyari_mesaji"></div>
</div>

<!-- Kullanıcı bilgileri form grubu -->
<div class="form-group">
    <label for="ad">Ad:</label>
    <input type="text" id="ad" name="ad" value="<?php if(isset($row['ad'])) echo $row['ad']; ?>" required>
    <label for="soyad">Soyad:</label><input type="text" id="soyad" name="soyad" value="<?php if(isset($row['soyad'])) echo $row['soyad']; ?>" required>
    <label for="sicil_no">Sicil No:</label>
    <input type="text" id="sicil_no" name="sicil_no" value="<?php if(isset($row['sicil_no'])) echo $row['sicil_no']; ?>" required>
</div>

<div class="form-group">
    <label for="eposta">E-Posta:</label>
    <input type="text" id="eposta" name="eposta" value="<?php if(isset($row['eposta'])) echo $row['eposta']; ?>" required>
    <label for="oda_numarasi">Oda Numarası:</label>
    <input type="text" id="oda_numarasi" name="oda_numarasi" value="<?php if(isset($row['oda_numarasi'])) echo $row['oda_numarasi']; ?>" required>
</div>

<div class="form-group">
    <label for="unvan">Unvan:</label>
    <input type="text" id="unvan" name="unvan" value="<?php if(isset($row['unvan'])) echo $row['unvan']; ?>" required>
    <label for="bolum">Bölüm:</label>
    <input type="text" id="bolum" name="bolum" value="<?php if(isset($row['bolum'])) echo $row['bolum']; ?>" required>
</div>

<div class="form-group">
    <label for="baslama_tarihi">İşe Başlama Tarihi</label>
    <input type="date" id="baslama_tarihi" name="baslama_tarihi" value="<?php if(isset($row['baslama_tarihi'])) echo $row['baslama_tarihi']; ?>" required>
</div>

<div class="form-group">
    <label for="notlar">Notlar:</label>
    <textarea rows="5" cols="135" id="notlar" name="notlar" required><?php if(isset($row['notlar'])) echo $row['notlar']; ?></textarea>
</div>

<div class="btn-container">
    <button type="submit" class="btn" name="kaydet">Kaydet</button>
</div>

</form>

</body>
</html>
