<!DOCTYPE html>
<html lang="en">
<?php
include './partials/head.php';
?>

<body>
    <?php
    include './partials/navbar.php';
    ?>

    <div class="border p-4 m-2">
        <h4 class="text-center alert alert-info">Geçmiş Siparişlerim</h4>
        <?php
        include 'baglanti.php';

        // Sayfalama işlemi için gerekli değişkenler
        $sayfa = isset($_GET['sayfa']) ? $_GET['sayfa'] : 1; // Sayfa numarasını al, eğer belirtilmemişse varsayılan olarak 1 olsun
        $limit = 5; // Her sayfada gösterilecek öğe sayısı
        $offset = ($sayfa - 1) * $limit; // SQL sorgusunda kullanmak üzere ofset hesapla

        $sql = "SELECT * FROM sss LIMIT $limit OFFSET $offset"; // Sorguyu oluştur, belirlenen limitle ve ofsetle
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<div class='row gap-3 p-4' id='results'>";
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card" style="width:17rem;">';
                echo '<img class="card-img-top" src="' . $row["user_dosya"] . '"</img>';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row["user_baslik"] . ' </h5>';
                echo '<p class="card-text"> ' . $row["user_aciklama"] . '</p>';
                echo '<p class="card-text"> ' . $row["user_eposta"] . '</p>';
                echo '<p class="card-text"> ' . $row["user_tarih"] . '</p>';

                echo '<div class="d-flex justify-content-center align-items-center">';
                echo '<a href="/hayvansitesi/maindetay.php?id=' . $row["sss_id"] . '"class="btn btn-secondary" >Detaylara Bak</a>'; //önemli id detaylara gönderme
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo "</div>";
        } else {
            echo "<p class='alert alert-danger text-center'>Eklenen veri yok </p>";
        }

        // Sayfa sayısını hesapla
        $sql_count = "SELECT COUNT(*) AS toplam FROM sss";
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
</body>

</html>