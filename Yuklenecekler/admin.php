<?php
session_start();
require_once 'db.php';

// Basit Şifre Koruması
$ADMIN_SIFRE = "1234"; // BURAYI DEĞİŞTİRİN!

// Çıkış Yap
if (isset($_GET['cikis'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// Giriş Yap
if (isset($_POST['giris'])) {
    if ($_POST['sifre'] === $ADMIN_SIFRE) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $login_error = "Hatalı şifre!";
    }
}

// Oturum Kontrolü
if (!isset($_SESSION['admin_logged_in'])) {
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Giriş</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: sans-serif; background-color: #f1f5f9; }</style>
</head>
<body class="flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-6 text-center text-slate-800">Admin Girişi</h2>
        <?php if(isset($login_error)) echo "<p class='text-red-500 text-sm mb-4 text-center'>$login_error</p>"; ?>
        <form method="POST">
            <input type="password" name="sifre" placeholder="Şifre" class="w-full px-4 py-2 border rounded-lg mb-4 focus:ring-2 focus:ring-indigo-500 outline-none">
            <button type="submit" name="giris" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">Giriş Yap</button>
        </form>
        <p class="text-center mt-4"><a href="index.php" class="text-slate-500 text-sm hover:underline">Siteye Dön</a></p>
    </div>
</body>
</html>
<?php
    exit;
}

// --- BURADAN AŞAĞISI GİRİŞ YAPILMIŞ ALAN ---

// İşlemler (POST)
$mesaj = '';

// 1. Kişisel Bilgi Güncelleme
if (isset($_POST['guncelle_kisisel'])) {
    $sql = "UPDATE kisisel_bilgiler SET ad_soyad=?, unvan=?, email=?, telefon=?, adres=?, hakkinda=?, foto_url=? WHERE id=1";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        $_POST['ad_soyad'], $_POST['unvan'], $_POST['email'], 
        $_POST['telefon'], $_POST['adres'], $_POST['hakkinda'], $_POST['foto_url']
    ]);
    $mesaj = "Bilgiler başarıyla güncellendi!";
}

