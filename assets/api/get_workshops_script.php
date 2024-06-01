<?php
    require_once "db_connect.php";

    $workshops=mysqli_query($db, "SELECT `id`, `name` FROM `workshops`");

    $options = [];
if ($workshops->num_rows > 0) {
    // Извлечение данных из результата запроса
    while($row = $workshops->fetch_assoc()) {
        $options[] = ['value' => $row['id'], 'text' => $row['name']];
    }
    header('Content-Type: application/json');
    echo json_encode($options);
} else {
    echo json_encode([]);
    exit();
}
?>