<?php
include 'baglanti.php';
?>

<?php
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

    $check_tc_sql = "SELECT user_eposta FROM register WHERE user_eposta = '$eposta'";
    $result = $conn->query($check_tc_sql);

    if ($sifre != $confirm_sifre) {
        echo "<p class='alert alert-danger text-center'> Şifreler Uyuşmuyor</p>";
    } else {
        if ($result->num_rows > 0) {
            echo "<p class='alert alert-danger text-center'>Bu e-postaya sahip kayıt zaten bulunuyor. </p>";
        } else {
            $target_dir = "profil/";
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
                && $imageFileType != "gif" && $imageFileType != "avif" && $imageFileType != "webp"
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

            // SQL sorgusuS
            $sql = "INSERT INTO register (user_name,user_lastname, user_eposta, user_sifre, user_hayvan,user_foto) VALUES ('$isim','$soyad', '$eposta', '$hashed_password', '$hayvan','$target_file')";

            // Sorguyu çalıştır
            if ($conn->query($sql) == TRUE) {
                echo "<p class='alert alert-success text-center'>Veriler başarıyla kaydedildi.</p>";
                echo "<meta http-equiv='refresh' content='1;url=giris.php'>";
            }
            // Veritabanı bağlantısını kapat
            $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
include './partials/head.php';
?>
<style>
    body {
        background-image: url(./logo/background.png);
        background-size: cover;
    }
</style>

<body>
    <div class="container-fluid py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-sm-8 col-lg-6 ">
                <form action="" method="post" class=" rounded-4 p-5 border " enctype="multipart/form-data">
                    <h3 class="text-center alert alert-success">KAYIT OL</h3>

                    <label for="student-name" class="form-label">İsim</label><br>
                    <input class="form-control" type="text" id="isim" name="user-isim" required autocomplete="off" placeholder="İsminiz *"><br>

                    <label for="student-name" class="form-label">Soyisim</label><br>
                    <input class="form-control" type="text" id="soyad" name="user-lastname" required autocomplete="off" placeholder="Soyadınız *"><br>

                    <label for="student-surname" class="form-label" class="form-label">E-mail</label><br>
                    <input class="form-control" type="text" id="email" name="user-email" required autocomplete="off" placeholder="xxx@gmail.com"><br>

                    <label for="password" class="form-label">Şifre</label><br>
                    <input class="form-control" type="password" id="password" name="user-password" required autocomplete="off"><br>

                    <label for="confirmPassword" class="form-label">Şifreyi Tekrar Giriniz</label><br>
                    <input class="form-control" type="password" id="confirmPassword" name="user-password-confirm" required autocomplete="off"><br>

                    <div class="mb-3">
                        <label class="form-label ">Hayvanınız Hangisi ?</label>

                        <div class="form-check">
                            <input class="form-check-input " type="radio" id="köpek" name="hayvan" required value="Köpek">
                            <label for="köpek" class="form-check-label">Köpek</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input " type="radio" id="köpek" name="hayvan" required value="kedi">
                            <label for="köpek" class="form-check-label">Kedi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input " type="radio" id="köpek" name="hayvan" required value="Kuş">
                            <label for="köpek" class="form-check-label">Kuş</label>
                        </div>

                    </div>


                    <div class="mb-3 alt">
                        <label for="user_foto" class="form-label">Profil Fotoğrafınızı Yükleyin..</label><br>
                        <input class="form-control" type="file" id="formFile" name="file" required>
                    </div>

                    <div class="mb-3 text-center ">
                        <button type="submit" name="buton" class="btn btn-success btn-md ">KAYIT OL </button>
                    </div>
                </form>
                <div class="text-center mt-2">
                    <label class="alert alert-secondary">Hesabınız Var mı ? <a href="giris.php">Giriş YAP</a></label>
                </div>
            </div>
        </div>
    </div>
</body>
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

</html>