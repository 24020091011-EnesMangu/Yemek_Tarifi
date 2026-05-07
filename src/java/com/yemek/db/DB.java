package com.yemek.db;

import java.sql.Connection;
import java.sql.DriverManager;

public class DB {
    public static Connection baglan() {
        Connection conn = null;
        try {
            // PostgreSQL sürücüsünü yükle
            Class.forName("org.postgresql.Driver");
            // Veritabanı bilgilerini gir (port: 5432)
            conn = DriverManager.getConnection(
                "jdbc:postgresql://localhost:5432/Yemek_Tarifi", "postgres", "enes");
        } catch (Exception e) {
            System.out.println("Bağlantı Hatası: " + e.getMessage());
        }
        return conn;
    }
}