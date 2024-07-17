<?php
include 'baglanti.php';
?>

<?php

// Form gönderildi mi kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buton'])) {
    // Formdan gelen verileri al
    $email = $_POST['user-email'];
    $sifre = $_POST['user-password'];

    // Veritabanında kullanıcıyı sorgula
    $sql = "SELECT * FROM register WHERE  user_eposta = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Kullanıcı bulundu, şifreyi kontrol et
        $row = $result->fetch_assoc();
        if (password_verify($sifre, $row['user_sifre'])) {

            $userData = array(
                'id' => $row["user_id"],
                'eposta' => $row["user_eposta"],
                'rol' => $row["user_rol"],
                'foto' => $row["user_foto"]
            );
            $jsonUserData = json_encode($userData); // Giriş başarılı ise, kullanıcıyı ana sayfaya yönlendir

            setcookie('kullanici_bilgileri', $jsonUserData, time() + (86400 * 30), "/"); //kullanıcıya bir günlük kayıt ettik 1 gün sonra tekrar giriş isteyecek

            echo "<meta http-equiv='refresh' content='1;url=index.php'>";
            echo '</div>'; // Giriş sayfasından çık


        } else {
            // Şifre yanlış ise, hata mesajı göster
            echo "<p class='alert alert-warning text-center'> Hatalı şifre. Lütfen tekrar deneyin. </p>";
        }
    } else {
        // Kullanıcı bulunamadı ise, hata mesajı göster
        echo "<p alert alert-danger text-center>Bu e-posta ile kayıtlı bir kullanıcı bulunamadı. </p>";
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
<style>
    body {
        background-image: url(./logo/background.png);
        background-size: cover;
    }
</style>


<body>
    <div class="container p-5">
        <form action="" method="POST" class="border">
            <div class="row mb-3 p-2">
                <label for="">
                    <h3 class="text-center alert alert-success">Giriş Yap</h3>
                </label>
                <label for="inputEmail3" class="col-sm-2 col-form-label ">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputEmail3" name="user-email" placeholder="xxx@gmail.com">
                </div>
            </div>
            <div class="row mb-3 p-2">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword3" name="user-password">
                </div>
            </div>
            <div class="text-center">
                <input type="submit" class="btn btn-success mb-3" name="buton" value="Giriş Yap"></input>
            </div>
        </form>
    </div>
    <div class="lab text-center">
        <label class="alert alert-primary">Hesabınız Yok mu ? <a href="kayit.php">Kayıt Ol</a></label>
    </div>
</body>

</html>