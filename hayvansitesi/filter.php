<?php
include 'baglanti.php';
$sql = "SELECT * FROM sss WHERE 1=1";

// Check if the search term is set
if (isset($_POST['search']) && !empty($_POST['search'])) {
    $search = $conn->real_escape_string($_POST['search']);
    $sql .= " AND (user_baslik LIKE '%$search%' OR user_aciklama LIKE '%$search%')";
} else {
    // If no search term provided, don't include search criteria
}

// Check if filters are set
if (isset($_POST['filter'])) {
    $filters = $_POST['filter'];
    if (!empty($filters)) {
        $filterStr = implode("','", array_map([$conn, 'real_escape_string'], $filters));
        $sql .= " AND user_hayvan IN ('$filterStr')";
    }
}

$result = $conn->query($sql);

// Display the results
if ($result->num_rows > 0) {
    echo "<div class='row gap-3 p-4'>";
    while ($row = $result->fetch_assoc()) {
        echo '<div class="card" style="width:15rem;">';
        echo '<img class="card-img-top" src="' . $row["user_dosya"] . '"</img>';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $row["user_baslik"] . ' </h5>';
        echo '<p class="card-text"> ' . $row["user_aciklama"] . '</p>';
        echo '<p class="card-text"> ' . $row["user_eposta"] . '</p>';
        echo '<a href="/maindetay.php?id=' . $row["sss_id"] . '"class="btn btn-secondary" >Detaylara Bak</a>';
        echo '</div>';
        echo '</div>';
    }
    echo "</div>";
} else {
    echo "<h4 class='alert alert-danger text-center'>Eşleşme Bulunamadı</h4>";
}

$conn->close();
