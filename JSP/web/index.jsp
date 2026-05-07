<%@page import="java.sql.*"%>
<%@page import="com.yemek.db.DB"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Yemek Tarifleri - JSP</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <div class="header-alani">
                <h1>🍽️ Lezzet Dünyası (JSP)</h1>
                <a href="islem.jsp" class="btn btn-ekle">+ Yeni Tarif Ekle</a>
            </div>
            
            <div class="grid">
                <%
                    Connection conn = DB.baglan();
                    if (conn != null) {
                        Statement stmt = conn.createStatement();
                        ResultSet rs = stmt.executeQuery("SELECT * FROM Yemekler ORDER BY id DESC");
                        while (rs.next()) {
                %>
                    <div class="card">
                        <img src="<%= rs.getString("fotograf_url") %>" alt="Yemek">
                        <h3><%= rs.getString("yemek_adi") %></h3>
                        <div class="btn-group">
                            <a href="detay.jsp?id=<%= rs.getInt("id") %>" class="btn btn-bilgi">Tarifi Gör</a>
                            <a href="islem.jsp?sil_id=<%= rs.getInt("id") %>" class="btn btn-danger">Sil</a>
                        </div>
                    </div>
                <%
                        }
                        conn.close();
                    }
                %>
            </div>
        </div>
    </body>
</html>