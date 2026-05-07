🍽️ Lezzet Dünyası - Çok Platformlu Yemek Tarifi Sistemi
Bu proje, bir Yazılım Mühendisliği öğrencisi olarak farklı web teknolojilerini ve veritabanı yönetim sistemlerini deneyimlemek amacıyla geliştirilmiştir. Sistem, kullanıcıların yemek tariflerini dinamik olarak yönetebilmesine (CRUD) olanak tanıyan üç farklı teknoloji yığını (Stack) üzerinde kurgulanmıştır.

🚀 Proje Hakkında
Sistem; temel yemek bilgilerinin yanı sıra, malzemelerin kategorize edilmesi (alt başlık desteği) ve tarif adımlarının sıralı bir şekilde sunulması gibi detaylı özelliklere sahiptir. Projenin en büyük özelliği, aynı iş mantığının (Business Logic) üç farklı dilde ve veritabanında birebir aynı çalışacak şekilde implemente edilmiş olmasıdır.
🛠️ Kullanılan TeknolojilerPlatformDil / FrameworkVeritabanıDurumWeb (Legacy)PHPMySQLTamamlandıEnterpriseJava (JSP)PostgreSQLTamamlandıMicrosoft StackASP.NETSQL ServerTamamlandı (Bağımsız Geliştirme)
📂 Proje Yapısı
Repo içerisinde her teknoloji kendi klasöründe, temiz ve modüler bir yapıda tutulmaktadır:

/PHP: WAMP/XAMPP üzerinde koşan, PDO kütüphanesi ile optimize edilmiş sürüm.

/JSP: Apache Tomcat sunucusu ve JDBC sürücüsü ile PostgreSQL entegrasyonu sağlanan kurumsal sürüm.

/ASP: .NET ekosisteminde geliştirilen, SQL Server tabanlı veri yönetimi içeren sürüm.

✨ Öne Çıkan Özellikler
Dinamik Form Yönetimi: JavaScript ile çalışma anında sınırsız malzeme ve tarif adımı ekleyebilme.

Akıllı İçerik Yapısı: Malzeme listelerinde "Sos İçin", "Kek İçin" gibi alt başlıkların veritabanı şemasını bozmadan dinamik olarak yönetilmesi.

Modern UI/UX: Responsive tasarım, Hover efektleri ve kullanıcı dostu arayüz.

İlişkisel Veritabanı: 1:N (One-to-Many) ilişki yapısıyla (Yemek -> Malzemeler / Yemek -> Adımlar) veri bütünlüğü.

⚙️ Kurulum ve Çalıştırma
Her bir klasör kendi içerisinde gerekli db bağlantı sınıflarını ve .sql dosyalarını içermektedir. Genel kurulum adımları:

İlgili veritabanı motorunu (PostgreSQL/MySQL/SQL Server) ayağa kaldırın.

db bağlantı dosyasındaki (Örn: DB.java veya db.php) kimlik bilgilerini güncelleyin.

Uygun web sunucusunda (Tomcat/Apache/IIS) projeyi çalıştırın.
<img width="952" height="489" alt="Ekran görüntüsü 2026-05-07 232522" src="https://github.com/user-attachments/assets/8600f15d-5c34-4bc0-8587-6bf760bb9a32" />
<img width="932" height="943" alt="Ekran görüntüsü 2026-05-07 232513" src="https://github.com/user-attachments/assets/adeb754e-7efa-4649-a895-6ed3b367a623" />
