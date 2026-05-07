<?php 
include 'db.php'; 

if (isset($_GET['sil_id'])) {
    $sil_id = $_GET['sil_id'];
    $sorgu = $db->prepare("DELETE FROM Yemekler WHERE id = ?");
    $sorgu->execute([$sil_id]);
    header("Location: index.php");
    exit();
}

if (isset($_POST['kaydet'])) {
    $yemek_adi = $_POST['yemek_adi'];
    $fotograf_url = $_POST['fotograf_url'];
    
    $sorgu = $db->prepare("INSERT INTO Yemekler (yemek_adi, fotograf_url) VALUES (?, ?)");
    $sorgu->execute([$yemek_adi, $fotograf_url]);
    
    $yemek_id = $db->lastInsertId();

    // Malzemeleri ve Başlıkları Ekle
    if(!empty($_POST['malzeme_adi'])){
        $malzeme_sorgu = $db->prepare("INSERT INTO Malzemeler (yemek_id, malzeme_adi, miktar) VALUES (?, ?, ?)");
        $malzeme_sayisi = count($_POST['malzeme_adi']);
        
        for($i = 0; $i < $malzeme_sayisi; $i++) {
            $m_adi = $_POST['malzeme_adi'][$i];
            // Gizli input'tan gelen veriyi ('malzeme' veya 'baslik') alıyoruz
            $m_mik = isset($_POST['tip'][$i]) ? $_POST['tip'][$i] : "malzeme"; 
            
            if(!empty($m_adi)) {
                $malzeme_sorgu->execute([$yemek_id, $m_adi, $m_mik]);
            }
        }
    }

    if(!empty($_POST['aciklama'])){
        $tarif_sorgu = $db->prepare("INSERT INTO Tarif_Adimlari (yemek_id, adim_sirasi, aciklama) VALUES (?, ?, ?)");
        $adim_sayisi = count($_POST['aciklama']);
        
        for($i = 0; $i < $adim_sayisi; $i++) {
            $t_aciklama = $_POST['aciklama'][$i];
            
            if(!empty($t_aciklama)) {
                $tarif_sorgu->execute([$yemek_id, ($i + 1), $t_aciklama]);
            }
        }
    }

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Tarif Ekle</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Yeni Tarif Ekle (CRUD Ekranı)</h2>
        <form method="POST" action="islem.php">
            
            <input type="text" name="yemek_adi" placeholder="Yemek Adı (Örn: Trileçe)" required>
            <input type="text" name="fotograf_url" placeholder="Fotoğraf Linki (Örn: trilece.jpg)" required>
            
            <hr>
            
            <h4>Malzemeler ve Kategoriler</h4>
            <div id="malzemeler-alani">
                <div class="flex-row">
                    <input type="text" name="malzeme_adi[]" placeholder="Malzeme (Örn: 5 adet yumurta)">
                    <input type="hidden" name="tip[]" value="malzeme">
                </div>
            </div>
            
            <div style="display: flex; gap: 10px;">
                <button type="button" class="btn-kucuk" onclick="malzemeEkle()">+ Malzeme Satırı</button>
                <button type="button" class="btn-kucuk" style="background-color: #e15f41;" onclick="baslikEkle()">+ Alt Başlık Ekle (Sosu için vb.)</button>
            </div>
            
            <hr>
            
            <h4>Tarif Adımları</h4>
            <div id="adimlar-alani">
                <div class="flex-row">
                    <textarea name="aciklama[]" rows="2" placeholder="1. Adımı yazın..."></textarea>
                </div>
            </div>
            <button type="button" class="btn-kucuk" onclick="adimEkle()">+ Yeni Adım Satırı Ekle</button>
            
            <br><br>
            <button type="submit" name="kaydet" class="btn">Tarifi Kaydet</button>
            <a href="index.php" class="btn btn-danger" style="text-align:center;">İptal ve Geri Dön</a>
        </form>
    </div>

    <script>
        function malzemeEkle() {
            let alan = document.getElementById('malzemeler-alani');
            let div = document.createElement('div');
            div.className = 'flex-row';
            div.innerHTML = `
                <input type="text" name="malzeme_adi[]" placeholder="Malzeme (Örn: 1 su bardağı un)">
                <input type="hidden" name="tip[]" value="malzeme">
            `;
            alan.appendChild(div);
        }

        // Başlık eklemek için özel fonksiyon (Arka planı sarı olur, göze çarpar)
        function baslikEkle() {
            let alan = document.getElementById('malzemeler-alani');
            let div = document.createElement('div');
            div.className = 'flex-row';
            div.innerHTML = `
                <input type="text" name="malzeme_adi[]" placeholder="Alt Başlık (Örn: Sütlü sosu için)" style="background-color: #fff3cd; font-weight: bold; color: #856404; border-color: #ffeeba;">
                <input type="hidden" name="tip[]" value="baslik">
            `;
            alan.appendChild(div);
        }

        function adimEkle() {
            let alan = document.getElementById('adimlar-alani');
            let div = document.createElement('div');
            div.className = 'flex-row';
            div.innerHTML = `
                <textarea name="aciklama[]" rows="2" placeholder="Sonraki adımı yazın..."></textarea>
            `;
            alan.appendChild(div);
        }
    </script>
</body>
</html>