<?php
session_start();
// Подключение к базе данных (замените на свои данные)
require_once "db_connect.php";
// Получение данных из POST запроса
$workerServiceId = $_POST['workerServiceId'];
if(isset($_SESSION['user'])){
    $userId = $_SESSION['user']['id'];
}
$serviceDate = $_POST['serviceDate'];
$serviceTime = $_POST['serviceTime'];
$message = $_POST['message'];
$status = "pending"; // Устанавливаем статус по умолчанию
if(isset($_POST['vehicleId'])){
    $vehicle=$_POST['vehicleId'];
    // Подготовленный запрос для вставки записи в таблицу service_bookings
    $stmt = $db->prepare("INSERT INTO service_bookings (worker_service_id, user_id, vehicle_id, service_date, service_time, status, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiissss", $workerServiceId, $userId, $vehicle, $serviceDate, $serviceTime, $status, $message);
}else if (isset($_POST['email']) && !isset($_SESSION['user'])){
    $email=$_POST['email'];
    $create_user=mysqli_query($db, "INSERT INTO `users` (`login`, `name`, `email`, `password`, `role`, `isVerified`) VALUES (NULL, NULL, '$email', NULL, 'client', 0)");

    $new_user_id=mysqli_insert_id($db);

    // Подготовленный запрос для вставки записи в таблицу service_bookings
    $stmt = $db->prepare("INSERT INTO service_bookings (worker_service_id, user_id, service_date, service_time, status, message) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $workerServiceId, $new_user_id, $serviceDate, $serviceTime, $status, $message);
}else{
    // Подготовленный запрос для вставки записи в таблицу service_bookings
    $stmt = $db->prepare("INSERT INTO service_bookings (worker_service_id, user_id, service_date, service_time, status, message) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $workerServiceId, $userId, $serviceDate, $serviceTime, $status, $message);
}



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
