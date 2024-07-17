<?php // Veritabanı bağlantısını içeren dosya
include 'baglanti.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['urun-adi'])) {
    // Form verilerini al ve güvenli hale getir
    $urunadi = mysqli_real_escape_string($conn, $_POST['urun-adi']);
    $urunbaslik = mysqli_real_escape_string($conn, $_POST['urun-baslik']);
    $urunaciklama = mysqli_real_escape_string($conn, $_POST['icerik']);
    $hayvan = mysqli_real_escape_string($conn, $_POST['hayvan']);

    $target_dir = "hayvanfoto/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Resmin gerçek olup olmadığını kontrol et
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

    // Dosya zaten var mı kontrol et
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Dosya boyutunu kontrol et
    if ($_FILES["file"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Belirli dosya formatlarına izin ver
    $allowedTypes = ['jpg', 'png', 'jpeg', 'gif', 'webp', 'avif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        echo "Sorry, only JPG, JPEG, PNG, GIF, WEBP & AVIF files are allowed.";
        $uploadOk = 0;
    }

    // $uploadOk 0 olarak ayarlandıysa
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Hazırlıksız SQL sorgusu
    $sql = "INSERT INTO hayvan (hayvan_ad, hayvan_baslik, hayvan_aciklama, hayvan_turu, hayvan_foto) VALUES ('$urunadi', '$urunbaslik', '$urunaciklama', '$hayvan', '$target_file')";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='alert alert-success text-center'>Veriler başarıyla kaydedildi.</p>";
        echo "<meta http-equiv='refresh' content='1;url=kopek.php'>";
    } else {
        echo "<p class='alert alert-danger text-center'>Bu Kayıt Zaten Bulunuyor </p>";
    }

    // Veritabanı bağlantısını kapat
    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<?php
include './partials/head.php';
?>

<body>
    <div class="container py-5">
        <div class="row">
            <div class="col-12 col-sm-8 col-lg-6 container">
                <form action="" id="myForm" method="post" enctype="multipart/form-data" class="row border">
                    <h3 class="text-center alert alert-warning">Hayvan Ekle</h3>
                    <div id="div1">
                        <input class="form-control" type="text" id="ad" name="urun-adi" required autocomplete="off" placeholder="Hayvan Adını Girin *"><br>

                        <input class="form-control" type="text" id="baslik" name="urun-baslik" required autocomplete="off" placeholder="Başlık Girin *"><br>

                        <div id="editor" style="height: 200px;"></div>
                        <input type="text" name="icerik" id="icerik" hidden>

                        <div class="mb-3">
                            <label class="form-label">Hayvanınız Hangisi?</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="köpek" name="hayvan" value="Köpek">
                                <label for="köpek" class="form-check-label">Köpek</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="kedi" name="hayvan" value="Kedi">
                                <label for="kedi" class="form-check-label">Kedi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="kuş" name="hayvan" value="Kuş">
                                <label for="kuş" class="form-check-label">Kuş</label>
                            </div>
                        </div>

                    </div>
                    <div class="mb-3">
                        <label for="">Ürünün Fotoğrafını Ekleyin.</label>
                        <input class="form-control" type="file" id="formFile" name="file">
                    </div>

                    <div class="text-center mb-3">
                        <button type="submit" name="buton" id="button" class="btn btn-secondary">Gönder </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

        document.getElementById('myForm').addEventListener('submit', function() {
            // Editor içeriğini HTML formatında al
            const editorContent = quill.root.innerHTML;
            console.log(editorContent);
            // Gizli input alanına bu içeriği koy
            document.getElementById('icerik').value = editorContent;
        });
    </script>
</body>


</html>