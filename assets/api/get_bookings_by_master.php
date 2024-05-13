<?php
// Подключаемся к базе данных
require_once "db_connect.php";

// Проверяем соединение
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Получаем id выбранного мастера
$masterId = $_POST['masterId'];

// Выполняем запрос к базе данных для получения записей на услуги для выбранного мастера
$sql = "SELECT sb.id, sb.service_date, sb.service_time, sb.status, s.duration
FROM service_bookings sb
INNER JOIN worker_service_relationships wsr ON sb.worker_service_id = wsr.id
INNER JOIN services s ON wsr.service_id = s.id
WHERE wsr.worker_id = $masterId";

$result = $db->query($sql);

if ($result->num_rows > 0) {
    // Формируем массив с данными о записях
    $bookings = array();
    while ($row = $result->fetch_assoc()) {
        $booking = array(
            'id' => $row['id'],
            'service_date' => $row['service_date'],
            'service_time' => $row['service_time'],
            'status' => $row['status'],
            'duration' => $row['duration']
        );
        array_push($bookings, $booking);
    }

    // Кодируем массив в формат JSON и выводим его
    echo json_encode($bookings);
} else {
    echo json_encode(array()); // Выводим пустой массив, если записей нет
}
$db->close();
?>
