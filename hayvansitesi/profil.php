<?php
include 'baglanti.php';
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

    <div class="icerik d-flex justify-content-space-between align-items-space-between m-2">
        <?php
        // Verileri seçme sorgusu
        $sql = "SELECT * FROM register WHERE user_id ='" . $userData["id"] . "'";

        // Kullanıcı bilgilerini çekiyorum cookieden
        $kullanici_bilgileri = null;
        $rol = null;
        $foto = null;
        $userData = null;
        if (isset($_COOKIE["kullanici_bilgileri"])) {
            $kullanici_bilgileri = $_COOKIE["kullanici_bilgileri"];
            $userData = json_decode($kullanici_bilgileri, true);
            $rol = $userData['rol'];
            $foto = empty($userData['foto']) ? "./profil/foto.jpg" : $userData['foto'];
        } else {
            echo 'böyle bir cookie yok';
        }
        $result = $conn->query($sql);

        // Verileri ekrana yazdırma
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo ' <div class="card border m-3" style="width: 20rem;">';
                echo '<img src="' . $foto . '" class="card-img-top" alt="...">';
                echo ' <div class="card-body">';
                echo '<h4 class="text-center">Profil Bilgileri</h4>';
                echo ' <p class="card-text"> Hayvanınız - ' . $row["user_hayvan"] . '</p>';
                echo ' <p class="card-text">' . $row["user_kayit"] . ' ' . " tarihinde kaydolmuşsunuz" . '</p>';
                echo ' <p class="card-text">' . "E-posta Adresiniz -" . '' . $row["user_eposta"] . '</p>';
                echo '<div class="text-center">';
                echo '<a href="guncelle.php" class="btn btn-secondary text-center">Profil Bilgilerini Güncelle</a>';
                echo ' </div>';
                echo ' </div>';
                echo '</div>';
            }
        }
        $conn->close();
        ?>


        <!-- <div class="onceki border p-4 m-2">
            <h4 class="text-center">Sipariş Geçmişi</h4>
        </div> -->
    </div>


</body>

</html>