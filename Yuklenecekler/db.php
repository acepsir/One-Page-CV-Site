<?php
// Veritabanı Ayarları
// Sunucunuza yüklerken bu bilgileri güncelleyin!
$host = 'localhost';
$dbname = 'cv_sitesi';
$username = 'root';      
$password = '';          

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Güvenlik için hata detayını production ortamında gizleyebilirsiniz
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>