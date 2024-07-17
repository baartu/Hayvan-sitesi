<?php
include 'baglanti.php';
error_reporting(0);
ini_set('display_errors', 0);
?>

<?php
if (isset($_POST["buton"])) {
    $email = $_POST['user-email'];
    $icerik = $_POST['icerik'];
    $urun_id = $_GET["id"];

    $check_tc_sql = "SELECT user_eposta FROM register WHERE user_eposta = ?";
    $stmt = $conn->prepare($check_tc_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "INSERT INTO yorum (yorum_eposta, yorum_icerik, urun_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $email, $icerik, $urun_id);

        if ($stmt->execute() === TRUE) {
            echo '<div class="alert alert-success text-center" role="alert">Yorum Başarı İle Eklendi.</div>';
            echo "<meta http-equiv='refresh' content='1;url=marketdetay.php?id=$urun_id'>";
        } else {
            echo '<div class="alert alert-danger text-center" role="alert">Yorum ekleme başarısız: ' . $conn->error . '</div>';
        }
    } else {
        echo '<div class="alert alert-danger text-center" role="alert">Kayıtlı Kullanıcı Bulunamadı! Kayıt Ekranına Yönlendiriliyorsunuz.</div>';
        echo "<meta http-equiv='refresh' content='5;url=kayit.php'>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
include './partials/head.php';
?>

<body>
    <?php
    include './partials/navbar.php';
    ?>

    <?php
    include 'baglanti.php';

    if (isset($_GET["id"])) {
        $urunid = $_GET["id"];
        $sql = "SELECT * FROM market WHERE urun_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $urunid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class=" w-50">';
                echo '<div class="row">';
                echo '<div class="col-md-6">';
                echo '<img src="' . $row["urun_foto"] . '" class="img-fluid" alt="Ürün Resmi">';
                echo '</div>';
                echo '<div class="col-md-6">';
                echo '<h2>' . $row["urun_baslik"] . '</h2>';
                echo '<p>' . $row["urun_aciklamasi"] . '</p>';
                echo '<p>Fiyat: ' . $row["urun_fiyat"] . ' TL</p>';
                echo '<p>Hayvan Türü: ' . $row["urun_hayvan"] . '</p>';
                // Diğer ürün detaylarını da buraya ekleyebilirsiniz
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>Ürün bulunamadı.</p>';
        }
    } else {
        echo '<p>Ürün ID belirtilmedi.</p>';
    }

    $stmt->close();
    $conn->close();
    ?>

    <div class="container-fluid py-5 border">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-sm-8 col-lg-6">
                <h3 class="text-center alert alert-warning">Yorumlar</h3>
                <?php
                include 'baglanti.php';

                if (isset($_GET["id"])) {
                    $urunid = intval($_GET["id"]);

                    $yorum_sql = "SELECT * FROM yorum WHERE urun_id = ?";
                    $stmt = $conn->prepare($yorum_sql);
                    $stmt->bind_param("i", $urunid);
                    $stmt->execute();
                    $yorum_result = $stmt->get_result();

                    if ($yorum_result->num_rows > 0) {
                        while ($yorum = $yorum_result->fetch_assoc()) {
                            echo '<div class="card mt-3">';
                            echo '<div class="card-body">';
                            echo '<strong class="card-title">' . htmlspecialchars($yorum["yorum_icerik"]) . '</strong><br>';
                            echo '<small class="card-text text-secondary">' . htmlspecialchars($yorum["yorum_eposta"]) . '</small><br>';
                            echo '<small class="card-text text-secondary">' . htmlspecialchars($yorum["yorum_saat"]) . '</small>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p class="text-center">Henüz yorum yapılmamış.</p>';
                    }

                    $stmt->close();
                } else {
                    echo '<p>Ürün ID belirtilmedi.</p>';
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5 border m-2">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-sm-8 col-lg-6">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="anadiv">
                        <h3 class="text-center mt-3 alert alert-warning">Yorum Yap</h3>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" name="user-email" placeholder="name@example.com">
                            <label for="floatingInput">Emailinizi Girin</label>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="icerik" style="height: 100px"></textarea>
                            <label for="floatingTextarea2">İçeriği Buraya Giriniz </label>
                        </div>

                        <div class="d-flex justify-content-center align-items-center" style="margin-top: 15px;">
                            <button type="submit" name="buton" class="btn btn-warning">Yorum Ekle</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
```