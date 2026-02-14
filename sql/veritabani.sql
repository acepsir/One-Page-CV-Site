-- Veritabanı Oluşturma
CREATE DATABASE IF NOT EXISTS cv_sitesi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cv_sitesi;

-- Kişisel Bilgiler Tablosu
CREATE TABLE IF NOT EXISTS kisisel_bilgiler (
    id INT PRIMARY KEY DEFAULT 1,
    ad_soyad VARCHAR(100),
    unvan VARCHAR(150),
    email VARCHAR(100),
    telefon VARCHAR(50),
    adres VARCHAR(255),
    hakkinda TEXT,
    foto_url VARCHAR(500)
);

-- Yetenekler Tablosu
CREATE TABLE IF NOT EXISTS yetenekler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    yetenek_adi VARCHAR(100),
    seviye INT COMMENT '1-5 arası',
    aciklama VARCHAR(255)
);

-- Deneyimler Tablosu
CREATE TABLE IF NOT EXISTS deneyimler (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pozisyon VARCHAR(100),
    sirket VARCHAR(100),
    tarih VARCHAR(50),
    aciklama TEXT
);

-- Örnek Veriler
INSERT INTO kisisel_bilgiler (id, ad_soyad, unvan, email, telefon, adres, hakkinda, foto_url) VALUES
(1, 'Ahmet Yılmaz', 'Kıdemli Full Stack Geliştirici', 'ahmet@ornek.com', '+90 555 123 45 67', 'İstanbul, Türkiye', 'Yenilikçi ve çözüm odaklı yazılım geliştiricisi. 5 yıldan fazla süredir web teknolojileri üzerine çalışıyorum.', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=500&h=500&q=80')
ON DUPLICATE KEY UPDATE id=1;

INSERT INTO yetenekler (yetenek_adi, seviye, aciklama) VALUES
('PHP & MySQL', 5, 'Backend mimarisi ve veritabanı optimizasyonu'),
('React & Frontend', 4, 'Modern kullanıcı arayüzleri tasarımı'),
('Git & DevOps', 3, 'Sürüm kontrolü ve sunucu yönetimi');

INSERT INTO deneyimler (pozisyon, sirket, tarih, aciklama) VALUES
('Senior Developer', 'Tech Corp', '2020 - Günümüz', 'Büyük ölçekli projelerin yönetimi ve geliştirilmesi.'),
('Junior Developer', 'StartUp A.Ş.', '2018 - 2020', 'Web arayüzlerinin kodlanması.');
