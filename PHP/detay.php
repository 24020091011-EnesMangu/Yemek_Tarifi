<?php 
include 'db.php'; 

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$yemek_id = $_GET['id'];

$yemek_sorgu = $db->prepare("SELECT * FROM Yemekler WHERE id = ?");
$yemek_sorgu->execute([$yemek_id]);
$yemek = $yemek_sorgu->fetch(PDO::FETCH_ASSOC);

if (!$yemek) { echo "Yemek bulunamadı!"; exit(); }

$malzeme_sorgu = $db->prepare("SELECT * FROM Malzemeler WHERE yemek_id = ?");
$malzeme_sorgu->execute([$yemek_id]);
$malzemeler = $malzeme_sorgu->fetchAll(PDO::FETCH_ASSOC);

$tarif_sorgu = $db->prepare("SELECT * FROM Tarif_Adimlari WHERE yemek_id = ? ORDER BY id ASC");
$tarif_sorgu->execute([$yemek_id]);
$adimlar = $tarif_sorgu->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($yemek['yemek_adi']) ?> Tarifi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1><?= htmlspecialchars($yemek['yemek_adi']) ?></h1>
        
        <img src="<?= htmlspecialchars($yemek['fotograf_url']) ?>" alt="Yemek Resmi" class="detay-resim">
        
        <h3>Malzemeler ve Alışveriş Listesi</h3>
        <div class="liste">
            <ul style="list-style-type: none; padding-left: 0;">
                <?php foreach($malzemeler as $malzeme): ?>
                    
                    <?php if($malzeme['miktar'] == 'baslik'): ?>
                        <h4 style="color: #e15f41; margin-top: 25px; margin-bottom: 10px; font-weight: 700; border-bottom: 2px solid #f1f2f6; padding-bottom: 5px;">
                            <?= htmlspecialchars($malzeme['malzeme_adi']) ?>
                        </h4>
                    <?php else: ?>
                        <li style="margin-bottom: 8px; position: relative; padding-left: 25px;">
                            <span style="position: absolute; left: 0; color: #00b894; font-weight: bold;">✔</span> 
                            <?= htmlspecialchars($malzeme['malzeme_adi']) ?>
                        </li>
                    <?php endif; ?>

                <?php endforeach; ?>
                <?php if(empty($malzemeler)) echo "<li>Malzeme bilgisi girilmemiş.</li>"; ?>
            </ul>
        </div>

        <h3>Tarif Adımları</h3>
        <div class="liste">
            <ol>
                <?php foreach($adimlar as $adim): ?>
                    <li style="margin-bottom: 15px; padding-left: 5px;"><?= htmlspecialchars($adim['aciklama']) ?></li>
                <?php endforeach; ?>
                <?php if(empty($adimlar)) echo "<li>Tarif adımı girilmemiş.</li>"; ?>
            </ol>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <a href="index.php" class="btn">Ana Sayfaya Dön</a>
        </div>
    </div>
</body>
</html>