// 2. Yetenek İşlemleri
if (isset($_POST['ekle_yetenek'])) {
    $stmt = $db->prepare("INSERT INTO yetenekler (yetenek_adi, seviye, aciklama) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['yetenek_adi'], $_POST['seviye'], $_POST['aciklama']]);
    header("Location: admin.php?tab=yetenekler"); exit;
}
if (isset($_GET['sil_yetenek'])) {
    $stmt = $db->prepare("DELETE FROM yetenekler WHERE id = ?");
    $stmt->execute([$_GET['sil_yetenek']]);
    header("Location: admin.php?tab=yetenekler"); exit;
}

// 3. Deneyim İşlemleri
if (isset($_POST['ekle_deneyim'])) {
    $stmt = $db->prepare("INSERT INTO deneyimler (pozisyon, sirket, tarih, aciklama) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['pozisyon'], $_POST['sirket'], $_POST['tarih'], $_POST['aciklama']]);
    header("Location: admin.php?tab=deneyimler"); exit;
}
if (isset($_GET['sil_deneyim'])) {
    $stmt = $db->prepare("DELETE FROM deneyimler WHERE id = ?");
    $stmt->execute([$_GET['sil_deneyim']]);
    header("Location: admin.php?tab=deneyimler"); exit;
}

// Verileri Çek
$kisisel = $db->query("SELECT * FROM kisisel_bilgiler WHERE id = 1")->fetch();
$yetenekler = $db->query("SELECT * FROM yetenekler ORDER BY id ASC")->fetchAll();
$deneyimler = $db->query("SELECT * FROM deneyimler ORDER BY id DESC")->fetchAll();

$aktifTab = isset($_GET['tab']) ? $_GET['tab'] : 'kisisel';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yönetim Paneli</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }</style>
</head>
<body class="pb-20">

    <!-- Header -->
    <div class="sticky top-0 z-50 bg-slate-900 text-white px-6 py-4 shadow-md flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold">Admin Panel</h2>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                <p class="text-slate-400 text-xs">Aktif Oturum</p>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="index.php" class="px-4 py-2 rounded-lg text-sm text-slate-300 hover:bg-slate-800 transition-colors" target="_blank">Siteyi Görüntüle</a>
            <a href="?cikis=1" class="px-4 py-2 rounded-lg text-sm bg-red-600 text-white hover:bg-red-700 transition-colors">Çıkış</a>
        </div>
    </div>

    <div class="max-w-4xl mx-auto mt-8 px-4">
        
        <?php if($mesaj): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-sm"><?php echo $mesaj; ?></div>
        <?php endif; ?>

        <!-- Tab Menü -->
        <div class="flex space-x-1 bg-slate-100 p-1 rounded-xl mb-8">
            <a href="?tab=kisisel" class="flex-1 py-2.5 text-center text-sm font-medium rounded-lg transition-all <?php echo $aktifTab == 'kisisel' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'; ?>">Kişisel Bilgiler</a>
            <a href="?tab=yetenekler" class="flex-1 py-2.5 text-center text-sm font-medium rounded-lg transition-all <?php echo $aktifTab == 'yetenekler' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'; ?>">Nitelikler</a>
            <a href="?tab=deneyimler" class="flex-1 py-2.5 text-center text-sm font-medium rounded-lg transition-all <?php echo $aktifTab == 'deneyimler' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'; ?>">Deneyim</a>
        </div>

        <!-- İÇERİK: Kişisel -->
        <?php if($aktifTab == 'kisisel'): ?>
        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-white p-6 rounded-xl shadow-sm">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Profil Fotoğrafı URL</label>
                <input type="text" name="foto_url" value="<?php echo htmlspecialchars($kisisel['foto_url']); ?>" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Ad Soyad</label>
                <input type="text" name="ad_soyad" value="<?php echo htmlspecialchars($kisisel['ad_soyad']); ?>" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Ünvan</label>
                <input type="text" name="unvan" value="<?php echo htmlspecialchars($kisisel['unvan']); ?>" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">E-posta</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($kisisel['email']); ?>" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Telefon</label>
                <input type="text" name="telefon" value="<?php echo htmlspecialchars($kisisel['telefon']); ?>" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Konum</label>
                <input type="text" name="adres" value="<?php echo htmlspecialchars($kisisel['adres']); ?>" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-1">Hakkımda</label>
                <textarea name="hakkinda" rows="4" class="w-full px-4 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none"><?php echo htmlspecialchars($kisisel['hakkinda']); ?></textarea>
            </div>
            <div class="md:col-span-2">
                <button type="submit" name="guncelle_kisisel" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-bold hover:bg-indigo-700 transition">Kaydet</button>
            </div>
        </form>
        <?php endif; ?>

        <!-- İÇERİK: Yetenekler -->
        <?php if($aktifTab == 'yetenekler'): ?>
        <div class="space-y-6">
            <!-- Liste -->
            <?php foreach($yetenekler as $skill): ?>
            <div class="bg-white p-4 rounded-xl border border-slate-200 flex justify-between items-center shadow-sm">
                <div>
                    <h4 class="font-bold text-slate-800"><?php echo htmlspecialchars($skill['yetenek_adi']); ?> <span class="text-xs text-indigo-500 bg-indigo-50 px-2 py-1 rounded ml-2">Seviye: <?php echo $skill['seviye']; ?></span></h4>
                    <p class="text-sm text-slate-500"><?php echo htmlspecialchars($skill['aciklama']); ?></p>
                </div>
                <a href="?sil_yetenek=<?php echo $skill['id']; ?>" onclick="return confirm('Bu yeteneği silmek istediğinize emin misiniz?')" class="text-red-400 hover:text-red-600 p-2">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                </a>
            </div>
            <?php endforeach; ?>

            <!-- Ekleme Formu -->
            <form method="POST" class="bg-slate-50 p-6 rounded-xl border border-dashed border-slate-300">
                <h3 class="font-bold text-slate-700 mb-4">Yeni Yetenek Ekle</h3>
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <input type="text" name="yetenek_adi" placeholder="Yetenek Adı" required class="w-full px-3 py-2 rounded border border-slate-300 focus:border-indigo-500 focus:outline-none">
                    <input type="number" name="seviye" min="1" max="5" placeholder="Seviye (1-5)" required class="w-full px-3 py-2 rounded border border-slate-300 focus:border-indigo-500 focus:outline-none">
                </div>
                <input type="text" name="aciklama" placeholder="Kısa Açıklama" required class="w-full px-3 py-2 rounded border border-slate-300 mb-4 focus:border-indigo-500 focus:outline-none">
                <button type="submit" name="ekle_yetenek" class="w-full bg-slate-800 text-white py-2 rounded-lg hover:bg-slate-700">Ekle</button>
            </form>
        </div>
        <?php endif; ?>

        <!-- İÇERİK: Deneyimler -->
        <?php if($aktifTab == 'deneyimler'): ?>
        <div class="space-y-6">
            <!-- Liste -->
            <?php foreach($deneyimler as $exp): ?>
            <div class="bg-white p-4 rounded-xl border border-slate-200 flex justify-between items-start shadow-sm">
                <div>
                    <h4 class="font-bold text-slate-800"><?php echo htmlspecialchars($exp['pozisyon']); ?></h4>
                    <div class="text-sm text-slate-500 mb-1"><?php echo htmlspecialchars($exp['sirket']); ?> | <?php echo htmlspecialchars($exp['tarih']); ?></div>
                    <p class="text-xs text-slate-400"><?php echo htmlspecialchars($exp['aciklama']); ?></p>
                </div>
                <a href="?sil_deneyim=<?php echo $exp['id']; ?>" onclick="return confirm('Bu deneyimi silmek istediğinize emin misiniz?')" class="text-red-400 hover:text-red-600 p-2">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                </a>
            </div>
            <?php endforeach; ?>

            <!-- Ekleme Formu -->
            <form method="POST" class="bg-slate-50 p-6 rounded-xl border border-dashed border-slate-300">
                <h3 class="font-bold text-slate-700 mb-4">Yeni Deneyim Ekle</h3>
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <input type="text" name="pozisyon" placeholder="Pozisyon / Ünvan" required class="w-full px-3 py-2 rounded border border-slate-300 focus:border-indigo-500 focus:outline-none">
                    <input type="text" name="sirket" placeholder="Şirket Adı" required class="w-full px-3 py-2 rounded border border-slate-300 focus:border-indigo-500 focus:outline-none">
                    <div class="md:col-span-2">
                        <input type="text" name="tarih" placeholder="Tarih Aralığı (Örn: 2020 - 2023)" required class="w-full px-3 py-2 rounded border border-slate-300 focus:border-indigo-500 focus:outline-none">
                    </div>
                </div>
                <textarea name="aciklama" rows="3" placeholder="İş tanımı..." required class="w-full px-3 py-2 rounded border border-slate-300 mb-4 focus:border-indigo-500 focus:outline-none"></textarea>
                <button type="submit" name="ekle_deneyim" class="w-full bg-slate-800 text-white py-2 rounded-lg hover:bg-slate-700">Ekle</button>
            </form>
        </div>
        <?php endif; ?>

    </div>
</body>
</html>