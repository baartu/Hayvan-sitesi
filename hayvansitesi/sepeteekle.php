<?php
session_start();
include 'baglanti.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['urun_id'])) {
    $urun_id = $_POST['urun_id'];

    // Veritabanından ürün bilgilerini çek
    $sql = "SELECT * FROM market WHERE urun_id = $urun_id";
    $result = $conn->query($sql);
    $urun = $result->fetch_assoc();

    if (!$urun) {
        echo json_encode(['error' => 'Ürün bulunamadı.']);
        exit();
    }

    // Ürün zaten sepette varsa adetini artır, yoksa yeni ekle
    if (isset($_SESSION['cart'][$urun_id])) {
        $_SESSION['cart'][$urun_id]['quantity']++;
    } else {
        $_SESSION['cart'][$urun_id] = [
            'urun_baslik' => $urun['urun_baslik'],
            'urun_foto' => $urun['urun_foto'],
            'urun_fiyat' => $urun['urun_fiyat'],
            'quantity' => 1
        ];
    }

    // Toplam ürün sayısını hesapla
    $toplamUrun = 0;
    foreach ($_SESSION['cart'] as $item) {
        $toplamUrun += $item['quantity'];
    }

    echo json_encode(['toplamUrun' => $toplamUrun]);
} else {
    echo json_encode(['error' => 'Geçersiz istek.']);
}
