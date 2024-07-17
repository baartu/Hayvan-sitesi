<?php
include 'baglanti.php';
session_start();

// Kullanıcı bilgilerini çekiyorum cookieden
$kullanici_bilgileri = null;
$rol = null;
$foto = null;
$userData = null;
if (isset($_COOKIE["kullanici_bilgileri"])) {
    $kullanici_bilgileri = $_COOKIE["kullanici_bilgileri"];
    $userData = json_decode($kullanici_bilgileri, true);
    $rol = $userData['rol'];
    $foto = empty($userData['foto']) ? "./hayvanfoto/blankprofil.webp" : $userData['foto'];
}

if (isset($_POST["buton"])) {
    // Formdan gelen veriler
    $isim = $_POST['user-isim'];
    $soyad = $_POST['user-lastname'];
    $eposta = $_POST['user-email'];
    $sifre = $_POST['user-password'];
    $confirm_sifre = $_POST['user-password-confirm'];
    $hayvan = $_POST['hayvan'];

    // Şifreyi hashleme
    $hashed_password = password_hash($sifre, PASSWORD_DEFAULT);

    // Profil fotoğrafını yükleme işlemi
    $target_dir = "profil/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Dosya geçerlilik kontrolleri
    if (isset($_FILES["file"]) && $_FILES["file"]["tmp_name"] != "") {
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check === false) {
            echo "Dosya doğru formatta değil.";
            $uploadOk = 0;
        }

        if (file_exists($target_file)) {

            $uploadOk = 0;
        }

        if ($_FILES["file"]["size"] > 500000) {
            echo "Üzgünüz, dosyanızın boyutu çok büyük.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "gif" && $imageFileType != "gif") {
            echo "Üzgünüz, sadece JPG, JPEG, PNG ve GIF dosyalarına izin veriliyor.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $userData['foto'] = $target_file;
            } else {
                echo "Üzgünüz, dosya yüklenirken bir hata oluştu.";
                $uploadOk = 0;
            }
        }
    } else {
        $target_file = $userData['foto'];
    }

    // Kullanıcı bilgilerini güncelle
    $sql = "UPDATE register SET user_name=?, user_lastname=?, user_eposta=?, user_sifre=?, user_hayvan=?, user_foto=? WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $isim, $soyad, $eposta, $hashed_password, $hayvan, $target_file, $userData['id']);

    if ($stmt->execute()) {
        echo "<p class='alert alert-success'>Veriler başarıyla güncellendi.</p>";

        // Güncellenmiş verileri session ve cookie'de güncelle
        $userData['user_name'] = $isim;
        $userData['user_lastname'] = $soyad;
        $userData['user_eposta'] = $eposta;
        $userData['user_hayvan'] = $hayvan;
        $userData['foto'] = $target_file;
        $userData['rol'] = $rol;

        setcookie("kullanici_bilgileri", json_encode($userData), time() + (86400 * 30), "/");
        $_SESSION['userData'] = $userData;

        // Profil sayfasına yönlendir
        echo "<meta http-equiv='refresh' content='1;url=profil.php'>";
        exit();
    } else {
        echo "Bir hata oluştu: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
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
    <?php
    // Kullanıcı bilgilerini çekiyorum cookieden
    $kullanici_bilgileri = null;
    $rol = null;
    $foto = null;
    $userData = null;
    if (isset($_COOKIE["kullanici_bilgileri"])) {
        $kullanici_bilgileri = $_COOKIE["kullanici_bilgileri"];
        $userData = json_decode($kullanici_bilgileri, true);
        $rol = $userData['rol'];
        $foto = empty($userData['foto']) ? "./hayvanfoto/blankprofil.webp" : $userData['foto'];
    }

    // Verileri seçme sorgusu
    $sql = "SELECT * FROM register WHERE user_id ='" . $userData["id"] . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo ' <div class="container-fluid py-5">';
        while ($row = $result->fetch_assoc()) {
            echo ' <div class="row justify-content-center align-items-center">';
            echo ' <div class="col-12 col-sm-8 col-lg-6 ">';
            echo '<form action="" method="post" class="rounded-4 p-5 border" enctype="multipart/form-data" onsubmit="return validatePasswords()">';
            echo ' <h3 class="text-center alert alert-danger">Profil Güncelleme</h3>';

            echo '<label for="user-isim" class="form-label">İsim</label>';
            echo '<input class="form-control mb-3" type="text" id="isim" name="user-isim" required autocomplete="off" placeholder="' . $row["user_name"] . '">';

            echo '<label for="user-lastname" class="form-label">Soyisim</label>';
            echo '<input class="form-control mb-3" type="text" id="soyad" name="user-lastname" required autocomplete="off" placeholder="' . $row["user_lastname"] . '">';

            echo ' <label for="user-email" class="form-label">E-mail</label>';
            echo '<input class="form-control mb-3" type="email" id="email" name="user-email" required autocomplete="off" value="' . $row["user_eposta"] . '" readonly>';

            echo '<label for="user-password" class="form-label">Şifre</label>';
            echo '<input class="form-control mb-3" type="password" id="password" name="user-password" required autocomplete="off">';

            echo '<label for="user-password-confirm" class="form-label">Şifreyi Tekrar Giriniz</label>';
            echo '<input class="form-control" type="password" id="confirmPassword" name="user-password-confirm" required autocomplete="off">';

            echo '<div id="passwordError" class="text-danger mb-3"></div>';

            echo '<div class="mb-3">';
            echo '<label class="form-label mb-3">Hayvanınız Hangisi ?</label>';
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="radio" id="köpek" name="hayvan" required value="Köpek">';
            echo '<label for="köpek" class="form-check-label">Köpek</label>';
            echo '</div>';
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="radio" id="kedi" name="hayvan" required value="Kedi">';
            echo '<label for="kedi" class="form-check-label">Kedi</label>';
            echo '</div>';
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="radio" id="kuş" name="hayvan" required value="Kuş">';
            echo '<label for="kuş" class="form-check-label">Kuş</label>';
            echo '</div>';
            echo '</div>';

            echo '<div class="mb-3">';
            echo '<label for="formFile" class="form-label">Profil Fotoğrafınızı Yükleyin..</label>';
            echo '<input class="form-control" type="file" id="formFile" name="file">';
            echo '</div>';

            echo '<div class="mb-3 text-center">';
            echo '<button type="submit" name="buton" class="btn btn-danger btn-md">Güncelle</button>';
            echo '</div>';
            echo ' </form>';
            echo ' </div>';
            echo '</div>';
        }
        echo '</div>';
    }
    $conn->close();
    ?>

    <script>
        function validatePasswords() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const errorDiv = document.getElementById('passwordError');

            if (password !== confirmPassword) {
                errorDiv.textContent = "Şifreler eşleşmiyor.";
                return false;
            }

            errorDiv.textContent = "";
            return true;
        }
    </script>
</body>

</html>