<?php
session_start();

// Veritabanı bilgileri
$servername = "localhost";
$username = "root";
$password = "";
$database = "demirbas";

// Veritabanı bağlantısı
$conn = new mysqli($servername, $username, $password, $database);

// Veritabanı bağlantı hatası kontrolü
if ($conn->connect_error) {
    die("Veritabanına bağlanırken hata oluştu: " . $conn->connect_error);
}

// Kasa ID'sini al
$donanim_id = $_GET["id"];

// Kasa bilgilerini sorgula
$sql = "SELECT * FROM kasa WHERE id = $donanim_id";
$result = $conn->query($sql);

// Kasa bilgileri bulunursa
if ($result->num_rows > 0) {
    // Kasa bilgilerini al
    $row = $result->fetch_assoc();
} else {
    echo "Kasa bilgileri bulunamadı.";
}

// Verilerin güncellenmesi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Güncellenecek verileri al
    $demirbas_no = $_POST['demirbas_no'];
    $isletim_sistemi = $_POST['isletim_sistemi'];
    $islemci_model = $_POST['islemci_model'];
    $ram = $_POST['ram'];
    $disk_kapasite = $_POST['disk_kapasite'];
    $ekran_karti = $_POST['ekran_karti'];
    $model = $_POST['model'];
    $islemci_hizi = $_POST['islemci_hizi'];
    $cekirdek_sayisi = $_POST['cekirdek_sayisi'];
    $ekran_boyut = $_POST['ekran_boyut'];

    // Güncelleme sorgusunu hazırla
    $update_sql = "UPDATE kasa SET 
                    demirbas_no = '$demirbas_no', 
                    isletim_sistemi = '$isletim_sistemi', 
                    islemci_model = '$islemci_model', 
                    ram = '$ram', 
                    disk_kapasite = '$disk_kapasite', 
                    ekran_karti = '$ekran_karti', 
                    model = '$model', 
                    islemci_hizi = '$islemci_hizi', 
                    cekirdek_sayisi = '$cekirdek_sayisi', 
                    ekran_boyut = '$ekran_boyut'
                  WHERE id = $donanim_id";

    // Güncelleme sorgusunu çalıştır
    if ($conn->query($update_sql) === TRUE) {
        echo "Bilgiler başarıyla güncellendi";
    } else {
        echo "Hata: " . $conn->error;
    }
}

// Veritabanı bağlantısını kapat
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasa Bilgileri</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="temel.css">
</head>
<body>
    <nav class="navbar">
        <h1>Kasa Bilgileri</h1>
    </nav>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=$donanim_id"); ?>">
        <div class="form-group">
            <label for="demirbas_no">Demirbaş No:</label>
            <input type="text" id="demirbas_no" name="demirbas_no" value="<?php echo isset($row['demirbas_no']) ? $row['demirbas_no'] : ''; ?>">
        </div>
        <div class="form-group">
            <label for="isletim_sistemi">İşletim Sistemi:</label>
            <input type="text" id="isletim_sistemi" name="isletim_sistemi" value="<?php echo isset($row['isletim_sistemi']) ? $row['isletim_sistemi'] : ''; ?>">
        </div>
        <div class="form-group">
            <label for="islemci_model">İşlemci Model:</label>
            <input type="text" id="islemci_model" name="islemci_model" value="<?php echo isset($row['islemci_model']) ? $row['islemci_model'] : ''; ?>">
        </div>
        <div class="form-group">
    <label for="ram">RAM:</label>
    <input type="text" id="ram" name="ram" value="<?php echo isset($row['ram']) ? $row['ram'] : ''; ?>"> &nbsp; GB
</div>
<div class="form-group">
    <label for="disk_kapasite">Disk Kapasite:</label>
    <input type="text" id="disk_kapasite" name="disk_kapasite" value="<?php echo isset($row['disk_kapasite']) ? $row['disk_kapasite'] : ''; ?>"> &nbsp; GB
</div>
<div class="form-group">
    <label for="ekran_karti">Ekran Kartı:</label>
    <input type="text" id="ekran_karti" name="ekran_karti" value="<?php echo isset($row['ekran_karti']) ? $row['ekran_karti'] : ''; ?>">
</div>
<div class="form-group">
    <label for="model">Model:</label>
    <input type="text" id="model" name="model" value="<?php echo isset($row['model']) ? $row['model'] : ''; ?>">
</div>
<div class="form-group">
    <label for="islemci_hizi">İşlemci Hızı:</label>
    <input type="text" id="islemci_hizi" name="islemci_hizi" value="<?php echo isset($row['islemci_hizi']) ? $row['islemci_hizi'] : ''; ?>"> &nbsp; GHz
</div>
<div class="form-group">
    <label for="cekirdek_sayisi">Çekirdek Sayısı:</label>
    <input type="text" id="cekirdek_sayisi" name="cekirdek_sayisi" value="<?php echo isset($row['cekirdek_sayisi']) ? $row['cekirdek_sayisi'] : ''; ?>">
</div>
<div class="form-group">
    <label for="ekran_boyut">Ekran Boyutu:</label>
    <input type="text" id="ekran_boyut" name="ekran_boyut" value="<?php echo isset($row['ekran_boyut']) ? $row['ekran_boyut'] : ''; ?>"> &nbsp; inç
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">Güncelle</button>
</div>
</form>
</body>
</html>
