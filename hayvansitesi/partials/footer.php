<?php
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

            echo "<p style='background-color:green;color:white;text-align:center;width:100%;height:20px;'>Veriler başarıyla kaydedildi.</p>";
            echo "<meta http-equiv='refresh' content='3;url=index.php'>";
        } else {
            echo "<p style='color:white;background-color:red;text-align:center'>Bu TC kimlik numarasına sahip kayıt zaten bulunuyor. </p>";
        }

        // Veritabanı bağlantısını kapat
        $conn->close();
    } else {
        echo "<p style='background-color:red;color:white;text-align:center;width:100%;height:30px;'>Kayıtlı Kullanıcı Bulunamadı Kayıt Olma Ekranına Yönlendiriliyosunuz !!</p>";

        echo "<meta http-equiv='refresh' content='5;url=kayit.php'>";
    }
}
?>

<div class="container col-12 col-sm-8 col-lg-6">
    <form action="" method="post" enctype="multipart/form-data" class="rounded-4 bg-white p-5 border">
        <h3 class="alert alert-warning text-center">Sorun Ekle</h3>

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
            <button type="submit" name="buton" class="btn btn-outline-warning btn-md text-center">Gönder </button>
        </div>

    </form>

</div>
<div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <p class="col-md-4 mb-0 text-body-secondary">© 2024 Bartu Başaran</p>


        <a href="index.php" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <img src="./logo/logo.png" style="width: 50px;height:40;" alt="">
        </a>

        <ul class="nav col-md-4 justify-content-end">
            <li class="nav-item"><a href="index.php" class="nav-link px-2 text-body-secondary">Anasayfa</a></li>
            <li class="nav-item"><a href="market.php" class="nav-link px-2 text-body-secondary">Market</a></li>
            <li class="nav-item"><a href="hayvan.php" class="nav-link px-2 text-body-secondary">Hayvanlar</a></li>
            <li class="nav-item"><a href="add.php" class="nav-link px-2 text-body-secondary">Sorun Ekle</a></li>
            <li class="nav-item"><a href="profil.php" class="nav-link px-2 text-body-secondary">Profil</a></li>
        </ul>


        <ul class="list-unstyled d-flex">
            <li class="ms-3">
                <a href="https://twitter.com/baaarttuu" class="list-style-none link-body-emphasis">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-twitter" viewBox="0 0 16 16">
                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334q.002-.211-.006-.422A6.7 6.7 0 0 0 16 3.542a6.7 6.7 0 0 1-1.889.518 3.3 3.3 0 0 0 1.447-1.817 6.5 6.5 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.32 9.32 0 0 1-6.767-3.429 3.29 3.29 0 0 0 1.018 4.382A3.3 3.3 0 0 1 .64 6.575v.045a3.29 3.29 0 0 0 2.632 3.218 3.2 3.2 0 0 1-.865.115 3 3 0 0 1-.614-.057 3.28 3.28 0 0 0 3.067 2.277A6.6 6.6 0 0 1 .78 13.58a6 6 0 0 1-.78-.045A9.34 9.34 0 0 0 5.026 15"></path>
                    </svg>
                </a>
            </li>
            <li class="ms-3">
                <a href="https://www.instagram.com/bartu.basaraan/" class="list-style-none link-body-emphasis">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-instagram" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                    </svg>
                </a>
            </li>
            <li class="ms-3">
                <a href="https://github.com/baartu" class="list-style-none link-body-emphasis">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-github" viewBox="0 0 16 16">
                        <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8" />
                    </svg>
                </a>
            </li>
            <li class="ms-3"><a href="https://www.linkedin.com/in/bartu-basaarann/" class="list-style-none link-body-emphasis">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-linkedin" viewBox="0 0 16 16">
                        <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z" />
                    </svg>
                </a></li>
        </ul>

    </footer>
</div>