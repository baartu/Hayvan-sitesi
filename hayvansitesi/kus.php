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

    <div class="video-background">
        <div class="x">
            <video autoplay muted loop id="background-video" style="filter: blur(5px);">
                <source src="./logo/bg6.mp4" type="video/mp4">
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

        $sql = "SELECT * FROM hayvan WHERE hayvan_turu='Kuş'  LIMIT $limit OFFSET $offset"; // Sorguyu oluştur, belirlenen limitle ve ofsetle
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
        $sql_count = "SELECT COUNT(*) AS toplam FROM hayvan WHERE hayvan_turu='Kuş'";
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






<!-- <!DOCTYPE html>
<html lang="en">
<body>
    <div class="container">
        <div class="row m-3 gap-3">
            <div class="card" style="width: 18rem;margin-bottom: 15px;">
                <img src="./hayvanfoto/papagan.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-center">
                        Papağan</h5>
                    <p class="card-text">Bu cinsin kedileri genellikle sakin, dost canlısı ve bağımsızdır. Mavi (gri) rengi en yaygın olanı olmakla birlikte, çeşitli renk ve desenlerde olabilirler. Sağlam ve kaslı bir yapıya sahiptirler, bu da onları dayanıklı ve güçlü kılar.</p>
                    <a href="#" class="btn btn-outline-success">Devamını Görmek İçin Tıklayınız </a>
                </div>
            </div>

            <div class="card" style="width: 18rem;margin-bottom: 15px;">
                <img src="./hayvanfoto/akbaba.jpg" class="card-img-top" alt="...">
                <div class="card-body ">
                    <h5 class="card-title text-center">
                        Akbaba</h5>
                    <p class="card-text">Bu cinsin kedileri genellikle sakin, dost canlısı ve bağımsızdır. Mavi (gri) rengi en yaygın olanı olmakla birlikte, çeşitli renk ve desenlerde olabilirler. Sağlam ve kaslı bir yapıya sahiptirler, bu da onları dayanıklı ve güçlü kılar.Sadece uzub tüylüdür.</p>
                    <a href="golden.php" class="btn btn-outline-success">Devamını Görmek İçin Tıklayınız </a>
                </div>
            </div>

            <div class="card" style="width: 18rem;margin-bottom: 15px;">
                <img src="./hayvanfoto/kartal.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-center">
                        Kartal</h5>
                    <p class="card-text">Yuvarlak yüz hatları, büyük, yuvarlak gözler ve kısa, yoğun tüyleriyle tanınır. Persialara benzer bir görünüme sahiptirler, ancak tüy uzunluğu daha kısadır, bu da bakım gereksinimlerini azaltır. Nazik, sevecen ve sakin bir karaktere sahiptirler, çoğunlukla kucağa alınmayı ve sevgi gösterilmeyi severler.</p>
                    <a href="#" class="btn btn-outline-success">Devamını Görmek İçin Tıklayınız </a>
                </div>
            </div>

            <div class="card" style="width: 18rem;margin-bottom: 15px;">
                <img src="./hayvanfoto/baykus.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-center">
                        Baykuş</h5>
                    <p class="card-text">Büyük boyutları, güçlü yapısı, uzun ve kalın tüyleri ile tanınır. Uzun kuyruğu, büyük, üçgen şeklindeki kulakları ve gözleriyle dikkat çeker. Dost canlısı, zeki ve oyuncu bir karaktere sahiptirler. Sahiplerine sadık bağlar geliştirirler ve genellikle diğer evcil hayvanlarla iyi geçinirler.</p>
                    <a href="#" class="btn btn-outline-success">Devamını Görmek İçin Tıklayınız </a>
                </div>
            </div>

            <div class="card" style="width: 18rem;margin-bottom: 15px;">
                <img src="./hayvanfoto/guvercin.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-center">
                        Güvercin</h5>
                    <p class="card-text">Tayland kökenli bir kedi ırkıdır ve zarif yapısı, ince vücut yapısı, uzun ince kuyruğu ve karakteristik yüz maskesi ile tanınır. Kısa ve parlak tüyleri vardır, genellikle koyu renkli yüz, kulaklar, ayaklar ve kuyruk ile kontrast oluşturan açık bir vücut rengine sahiptirler. Zeki, sosyal ve konuşkan bir karaktere sahiptirler, sahiplerine oldukça bağlıdırlar.</p>
                    <a href="#" class="btn btn-outline-success">Devamını Görmek İçin Tıklayınız </a>
                </div>
            </div>

            <div class="card" style="width: 18rem;margin-bottom: 15px;">
                <img src="./hayvanfoto/leylek.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-center">
                        Leylek</h5>
                    <p class="card-text">Kedinin vücudunun üst kısmında siyah renkte ve alt kısmında beyaz renkte tüylerin bulunduğu bir yapıya sahiptir.edinin siyah ve beyaz renklerdeki tüylerinin özel bir desenle birleştiği bir tür kedi desenidir. Adını, bir smokin takım elbisesini andıran görünümünden alır</p>
                    <a href="#" class="btn btn-outline-success">Devamını Görmek İçin Tıklayınız </a>
                </div>
            </div>

            <div class="card" style="width: 18rem;margin-bottom: 15px;">
                <img src="./hayvanfoto/penguen.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-center">
                        Penguen</h5>
                    <p class="card-text">Bu kedi ırkı, tüysüz olmalarıyla dikkat çeker ve genellikle derileri üzerinde yumuşak, kadifemsi bir doku vardır. Yuvarlak baş yapıları, büyük kulakları ve gözleri vardır. Sphynx'ler genellikle sosyal, oyuncu ve insanlarla etkileşime geçmeyi seven kedilerdir.</p>
                    <a href="#" class="btn btn-outline-success">Devamını Görmek İçin Tıklayınız </a>
                </div>
            </div>

            <div class="card" style="width: 18rem;margin-bottom: 15px;">
                <img src="./hayvanfoto/tavuskusu.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title text-center">
                        Tavus Kuşu</h5>
                    <p class="card-text">Zarif ve koyu siyah tüyleriyle dikkat çeken, güzel ve sevimli bir kedi ırkıdır. Bombay kedileri genellikle mütevazı boyutlarda ve kaslı bir yapıya sahiptirler. Yuvarlak baş yapıları, büyük yeşil veya altın renkli gözleri ve kısa, parlak siyah tüyleri vardır. Genellikle dost canlısı, sevecen ve oyuncu bir karaktere sahiptirler.</p>
                    <a href="#" class="btn btn-outline-success">Devamını Görmek İçin Tıklayınız </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html> -->