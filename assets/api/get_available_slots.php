<?php
require_once "db_connect.php";

// Обработчик маршрута /get_available_slots
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["date"])) {
    // Получение выбранной даты из запроса
    $selectedDate = $_GET["date"];

    // Запрос к базе данных для получения занятых слотов времени на выбранную дату
    $sql = "SELECT DISTINCT TIME(service_time) AS service_time FROM service_bookings WHERE DATE(service_date) = '$selectedDate' AND service_id = 5 AND worker_id = 1";
    $result = $db->query($sql);

    // Формирование массива с занятыми слотами времени
    $occupiedSlots = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Преобразуем время в формат "часы:минуты"
            $time = date("H:i", strtotime($row["service_time"]));
            $occupiedSlots[] = $time;
        }
    }

    // Запрос к базе данных для получения длительности услуги
    $serviceId = 5; // ID услуги, может быть передан как параметр запроса, если необходимо
    $sqlService = "SELECT price FROM services WHERE id = $serviceId";
    $resultService = $db->query($sqlService);
    $serviceDuration = 0; // Длительность услуги по умолчанию
    if ($resultService->num_rows > 0) {
        $rowService = $resultService->fetch_assoc();
        $serviceDuration = $rowService["price"];
    }

    // Преобразуем длительность услуги в минуты
    $serviceDurationMinutes = $serviceDuration * 60;

    // Формирование массива доступных слотов времени (шаг 30 минут)
    $availableSlots = [];
    $start = strtotime('08:00');
    $end = strtotime('18:00');
    for ($i = $start; $i <= $end; $i += 1800) { // 1800 секунд = 30 минут
        $timeSlot = date('H:i', $i);
        
        // Проверяем доступность слота времени, учитывая длительность услуги
        $isSlotAvailable = true;
        for ($j = 0; $j < $serviceDurationMinutes / 30; $j++) { // Делим длительность услуги на 30 минут
            $currentTime = strtotime($timeSlot) + ($j * 1800); // Увеличиваем текущее время на 30 минут
            $currentSlot = date('H:i', $currentTime);

            // Проверяем, занят ли текущий слот времени
            if (in_array($currentSlot, $occupiedSlots)) {
                $isSlotAvailable = false;
                break;
            }
        }

        // Если слот времени доступен, добавляем его в массив доступных слотов
        if ($isSlotAvailable) {
            $availableSlots[] = $timeSlot;
        }
    }

    // Удаляем слоты времени, которые находятся в течение времени выполнения услуги
    $startService = strtotime('14:00'); // Время начала услуги
    $endService = strtotime('16:00'); // Время окончания услуги
    foreach ($availableSlots as $key => $slot) {
        $timeSlot = strtotime($slot);
        if ($timeSlot >= $startService && $timeSlot <= $endService) {
            unset($availableSlots[$key]);
        }
    }

    // Переиндексируем массив, чтобы избежать пропусков в индексах
    $availableSlots = array_values($availableSlots);

    echo json_encode($availableSlots);
} else {
    // Если запрос не GET или не содержит дату, отправляем ошибку
    http_response_code(400);
    echo json_encode(["error" => "Некорректный запрос"]);
}
?>
