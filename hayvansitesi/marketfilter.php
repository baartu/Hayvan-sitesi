<?php
include 'baglanti.php';
$sql = "SELECT * FROM market WHERE 1=1";

// Check if the search term is set
if (isset($_POST['search']) && !empty($_POST['search'])) {
    $search = $conn->real_escape_string($_POST['search']);
    $sql .= " AND (urun_baslik LIKE '%$search%' OR urun_aciklamasi LIKE '%$search%')";
} else {
    // If no search term provided, don't include search criteria
}

// Check if filters are set
if (isset($_POST['filter'])) {
    $filters = $_POST['filter'];
    if (!empty($filters)) {
        $filterStr = implode("','", array_map([$conn, 'real_escape_string'], $filters));
        $sql .= " AND urun_hayvan IN ('$filterStr')";
    }
}

$result = $conn->query($sql);

// Display the results
if ($result->num_rows > 0) {
    echo "<div class='row gap-3 p-4'>";
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
    echo "<h4 class='alert alert-danger text-center'>Eşleşme Bulunamadı</h4>";
}

$conn->close();
