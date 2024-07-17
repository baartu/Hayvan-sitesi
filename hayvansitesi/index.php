<?php
include 'baglanti.php';
?>

<?php
$sql = "SELECT * FROM sss"; //sorunları card çekiyo
$result = $conn->query($sql); //sorunları card çekiyo

if (isset($_POST["buton"])) {

    $email = $_POST['user-email'];
    $baslik = $_POST['baslik'];
    $icerik = $_POST['icerik'];
    $hayvan = $_POST['hayvan'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["file"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Cinsiyet ve Hobileri birleştir
    $hayvan_str = implode(", ", $hayvan);


    $check_tc_sql = "SELECT user_eposta FROM register WHERE user_eposta = '$email'";
    $result = $conn->query($check_tc_sql);

    if ($result->num_rows > 0) {
        $sql = "INSERT INTO sss (user_eposta,user_baslik, user_aciklama, user_hayvan,user_dosya) VALUES ('$email','$baslik', '$icerik','$hayvan_str','$target_file')";

        // Sorguyu çalıştır
        if ($conn->query($sql) == TRUE) {
            echo "<p style='background-color:green;color:white;text-align:center;width:100%;height:20px;'>Veriler başarıyla kaydedildi.</p>";
            echo "<meta http-equiv='refresh' content='3;url=main2.php'>";
        } else {
            echo "<p style='color:white;background-color:red;text-align:center'>Bu TC kimlik numarasına sahip kayıt zaten bulunuyor. </p>";
        }

        // Veritabanı bağlantısını kapat
        $conn->close();
    } else {
        echo "<p style='background-color:red;color:white;text-align:center;width:100%;height:20px;'>Kayıtlı Kullanıcı Bulunamadı..</p>";
        echo "<meta http-equiv='refresh' content='2;url=add.php'>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
include './partials/head.php';
?>

<style>
    /* carousel yazı rengini ayarla arka planı değiştir*/
    .a {
        backdrop-filter: blur(10px);
        box-shadow: 0px 0px 30px rgba(227, 228, 237, 0.37);
        border: 2px solid rgba(255, 255, 255, 0.18);
        border-radius: 10px;
    }
</style>

<body>
    <?php
    include './partials/navbar.php';
    ?>

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./mainfoto/c1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block a">
                    <div class="caption-content text-black text-start p-4">
                        <h5 class="text-center">Kedilerin Görme Yetisi</h5>
                        <p>Kedilerin Renk Körlüğü: Kedilerin dünyayı algılayışları biraz farklıdır. Renk körü oldukları düşünülür, ancak gerçekte renkleri kısmen algılayabilirler. Özellikle koyu renkler ve pastel tonları arasındaki farkları görebilirler.
                        </p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="./mainfoto/c3.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block a p-4">
                    <div class="caption-content text-black text-start">
                        <h5 class="text-center">Köpeklerin Koklama Yetisi</h5>
                        <p>Köpeklerin Koklama Yeteneği: Köpeklerin burnu, insanlarınkinden çok daha gelişmiştir. Bir köpek, insanlardan yaklaşık 10.000 ila 100.000 kat daha iyi koku alabilir. Bu, onları arama ve kurtarma operasyonlarında, uyuşturucu ve patlayıcı tespitinde ve hatta hastalıkları teşhis etmede kullanışlı hale getirir.
                        </p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="./mainfoto/c2.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block a p-4">
                    <div class="caption-content text-black text-start">
                        <h5 class="text-center">Kedi Yaşı</h5>
                        <p>Kedilerin Yaşlanma Süreci: İnsanlar için her bir yılın yedi kedi yılına eşit olduğu yaygın bir yanlış inanıştır. Gerçekte, kedinin yaşlanma süreci biraz daha karmaşıktır. İlk birkaç yıl hızlı yaşlanırken, yaşlandıkça yaşlanma süreci yavaşlar. Ortalama olarak, bir kedinin 1 yaşındaki bir insanın 15 yaşındaki bir kediden daha olgun olduğu kabul edilir.</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="./mainfoto/c4.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block a p-4">
                    <div class="caption-content text-black text-start">
                        <h5 class="text-center">Köpeklerin Renk Algısı</h5>
                        <p>Köpeklerin Renk Algısı: Eskiden köpeklerin renk körü olduklarına inanılırdı, ancak artık bunun doğru olmadığı bilinmektedir. Köpekler bazı renkleri algılayabilir, ancak insanlardan farklı bir renk algıları vardır. Örneğin, kırmızı ve yeşil tonları arasındaki farkı zor algılarlar.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    </div>

    <div class="row mb-2 py-2 d-flex justify-content-center align-items-center border">
        <h4 class="text-secondary text-center py-2">FİLTRELE VE ARAMA</h4>
        <form id="filterForm" class="col-12 col-lg-6 mb-3 mb-lg-0 me-lg-3" method="POST" action="">
            <div class="input-group d-flex justify-content-center align-items-center">
                <input type="text" class="form-control w-75" name="search" placeholder="Arama yap...">
                <button id="filterButton" type="submit" class="btn btn-primary w-25">Filtrele</button>
                <div class="form-check form-check-inline mt-3">
                    <input class="form-check-input" type="checkbox" id="kediCheckbox" name="filter[]" value="kedi">
                    <label class="form-check-label" for="kediCheckbox">Kedi</label>
                </div>
                <div class="form-check form-check-inline mt-3 ">
                    <input class="form-check-input" type="checkbox" id="kopekCheckbox" name="filter[]" value="köpek">
                    <label class="form-check-label" for="kopekCheckbox">Köpek</label>
                </div>
                <div class="form-check form-check-inline mt-3">
                    <input class="form-check-input" type="checkbox" id="kusCheckbox" name="filter[]" value="Kuş">
                    <label class="form-check-label" for="kusCheckbox">Kuş</label>
                </div>

            </div>
        </form>
    </div>

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
            echo '<a href="maindetay.php?id=' . $row["sss_id"] . '"class="btn btn-secondary" >Detaylara Bak</a>'; //önemli id detaylara gönderme
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

    <?php
    include './partials/footer.php'; //footer
    ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("filterForm");
            const filterButton = document.getElementById("filterButton");
            const checkboxes = form.querySelectorAll("input[type='checkbox']");

            filterButton.addEventListener("click", function(event) {
                event.preventDefault();
                const formData = new FormData(form);

                fetch("filter.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById("results").innerHTML = data;
                    })
                    .catch(error => console.error('Error:', error));
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", function() {
                    form.dispatchEvent(new Event("submit"));
                });
            });

            form.addEventListener("submit", function(event) {
                event.preventDefault();
                const formData = new FormData(form);

                fetch("filter.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById("results").innerHTML = data;
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        $(document).on('click', '.sepete-ekle', function() {
            var urunId = $(this).data('id');
            var adet = $(this).closest('.card').find('.input-number').val(); // Adet değerini al

            // Adet sayısı kadar ürünü sepete ekle
            for (var i = 0; i < adet; i++) {
                $.ajax({
                    url: 'sepeteekle.php',
                    type: 'POST',
                    async: false, // Senkronize olarak yapılmasını sağlar
                    data: {
                        urun_id: urunId
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.error) {
                            alert(data.error);
                        } else {
                            // Sepetteki ürün sayısını güncelle
                            var toplamUrun = parseInt($('#sepet-sayi').text()) || 0; // Eğer sepetteki ürün sayısı undefined ise sıfır olarak al
                            toplamUrun++; // Her döngüde bir arttır
                            $('#sepet-sayi').text(toplamUrun);
                        }
                    }
                });
            }
        });
    </script>

</body>

</html>