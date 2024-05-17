<?php
require_once "db_connect.php";

// Получаем JSON данные из тела запроса
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Получаем время работы из данных
$workingHours = isset($data['workingHours']) ? $data['workingHours'] : [];

// Получаем выбранные услуги
$selectedServices = isset($data['services']) ? $data['services'] : [];

// Подготовка SQL запроса с фильтрацией по услугам и времени работы
$sql = "SELECT w.*
        FROM workshops w
        INNER JOIN workers wo ON w.id = wo.workshop_id
        INNER JOIN worker_service_relationships ws ON wo.id = ws.worker_id
        INNER JOIN services s ON ws.service_id = s.id
        WHERE 1=1";

// Фильтрация по выбранным услугам
if (!empty($selectedServices)) {
    foreach ($selectedServices as $service) {
        $sql .= " AND EXISTS (
            SELECT 1 FROM worker_service_relationships ws_check
            INNER JOIN services s_check ON ws_check.service_id = s_check.id
            WHERE ws_check.worker_id = wo.id AND s_check.id = ?
        )";
    }
}

// Фильтрация по времени работы
if (!empty($workingHours)) {
    $startTime = $workingHours['start'];
    $endTime = $workingHours['end'];
    $sql .= " AND (
        TIME(STR_TO_DATE(SUBSTRING_INDEX(w.working_hours, '-', 1), '%H:%i')) <= ? 
        AND TIME(STR_TO_DATE(SUBSTRING_INDEX(w.working_hours, '-', -1), '%H:%i')) >= ?
    )";
}

// Подготавливаем запрос
$stmt = $db->prepare($sql);

// Привязываем параметры
$types = str_repeat("i", count($selectedServices)) . "ss";
$params = array_merge($selectedServices, [$startTime, $endTime]);
$stmt->bind_param($types, ...$params);

// Выполняем запрос
$stmt->execute();

// Получаем результаты запроса
$result = $stmt->get_result();

// Создаем массив для хранения результатов
$filteredData = array();
while ($row = $result->fetch_assoc()) {
    $filteredData[] = $row;
}

// Возвращаем отфильтрованные данные в формате JSON
echo json_encode($filteredData);

// Закрываем запрос и соединение
$stmt->close();
$db->close();
?>
