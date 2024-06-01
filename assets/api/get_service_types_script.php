<?php
    require_once "db_connect.php";

    $service_types=mysqli_query($db, "SELECT `id`, `type` FROM `service_type`");

    $options = [];
if ($service_types->num_rows > 0) {
    // Извлечение данных из результата запроса
    while($row = $service_types->fetch_assoc()) {
        $options[] = ['value' => $row['id'], 'text' => $row['type']];
    }
    header('Content-Type: application/json');
    echo json_encode($options);
} else {
    echo json_encode([]);
    exit();
}
?>