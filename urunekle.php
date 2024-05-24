<!DOCTYPE html>
<html lang="tr">
<head>
    <!-- Meta etiketleri -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Sayfa başlığı -->
    <title>Ürün Ekle</title>
    <!-- Bootstrap CSS dosyası -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Özel CSS dosyası -->
    <link rel="stylesheet" href="temel.css">
</head>
<body>
    <!-- Sayfa başlığı ve navigasyon çubuğu -->
    <nav class="navbar">
        <h1>Ürün Ekle</h1>
    </nav>

    <!-- Ana içerik -->
    <div class="container mt-5">
        <!-- Ürün ekleme formu -->
        <form action="urunekle_post.php" method="POST">
            <!-- Marka giriş alanı -->
            <div class="form-group">
                <label for="marka">Marka:</label>
                <input type="text" class="form-control" id="marka" name="marka" required>
            </div>
            <!-- Model giriş alanı -->
            <div class="form-group">
                <label for="model">Model:</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <!-- Açıklama giriş alanı -->
            <div class="form-group">
                <label for="aciklama">Açıklama:</label>
                <textarea class="form-control" id="aciklama" name="aciklama" rows="3" required></textarea>
            </div>
            <!-- Verildiği tarih giriş alanı -->
            <div class="form-group">
                <label for="verildigiTarih">Verildiği Tarih:</label>
                <input type="date" class="form-control" id="verildigiTarih" name="verildigiTarih" required>
            </div>
            <!-- Ürünü ekle düğmesi -->
            <button type="submit" class="btn btn-primary">Ürünü Ekle</button>
        </form>
    </div>
</body>
</html>
