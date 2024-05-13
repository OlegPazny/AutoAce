<?php
// Подключение к базе данных
require_once "db_connect.php";

// Проверка соединения
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Получение данных из POST запроса
$workerId = $_POST['workerId'];
$serviceId = $_POST['serviceId'];

// Подготовленный запрос для поиска worker_service_id
$stmt = $db->prepare("SELECT id FROM worker_service_relationships WHERE worker_id = ? AND service_id = ?");
$stmt->bind_param("ii", $workerId, $serviceId);

// Выполнение запроса
$stmt->execute();

// Получение результата
$result = $stmt->get_result();

// Проверка наличия результата
if ($result->num_rows > 0) {
    // Получение первой строки результата
    $row = $result->fetch_assoc();
    $workerServiceId = $row['id'];

    // Отправка найденного worker_service_id клиенту
    echo $workerServiceId;
} else {
    // Если соответствующая запись не найдена, отправляем сообщение об ошибке
    echo "Worker service ID not found";
}

// Закрытие соединения с базой данных
$stmt->close();
$db->close();
?>
