<?php
session_start();
include 'baglanti.php';

// Sepetten ürün çıkarma işlemi
if (isset($_GET['remove'])) {
    $urun_id = $_GET['remove'];
    unset($_SESSION['cart'][$urun_id]);
    header("Location: sepetim.php");
    exit();
}

// Adet artırma işlemi
if (isset($_GET['increase'])) {
    $urun_id = $_GET['increase'];
    if (isset($_SESSION['cart'][$urun_id])) {
        $_SESSION['cart'][$urun_id]['quantity']++;
    }
    header("Location: sepetim.php");
    exit();
}

// Adet azaltma işlemi
if (isset($_GET['decrease'])) {
    $urun_id = $_GET['decrease'];
    if (isset($_SESSION['cart'][$urun_id])) {
        if ($_SESSION['cart'][$urun_id]['quantity'] > 1) {
            $_SESSION['cart'][$urun_id]['quantity']--;
        } else {
            unset($_SESSION['cart'][$urun_id]);
        }
    }
    header("Location: sepetim.php");
    exit();
}

// Sepeti boşaltma işlemi
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
    header("Location: sepetim.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">

<?php
include './partials/head.php';
?>
<style>
    .cart-item {
        width: 18rem;
        margin: 10px;
    }

    .cart-item img {
        height: 150px;
        object-fit: cover;
    }
</style>

<body>
    <?php
    include './partials/navbar.php';
    ?>
    <div class="container mt-2">
        <h1 class="text-center alert alert-danger w-100">Sepetiniz</h1>
        <?php if (empty($_SESSION['cart'])) : ?>
            <p class="text-danger text-center">Sepetiniz boş.</p>
        <?php else : ?>
            <div class="row">
                <?php
                $toplamFiyat = 0; // Toplam fiyatı saklamak için değişkeni başlatıyoruz
                foreach ($_SESSION['cart'] as $urun_id => $item) :
                    $toplamFiyat += $item['urun_fiyat'] * $item['quantity']; // Her ürünün fiyatını miktarıyla çarparak toplam fiyata ekliyoruz
                ?>
                    <div class="card cart-item">
                        <img src="<?php echo $item['urun_foto']; ?>" class="card-img-top object-fit-cover" alt="Ürün Fotoğrafı">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $item['urun_baslik']; ?></h5>
                            <p class="card-text"><?php echo $item['urun_fiyat']; ?> TL</p>
                            <p class="card-text">
                                Adet: <?php echo $item['quantity']; ?>
                                <a href="sepetim.php?increase=<?php echo $urun_id; ?>" class="btn btn-sm btn-success ml-2">+</a>
                                <a href="sepetim.php?decrease=<?php echo $urun_id; ?>" class="btn btn-sm btn-warning ml-2">-</a>
                            </p>

                            <div class="text-center">
                                <a href="sepetim.php?remove=<?php echo $urun_id; ?>" class="btn btn-danger mr-5">Kaldır</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Toplam fiyatı gösterme -->
            <div class="text-center mt-3">
                <h4>Toplam Fiyat: <?php echo $toplamFiyat; ?> TL</h4>
            </div>
            <div class="text-center mt-3">
                <a href="odemeyap.php" class="btn btn-success">Ödeme Yap</a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>