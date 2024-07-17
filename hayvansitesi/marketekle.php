<?php
include 'baglanti.php';
?>

<?php
if (isset($_POST["buton"])) {

    $urunadi = $_POST['urun-adi'];
    $urunbaslik = $_POST['urun-baslik'];
    $urunaciklama = $_POST['icerik'];
    $urunfiyat = $_POST['urun-fiyat'];
    $hayvan = $_POST['hayvan'];
    // Cinsiyet ve Hobileri birleştir
    $hayvan_str = implode(", ", $hayvan);

    $target_dir = "market/";
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

    // SQL sorgusu
    $sql = "INSERT INTO market (urun_adi,urun_baslik,urun_aciklamasi,urun_fiyat,urun_hayvan,urun_foto) VALUES ('$urunadi','$urunbaslik', '$urunaciklama','$urunfiyat', '$hayvan_str','$target_file')";
    // Sorguyu çalıştır

    if ($conn->query($sql) == TRUE) {
        echo "<p class='alert alert-success text-center'height:20px;'>Veriler başarıyla kaydedildi.</p>";
        $userData = array(
            'id' => $row["urun_id"]
        );
        $jsonUserData = json_encode($userData); // Giriş başarılı ise, kullanıcıyı ana sayfaya yönlendir
        setcookie("kullaniciadi", $jsonUserData);

        echo "<meta http-equiv='refresh' content='3;url=market.php'>";
    } else {
        echo "<p class='alert alert-danger text-center'>Bu TC kimlik numarasına sahip kayıt zaten bulunuyor. </p>";
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
                <form action="" method="post" enctype="multipart/form-data" class="row border">
                    <h3 class="text-center alert alert-warning">Ürün Ekle</h3>
                    <div id="div1">
                        <input class="form-control" type="text" id="ad" name="urun-adi" required autocomplete="off" placeholder="Ürün Adını Girin *"><br>

                        <input class="form-control" type="text" id="baslik" name="urun-baslik" required autocomplete="off" placeholder="Başlık Girin *"><br>

                        <textarea class="form-control" name="icerik" id="" cols="30" rows="10" placeholder="İçeriği Buraya Giriniz *"></textarea>
                        <input class="form-control mt-3" type="number" id="baslik" name="urun-fiyat" required autocomplete="off" placeholder="Fiyat Girin *"><br>

                        <div class="mb-3">
                            <label class="form-label ">Hayvanınız Hangisi ?</label>

                            <div class="form-check">
                                <input class="form-check-input " type="checkbox" id="köpek" name="hayvan[]" value="Köpek">
                                <label for="köpek" class="form-check-label">Köpek</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input " type="checkbox" id="köpek" name="hayvan[]" value="kedi">
                                <label for="köpek" class="form-check-label">Kedi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input " type="checkbox" id="köpek" name="hayvan[]" value="Kuş">
                                <label for="köpek" class="form-check-label">Kuş</label>
                            </div>

                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="">Ürünün Fotoğrafını Ekleyin.</label>
                        <input class="form-control" type="file" id="formFile" name="file">
                    </div>

                    <div class="text-center mb-3">
                        <button type="submit" name="buton" class="btn btn-secondary">Gönder </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>


</html>