<!DOCTYPE html>
<html lang="en">

<?php
include './partials/head.php';
?>
<style>
    body,
    html {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;

    }

    .video-background {
        position: relative;
        width: 100%;
        height: 100vh;
        overflow: hidden;

    }

    #background-video {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transform: translate(-50%, -50%);
        z-index: -1;
    }
</style>

<body>
    <?php
    include './partials/navbar.php';
    ?>
    <div class="video-background" style="filter: blur(5px);">
        <div class="x">
            <video autoplay muted loop id="background-video">
                <source src="./logo/bg4.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>

    </div>
    <div class="container">
        <?php
        include 'baglanti.php';


        // Sayfalama işlemi için gerekli değişkenler
        $sayfa = isset($_GET['sayfa']) ? $_GET['sayfa'] : 1; // Sayfa numarasını al, eğer belirtilmemişse varsayılan olarak 1 olsun
        $limit = 8; // Her sayfada gösterilecek öğe sayısı
        $offset = ($sayfa - 1) * $limit; // SQL sorgusunda kullanmak üzere ofset hesapla

        $sql = "SELECT * FROM hayvan WHERE hayvan_turu='Köpek'  LIMIT $limit OFFSET $offset"; // Sorguyu oluştur, belirlenen limitle ve ofsetle
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<div class='row gap-3 p-4' id='results'>";
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card" style="width:17rem;">';
                echo '<img class="card-img-top" src="' . $row["hayvan_foto"] . '"</img>';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row["hayvan_ad"] . ' </h5>';
                echo '<p class="card-text"> ' . $row["hayvan_baslik"] . '</p>';
                echo '<div class="d-flex justify-content-center align-items-center">';
                echo '<a href="/hayvandetay.php?id=' . $row["hayvan_id"] . '"class="btn btn-secondary" >Detaylara Bak</a>'; //önemli id detaylara gönderme
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo "</div>";
        } else {
            echo "<p class='alert alert-danger text-center mt-5'>Eklenen veri yok </p>";
        }

        // Sayfa sayısını hesapla
        $sql_count = "SELECT COUNT(*) AS toplam FROM hayvan WHERE hayvan_turu='Köpek'";
        $result_count = $conn->query($sql_count);
        $row_count = $result_count->fetch_assoc();
        $toplam_kayit = $row_count['toplam'];
        $toplam_sayfa = ceil($toplam_kayit / $limit);
        echo '<div class="d-flex justify-content-end align-items-end m-5">';
        // Sayfalama linklerini oluştur
        echo '<nav aria-label="Page navigation example"><ul class="pagination">';
        if ($sayfa > 1) {
            echo '<li class="page-item"><a class="page-link" href="?sayfa=' . ($sayfa - 1) . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
        }
        for ($i = 1; $i <= $toplam_sayfa; $i++) {
            echo '<li class="page-item ' . ($sayfa == $i ? "active" : "") . '"><a class="page-link" href="?sayfa=' . $i . '">' . $i . '</a></li>';
        }
        if ($sayfa < $toplam_sayfa) {
            echo '<li class="page-item"><a class="page-link" href="?sayfa=' . ($sayfa + 1) . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
        }
        echo '</ul></nav>';
        echo '</div>';


        $conn->close();
        ?>
    </div>
    </div>
</body>

</html>