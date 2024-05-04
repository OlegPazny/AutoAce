<?php
// Подключение к базе данных
require_once "db_connect.php";

// Обработчик маршрута /get_booked_slots
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["date"])) {
    // Получение выбранной даты из запроса
    $selectedDate = $_GET["date"];
    $formattedDate = date("Y-m-d", strtotime($selectedDate));
    // SQL-запрос для получения занятых слотов времени на выбранную дату
    $sql = "SELECT service_time, services.price
            FROM service_bookings 
            inner join services on service_bookings.service_id=services.id
            WHERE service_date = '$formattedDate' AND service_id = 5 AND worker_id = 1";
    $result = $db->query($sql);

    // Проверка на ошибки при выполнении запроса
    if (!$result) {
        http_response_code(500);
        echo json_encode(["error" => "Ошибка при выполнении запроса к базе данных"]);
        exit();
    }

    // Формирование массива с занятыми слотами времени
    $bookedSlots = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Получаем время начала записи на услугу и длительность услуги
            $serviceTime = $row["service_time"];
            $serviceDuration = $row["price"];

            // Рассчитываем время окончания записи на услугу
            $endTime = date("H:i", strtotime("$serviceTime + $serviceDuration minutes"));

            // Добавляем слот времени в массив
            $bookedSlots[] = ["start_time" => $serviceTime, "end_time" => $endTime];
        }
    }

    // Возвращаем занятые слоты времени в формате JSON
    echo json_encode($bookedSlots);
} else {
    // Если запрос не GET или не содержит дату, отправляем ошибку
    http_response_code(400);
    echo json_encode(["error" => "Некорректный запрос"]);
}
?>
