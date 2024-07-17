<?php
// Kullanıcı bilgilerini çekiyorum cookie'den
$kullanici_bilgileri = null;
$rol = null;
$foto = null;
$userData = null;

if (isset($_COOKIE["kullanici_bilgileri"])) {
    $kullanici_bilgileri = $_COOKIE["kullanici_bilgileri"];
    $userData = json_decode($kullanici_bilgileri, true);
    $rol = isset($userData['rol']) ? $userData['rol'] : null;
    $foto = isset($userData['foto']) && !empty($userData['foto']) ? $userData['foto'] : "./profil/foto.jpg";
}

?>

<header class="p-3 mb-3 border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <div class="col-1">
                <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-primary text-decoration-none">
                    <img src="./logo/logo.png" style="width: 50px; height: 40px;" alt="">
                </a>
            </div>
            <ul class="text-center nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="index.php" class="nav-link px-2 link-body-emphasis">Anasayfa</a></li>
                <li><a href="market.php" class="nav-link px-2 link-body-emphasis">Market</a></li>
                <li class="dropdown nav-link px-2 link-emphasis">
                    <a class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Hayvanlar
                    </a>
                    <ul class="dropdown-menu text-small">
                        <li><a class="dropdown-item" href="kopek.php">Köpekler</a></li>
                        <li><a class="dropdown-item" href="kedi.php">Kediler</a></li>
                        <li><a class="dropdown-item" href="kus.php">Kuşlar</a></li>
                    </ul>
                </li>
                <li><a href="/add.php" class="nav-link px-2 link-body-emphasis">Sorun Ekle</a></li>
                <?php if (isset($rol) && $rol == 1) : ?>
                    <li><a class="nav-link px-2 link-body-emphasis text-danger" href="/marketekle.php">Market Ekle</a></li>

                    <li><a class="nav-link px-2 link-body-emphasis text-danger" href="hayvanekle.php">Hayvan Ekle</a></li>
                <?php endif; ?>
            </ul>

            <ul class="nav col-12 col-lg-auto mb-2 justify-content-center mb-md-0">
                <li class="nav-item">
                    <a class="nav-link px-2 text-black" href="sepetim.php">
                        <i class="fas fa-shopping-cart"></i> Sepetim
                        <span class="badge badge-pill badge-primary text-secondary" id="sepet-sayi">
                            <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0; ?>
                        </span>
                    </a>

                </li>
            </ul>

            <?php if (!isset($kullanici_bilgileri)) : ?>
                <div class="d-flex gap-2">
                    <a class="btn btn-warning" href="kayit.php">KAYIT OL</a>
                    <a class="btn btn-success" href="giris.php">GİRİŞ YAP</a>
                </div>
            <?php else : ?>
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $foto; ?>" width="32" height="32" style="object-fit: cover;" class="rounded-circle ">
                    </a>
                    <ul class="dropdown-menu text-small">
                        <li><a class="dropdown-item " href="profil.php">Profil <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle mx-2" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"></path>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"></path>
                                </svg>
                            </a>

                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item " href="/siparisgecmisi.php">Siparişlerim
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-check-fill mx-2" viewBox="0 0 16 16">
                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708" />
                                </svg>
                            </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item " href="/yorumgecmisi.php">Yorum Geçmişi <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots mx-2" viewBox="0 0 16 16">
                                    <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                    <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2" />
                                </svg></a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item " onclick="cikis()">Çıkış Yap <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right mx-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                                </svg></a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>

<script>
    function cikis() {
        document.cookie = "kullanici_bilgileri=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        window.location.reload(); // Cookie'yi burada temizliyoruz
        window.location.href = "index.php";
    }
</script>