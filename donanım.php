<?php
session_start();

// Oturum kontrolü, oturum açık değilse giriş sayfasına yönlendirme
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: giris.php");
    exit;
}

// Veritabanı bağlantısı
$servername = "localhost";
$username = "root";
$password = "";
$database = "demirbas";

$conn = new mysqli($servername, $username, $password, $database);

// Veritabanı bağlantı hatası kontrolü
if ($conn->connect_error) {
    die("Veritabanına bağlanırken hata oluştu: " . $conn->connect_error);
}

// Kullanıcı ID'sini al, eğer yoksa varsayılan olarak 1
$user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : 1;

// Kullanıcının e-postasına göre donanım bilgilerini sorgula
$eposta = $_SESSION["eposta"];
$sql = "SELECT donanim.*, personel.id AS personel_id FROM donanim JOIN personel ON donanim.kullanici_id = personel.id WHERE personel.eposta = '$eposta'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demirbaş Takip Sistemi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        h1 {
            text-align:center;
        }

        .navbar {
            display: flex;
            justify-content: flex-end;
            background-color: black;
            padding: 10px 20px;
        }

        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .navbar ul li {
            display: inline;
            margin-right: 20px;
        }

        .navbar ul li:last-child {
            margin-right: 0;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
        }

        .tablo-duzen {
            margin: 100px auto; 
            width: 80%; 
            text-align:center;
        }

        .btn-container {
            text-align: center;
            margin-top: 100px;
        }

        .btn {
            border: 2px solid #ffffff;
            border-radius: 5px; 
            padding: 10px 15px;
            background-color: black;
            color: white; 
        }
    </style>
    <script>
        function redirectToKasaBilgileri() {
            window.location.href = "kasabilgileri.php";
        }
    </script>
</head>
<body>

<h1>Demirbaş Takip Sistemi</h1>
    
<nav class="navbar">
    <ul>
        <li><a href="genel.php">Genel</a></li>
        <li><a href="donanım.php">Donanım</a></li>
        <li><a class="kapat" href="cikis.php">Kapat</a></li>
    </ul>
</nav>

<?php
// Donanım bilgileri tablosunu oluştur
if ($result->num_rows > 0) {
    echo "<div class='tablo-duzen'>";
    echo "<table class='table table-striped'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Id</th>";
    echo "<th>Marka</th>";
    echo "<th>Model</th>";
    echo "<th>Açıklama</th>";
    echo "<th>Verildiği Tarih</th>";
    echo "<th>Kullanıcı ID</th>";
    echo "<th>İşlemler</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["marka"] . "</td>";
        echo "<td>" . $row["model"] . "</td>";
        echo "<td>" . $row["aciklama"] . "</td>";
        echo "<td>" . $row["verildigiTarih"] . "</td>";
        echo "<td>" . $row["personel_id"] . "</td>";
        echo "<td>
                <a href='kasabilgileri.php?id=" . $row["id"] . "' class='btn btn-primary btn-sm'>Kasa Bilgileri</a>
                <a href='sil.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'>Sil</a>
              </td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo "<p class='text-center'>Tabloda hiç veri bulunamadı.</p>";
}

// Veritabanı bağlantısını kapat
$conn->close();
?>

<div class="btn-container">
    <button type="button" class="btn" onclick="window.location.href='urunekle.php'">Ürün Ekle</button>
</div>
    
</body>
</html>
