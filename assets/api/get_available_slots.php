<?php
require_once "db_connect.php";

// Обработчик маршрута /get_available_slots
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["date"])) {
    // Получение выбранной даты из запроса
    $selectedDate = $_GET["date"];

    // Запрос к базе данных для получения занятых слотов времени на выбранную дату
    $sql = "SELECT TIME_FORMAT(service_time, '%H:%i') AS service_time, services.price FROM service_bookings 
            INNER JOIN services ON service_bookings.service_id = services.id 
            WHERE service_date = '$selectedDate' AND `worker_id`=1";
    $result = $db->query($sql);

    // Формирование массива с занятыми слотами времени и продолжительностью услуги
    $occupiedSlots = [];
    if ($result) {
        $occupiedSlots = $result->fetch_all(MYSQLI_ASSOC);
    }

    // Формирование массива доступных слотов времени (шаг 30 минут)
    $start = strtotime('08:00');
    $end = strtotime('18:00');
    $timeIncrement = 30 * 60; // 30 минут в секундах

    $availableSlots = [];
    for ($i = $start; $i <= $end; $i += $timeIncrement) {
        $timeSlot = date('H:i', $i);
        $availableSlots[] = $timeSlot;
    }

    $occupiedDuration = []; // Массив для хранения длительности занятых слотов времени

    // Заполняем массив $occupiedDuration длительностями занятых слотов времени
    foreach ($occupiedSlots as $occupiedSlot) {
        $duration = (int) ceil($occupiedSlot['price'] / 0.5);
        $occupiedDuration[] = $duration;
    }

    // Удаляем занятые слоты времени
    foreach ($occupiedSlots as $occupiedSlot) {
        $serviceTime = $occupiedSlot['service_time'];
        if (($key = array_search($serviceTime, $availableSlots)) !== false) {
            $duration = array_shift($occupiedDuration); // Получаем длительность текущего занятого слота времени
            for ($i = $key; $i < $key + $duration; $i++) {
                unset($availableSlots[$i]);
            }
        }
    }

    // Удаляем слоты времени, которые недостаточны для выполнения услуги
    foreach ($availableSlots as $key => $slot) {
        $remainingSlots = count($availableSlots) - $key;
        $minDuration = !empty($occupiedDuration) ? min($occupiedDuration) : 1; // Устанавливаем минимальную длительность как 1, если массив $occupiedDuration пустой
        if ($remainingSlots < $minDuration) {
            unset($availableSlots[$key]);
        }
    }

    // Индексируем слоты времени в новом массиве
    $indexedSlots = array_values($availableSlots);

    echo json_encode($indexedSlots);
} else {
    // Если запрос не GET или не содержит дату, отправляем ошибку
    http_response_code(400);
    echo json_encode(["error" => "Некорректный запрос"]);
}
?>
