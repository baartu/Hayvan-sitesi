<?php
if (isset($_POST["buton"])) {
    include 'baglanti.php';


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
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["file"]["size"] > 500000) {
        echo "Dosya Çok Büyük..";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sadece JPG, JPEG, PNG , GIF türleri eklenebilir.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Üzgünüz , dosyayı yükleyemiyoruz..";
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
            echo "<p class='alert alert-success text-center'>Veriler başarıyla kaydedildi.</p>";
            echo "<meta http-equiv='refresh' content='3;url=index.php'>";
        } else {
            echo "<p class='alert alert-danger text-center'>Bu TC kimlik numarasına sahip kayıt zaten bulunuyor. </p>";
        }

        // Veritabanı bağlantısını kapat
        $conn->close();
    } else {
        echo "<p class='alert alert-danger text-center'>Kayıtlı Kullanıcı Bulunamadı Kayıt Olma Ekranına Yönlendiriliyosunuz !!</p>";

        echo "<meta http-equiv='refresh' content='5;url=kayit.php'>";
    }
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
    <div class="container py-5">
        <div class="row">
            <div class="col-12 col-sm-8 col-lg-6 container">
                <form action="" method="post" enctype="multipart/form-data" class=" rounded-4  p-5 border">
                    <h3 class=" alert alert-warning text-center">Sorun Ekle</h3>

                    <input class="form-control" type="text" id="email" name="user-email" required autocomplete="off" placeholder="E-mailinizi Girin"><br>

                    <input class="form-control" type="text" id="soyad" name="baslik" required autocomplete="off" placeholder="Başlık Girin *"><br>

                    <textarea name="icerik" id="" cols="30" rows="10" placeholder="İçeriği Buraya Giriniz *" class="form-control"></textarea>

                    <div class="mb-3">
                        <label class="form-label ">Hayvanınız Hangisi ?</label>

                        <div class="form-check">
                            <input class="form-check-input " type="radio" id="köpek" name="hayvan[]" required value="Köpek">
                            <label for="köpek" class="form-check-label">Köpek</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input " type="radio" id="köpek" name="hayvan[]" required value="kedi">
                            <label for="köpek" class="form-check-label">Kedi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input " type="radio" id="köpek" name="hayvan[]" required value="Kuş">
                            <label for="köpek" class="form-check-label">Kuş</label>
                        </div>

                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="file" id="formFile" name="file">
                    </div>

                    <div class="mb-3 text-center">
                        <button type="submit" name="buton" class="btn btn-outline-warning btn-md ">Gönder </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


</body>

</html>