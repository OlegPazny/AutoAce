<?php
    require_once "db_connect.php";

    $workers=mysqli_query($db, "SELECT `id`, `name` FROM `workers`");

    $options = [];
if ($workers->num_rows > 0) {
    // Извлечение данных из результата запроса
    while($row = $workers->fetch_assoc()) {
        $options[] = ['value' => $row['id'], 'text' => $row['name']];
    }
    header('Content-Type: application/json');
    echo json_encode($options);
} else {
    echo json_encode([]);
    exit();
}
?>