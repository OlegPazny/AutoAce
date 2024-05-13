<?php
// Подключение к базе данных (замените на свои данные)
require_once "db_connect.php";

// Получение данных из POST запроса
$workerServiceId = $_POST['workerServiceId'];
// $user_id = $_SESSION['user']['id'];
$userId=2;
$serviceDate = $_POST['serviceDate'];
$serviceTime = $_POST['serviceTime'];
$status = "pending"; // Устанавливаем статус по умолчанию

// Подготовленный запрос для вставки записи в таблицу service_bookings
$stmt = $db->prepare("INSERT INTO service_bookings (worker_service_id, user_id, service_date, service_time, status) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iisss", $workerServiceId, $userId, $serviceDate, $serviceTime, $status);

// Выполнение запроса
if ($stmt->execute() === TRUE) {
    echo "Booking inserted successfully";
} else {
    echo "Error: " . $db->error;
}

// Закрытие соединения с базой данных
$stmt->close();
$db->close();
?>
