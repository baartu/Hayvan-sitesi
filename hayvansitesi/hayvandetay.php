<!DOCTYPE html>
<html lang="en">
<?php
include './partials/head.php';
?>

<body>
    <?php
    include './partials/navbar.php';
    ?>
    <div class="container border ">
        <div class="row p-5">
            <?php
            include 'baglanti.php';
            $havyan_id = $_GET["id"];

            $sql = "SELECT * FROM hayvan WHERE hayvan_id= $havyan_id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            echo $row["hayvan_aciklama"];

            ?>
        </div>

    </div>
</body>

</html>