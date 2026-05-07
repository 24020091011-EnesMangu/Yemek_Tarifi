<%@page import="java.sql.*"%>
<%@page import="com.yemek.db.DB"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<%
    // --- SİLME İŞLEMİ (DELETE) ---
    if (request.getParameter("sil_id") != null) {
        int sil_id = Integer.parseInt(request.getParameter("sil_id"));
        Connection conn = DB.baglan();
        if(conn != null){
            PreparedStatement ps = conn.prepareStatement("DELETE FROM Yemekler WHERE id = ?");
            ps.setInt(1, sil_id);
            ps.executeUpdate();
            conn.close();
        }
        response.sendRedirect("index.jsp");
        return; // İşlem bitince alttaki HTML'i yüklemesin diye return atıyoruz
    }

    // --- EKLEME İŞLEMİ (CREATE) ---
    if (request.getMethod().equalsIgnoreCase("POST") && request.getParameter("yemek_adi") != null) {
        request.setCharacterEncoding("UTF-8"); // Türkçe karakter sorunu olmasın diye
        
        String yemek_adi = request.getParameter("yemek_adi");
        String fotograf_url = request.getParameter("fotograf_url");

        Connection conn = DB.baglan();
        if(conn != null){
            // 1. Yemeği Ekle ve Eklenen ID'yi al (Statement.RETURN_GENERATED_KEYS)
            String sqlYemek = "INSERT INTO Yemekler (yemek_adi, fotograf_url) VALUES (?, ?)";
            PreparedStatement psYemek = conn.prepareStatement(sqlYemek, Statement.RETURN_GENERATED_KEYS);
            psYemek.setString(1, yemek_adi);
            psYemek.setString(2, fotograf_url);
            psYemek.executeUpdate();

            ResultSet rs = psYemek.getGeneratedKeys();
            int yemek_id = 0;
            if(rs.next()){
                yemek_id = rs.getInt(1);
            }

            // 2. Malzemeleri ve Alt Başlıkları Ekle
            String[] malzeme_adlari = request.getParameterValues("malzeme_adi[]");
            String[] tipler = request.getParameterValues("tip[]");

            if(malzeme_adlari != null && yemek_id > 0){
                String sqlMalzeme = "INSERT INTO Malzemeler (yemek_id, malzeme_adi, miktar) VALUES (?, ?, ?)";
                PreparedStatement psMalzeme = conn.prepareStatement(sqlMalzeme);
                for(int i = 0; i < malzeme_adlari.length; i++){
                    String m_adi = malzeme_adlari[i];
                    String m_tip = (tipler != null && i < tipler.length) ? tipler[i] : "malzeme";
                    
                    if(m_adi != null && !m_adi.trim().isEmpty()){
                        psMalzeme.setInt(1, yemek_id);
                        psMalzeme.setString(2, m_adi);
                        psMalzeme.setString(3, m_tip); // "baslik" veya "malzeme" bilgisini buraya yazıyoruz
                        psMalzeme.executeUpdate();
                    }
                }
            }

            // 3. Tarif Adımlarını Ekle
            String[] aciklamalar = request.getParameterValues("aciklama[]");
            if(aciklamalar != null && yemek_id > 0){
                String sqlAdim = "INSERT INTO Tarif_Adimlari (yemek_id, adim_sirasi, aciklama) VALUES (?, ?, ?)";
                PreparedStatement psAdim = conn.prepareStatement(sqlAdim);
                for(int i = 0; i < aciklamalar.length; i++){
                    String t_aciklama = aciklamalar[i];
                    
                    if(t_aciklama != null && !t_aciklama.trim().isEmpty()){
                        psAdim.setInt(1, yemek_id);
                        psAdim.setInt(2, (i + 1));
                        psAdim.setString(3, t_aciklama);
                        psAdim.executeUpdate();
                    }
                }
            }
            conn.close();
        }
        response.sendRedirect("index.jsp");
        return;
    }
%>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yeni Tarif Ekle - JSP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Yeni Tarif Ekle (Java & PostgreSQL)</h2>
        <form method="POST" action="islem.jsp">
            
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
                <button type="button" class="btn-kucuk" style="background-color: #e15f41;" onclick="baslikEkle()">+ Alt Başlık Ekle</button>
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
            <a href="index.jsp" class="btn btn-danger" style="text-align:center;">İptal ve Geri Dön</a>
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

        function baslikE