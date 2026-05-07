<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yemek Tarifleri</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        
        <div class="header-alani">
            <h1>🍽️ Lezzet Dünyası</h1>
            <a href="islem.php" class="btn btn-ekle">+ Yeni Tarif Ekle</a>
        </div>
        
        <div class="grid">
            <?php
            $sorgu = $db->query("SELECT * FROM Yemekler", PDO::FETCH_ASSOC);
            foreach($sorgu as $yemek) {
                echo "<div class='card'>";
                echo "<img src='" . htmlspecialchars($yemek['fotograf_url']) . "' alt='Yemek Foto'>";
                echo "<h3>" . htmlspecialchars($yemek['yemek_adi']) . "</h3>";
                
                echo "<div class='btn-group'>";
                echo "<a href='detay.php?id=" . $yemek['id'] . "' class='btn btn-bilgi'>Tarifi Gör</a>";
                echo "<a href='islem.php?sil_id=" . $yemek['id'] . "' class='btn btn-danger'>Sil</a>";
                echo "</div>";
                
                echo "</div>";
            }
            ?>
        </div>
        
    </div>
</body>
</html>