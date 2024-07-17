<?php
include 'baglanti.php';

$sql = "SELECT * FROM market";
$result = $conn->query($sql);


if (isset($_COOKIE["kullanici_bilgileri"])) {
    $kullanicibilgileri = $_COOKIE["kullanici_bilgileri"];
    $userData = json_decode($kullanicibilgileri, true);
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

    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            echo "<div class='row gap-3 mt-3' id='results'>";
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card" style="width:12rem;height:35rem;">';
                echo '<img class="card-img-top" src="' . $row["urun_foto"] . '" alt="Ürün Resmi">';
                echo '<div class="card-body d-flex flex-column">';
                echo '<h5 class="card-title">' . $row["urun_baslik"] . ' </h5>';
                echo '<p class="card-text"> ' . $row["urun_aciklamasi"] . '</p>';
                echo '<p class="card-text"> ' . $row["urun_fiyat"] . ' <strong>TL</strong></p>';

                echo '<div class="input-group mb-3">';
                echo '<span class="input-group-btn">';
                echo '<button type="button" class="btn btn-danger btn-number " data-type="minus" data-field="qty">';
                echo '<i class="fas fa-minus"></i>';
                echo '</button>';
                echo '</span>';
                echo '<input type="text" name="qty" class="form-control input-number" value="1" min="1" max="10">';
                echo '<span class="input-group-btn">';
                echo '<button type="button" class="btn btn-success btn-number " data-type="plus" data-field="qty">';
                echo '<i class="fas fa-plus"></i>';
                echo '</button>';
                echo '</span>';
                echo '</div>';

                echo '<a href="marketdetay.php?id=' . $row["urun_id"] . '" class="btn btn-secondary">Detaylara Bak</a>';

                echo '<div class="text-center"> ';
                echo ' <button class="btn btn-success mt-2  sepete-ekle" data-id="' . $row["urun_id"] . '">Sepete Ekle</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo "</div>";
        } else {
            echo "<p class='alert alert-danger text-center'>Eklenen veri yok</p>";
        }

        $conn->close();
        ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <script>
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

        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("filterForm");
            const filterButton = document.getElementById("filterButton");
            const checkboxes = form.querySelectorAll("input[type='checkbox']");

            filterButton.addEventListener("click", function(event) {
                event.preventDefault();
                const formData = new FormData(form);

                fetch("marketfilter.php", {
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

                fetch("marketfilter.php", {
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


        $('.btn-number').click(function(e) {
            e.preventDefault();
            var fieldName = $(this).attr('data-field');
            var type = $(this).attr('data-type');
            var input = $(this).closest('.input-group').find('input[name="' + fieldName + '"]');
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if (type == 'minus') {
                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }
                } else if (type == 'plus') {
                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                }
            } else {
                input.val(0);
            }
        });
    </script>
</body>

</html>