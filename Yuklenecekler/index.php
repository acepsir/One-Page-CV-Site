<?php
require_once 'db.php';

// Verileri Çek
$kisisel = $db->query("SELECT * FROM kisisel_bilgiler WHERE id = 1")->fetch();
$yetenekler = $db->query("SELECT * FROM yetenekler ORDER BY id ASC")->fetchAll();
$deneyimler = $db->query("SELECT * FROM deneyimler ORDER BY id DESC")->fetchAll();

// Yıldız Helper Fonksiyonu
function yildizGoster($seviye) {
    $html = '<div class="flex gap-1 text-yellow-400">';
    for ($i = 0; $i < 5; $i++) {
        $fill = $i < $seviye ? 'currentColor' : 'none';
        $class = $i < $seviye ? 'text-yellow-400' : 'text-gray-300';
        $html .= '<svg width="16" height="16" viewBox="0 0 24 24" fill="'.$fill.'" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'.$class.'"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>';
    }
    $html .= '</div>';
    return $html;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($kisisel['ad_soyad']); ?> - CV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
    </style>
</head>
<body>

    <div class="max-w-5xl mx-auto bg-white shadow-xl min-h-screen flex flex-col md:flex-row overflow-hidden rounded-lg my-8 relative">
        
        <!-- Sidebar -->
        <aside class="w-full md:w-1/3 bg-slate-900 text-white p-8 flex flex-col">
            <div class="flex flex-col items-center text-center mb-8">
                <div class="w-40 h-40 rounded-full border-4 border-white/20 overflow-hidden mb-6 shadow-lg">
                    <img src="<?php echo htmlspecialchars($kisisel['foto_url']); ?>" alt="Profil" class="w-full h-full object-cover">
                </div>
                <h1 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($kisisel['ad_soyad']); ?></h1>
                <p class="text-indigo-400 font-medium uppercase tracking-wide text-sm mb-6">
                    <?php echo htmlspecialchars($kisisel['unvan']); ?>
                </p>
            </div>

            <div class="space-y-6">
                <div class="flex flex-col gap-4">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-700 pb-2">İletişim</h3>
                    
                    <div class="flex items-center gap-3 text-slate-300 text-sm hover:text-white transition-colors">
                        <div class="bg-slate-800 p-2 rounded-lg">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        </div>
                        <span><?php echo htmlspecialchars($kisisel['email']); ?></span>
                    </div>

                    <div class="flex items-center gap-3 text-slate-300 text-sm hover:text-white transition-colors">
                        <div class="bg-slate-800 p-2 rounded-lg">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        </div>
                        <span><?php echo htmlspecialchars($kisisel['telefon']); ?></span>
                    </div>

                    <div class="flex items-center gap-3 text-slate-300 text-sm hover:text-white transition-colors">
                        <div class="bg-slate-800 p-2 rounded-lg">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </div>
                        <span><?php echo htmlspecialchars($kisisel['adres']); ?></span>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-700 pb-2 mb-4">Hakkımda</h3>
                    <p class="text-slate-300 text-sm leading-relaxed">
                        <?php echo nl2br(htmlspecialchars($kisisel['hakkinda'])); ?>
                    </p>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="w-full md:w-2/3 p-8 md:p-12 bg-white">
            
            <!-- Deneyimler -->
            <section class="mb-12">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800">Deneyimler</h2>
                </div>

                <div class="space-y-8 border-l-2 border-indigo-100 pl-8 ml-3 relative">
                    <?php foreach($deneyimler as $exp): ?>
                    <div class="relative">
                        <span class="absolute -left-[39px] top-1 w-5 h-5 rounded-full border-4 border-white bg-indigo-500"></span>
                        <h3 class="text-lg font-bold text-slate-800"><?php echo htmlspecialchars($exp['pozisyon']); ?></h3>
                        <div class="flex justify-between items-center text-sm text-slate-500 mb-2 font-medium">
                            <span><?php echo htmlspecialchars($exp['sirket']); ?></span>
                            <span class="bg-slate-100 px-2 py-0.5 rounded text-xs"><?php echo htmlspecialchars($exp['tarih']); ?></span>
                        </div>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            <?php echo nl2br(htmlspecialchars($exp['aciklama'])); ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Yetenekler -->
            <section>
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800">Nitelikler & Yetenekler</h2>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <?php foreach($yetenekler as $skill): ?>
                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-100 hover:border-indigo-200 transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-slate-800"><?php echo htmlspecialchars($skill['yetenek_adi']); ?></h4>
                            <?php echo yildizGoster($skill['seviye']); ?>
                        </div>
                        <p class="text-sm text-slate-600">
                            <?php echo htmlspecialchars($skill['aciklama']); ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </main>
        
        <!-- Admin Butonu -->
        <a href="admin.php" class="fixed bottom-6 right-6 bg-indigo-600 text-white p-4 rounded-full shadow-xl hover:bg-indigo-700 hover:scale-105 transition-all z-40" title="Yönetim Paneli">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
        </a>
    </div>
</body>
</html>