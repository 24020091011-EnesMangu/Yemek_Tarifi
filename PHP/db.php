<?php
$host = 'localhost';
$dbname = 'yemek_tarifi';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password='1243');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Bağlantı Hatası: " . $e->getMessage();
    die();
}
?>