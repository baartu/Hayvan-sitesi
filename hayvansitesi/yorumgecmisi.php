<!DOCTYPE html>
<html lang="en">
<?php
include './partials/head.php';
?>

<body>
    <?php
    include './partials/navbar.php';
    ?>
    <div class="container">
        <div class="row">
            <div class="border p-4 m-2">
                <h4 class="text-center alert alert-info">Market Ürünlerine Yapılan Yorumlar</h4>
                <?php
                include 'baglanti.php';

                // Kullanıcının e-posta adresini al
                $user_email = $userData["eposta"];

                // SQL sorgusu
                $sql = "SELECT yorum.yorum_icerik, market.urun_adi 
                    FROM yorum 
                    JOIN market ON yorum.urun_id = market.urun_id 
                    WHERE yorum.yorum_eposta = '$user_email'";
                $result = $conn->query($sql);

                $sayac = 1;
                // Sonuçları kontrol et ve işle
                if ($result->num_rows > 0) {
                    // Her satırı işle
                    while ($row = $result->fetch_assoc()) {
                        echo "<p style='margin-left:5px;'>" . $sayac . " - " . $row["yorum_icerik"] . " (" . $row["urun_adi"] . ")<br></p>";
                        $sayac++;
                    }
                } else {
                    echo "0 sonuç";
                }

                // Bağlantıyı kapat
                $conn->close();
                ?>
            </div>

            <div class=" border p-4 m-2">
                <h4 class="text-center alert alert-info">Sorunlara Yapılan Yorumlar</h4>
                <?php
                include 'baglanti.php';
                // Kullanıcının e-posta adresini al
                $user_email = $userData["eposta"];

                // SSS'ye yapılan yorumlar için başlık


                // SSS'ye yapılan yorumlar için SQL sorgusu
                $sql_sss = "SELECT yorum.yorum_icerik, sss.user_baslik 
                FROM yorum 
                JOIN sss ON yorum.sss_id = sss.sss_id 
                WHERE yorum.yorum_eposta = '$user_email'";
                $result_sss = $conn->query($sql_sss);

                $sayac_sss = 1;
                // SSS'ye yapılan yorumları kontrol et ve işle
                if ($result_sss->num_rows > 0) {
                    while ($row_sss = $result_sss->fetch_assoc()) {
                        echo "<p style='margin-left:5px;'>" . $sayac_sss . " - " . $row_sss["yorum_icerik"] . " (" . $row_sss["user_baslik"] . ")<br></p>";
                        $sayac_sss++;
                    }
                } else {
                    echo "0 sonuç";
                }

                // Bağlantıyı kapat
                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>

</html>