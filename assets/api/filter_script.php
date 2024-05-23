<?php
require_once "db_connect.php";

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$workingHours = isset($data['workingHours']) ? $data['workingHours'] : [];

$selectedServices = isset($data['services']) ? $data['services'] : [];

$sql = "SELECT DISTINCT w.*
        FROM workshops w
        INNER JOIN workers wo ON w.id = wo.workshop_id
        INNER JOIN worker_service_relationships ws ON wo.id = ws.worker_id
        INNER JOIN services s ON ws.service_id = s.id
        WHERE 1=1";

if (!empty($selectedServices)) {
    foreach ($selectedServices as $service) {
        $sql .= " AND EXISTS (
            SELECT 1 FROM worker_service_relationships ws_check
            INNER JOIN services s_check ON ws_check.service_id = s_check.id
            WHERE ws_check.worker_id = wo.id AND s_check.id = ?
        )";
    }
}

if (!empty($workingHours)) {
    $startTime = $workingHours['start'];
    $endTime = $workingHours['end'];
    $sql .= " AND (
        TIME(STR_TO_DATE(SUBSTRING_INDEX(w.working_hours, '-', 1), '%H:%i')) <= ? 
        AND TIME(STR_TO_DATE(SUBSTRING_INDEX(w.working_hours, '-', -1), '%H:%i')) >= ?
    )";
}

$stmt = $db->prepare($sql);

$types = str_repeat("i", count($selectedServices)) . "ss";
$params = array_merge($selectedServices, [$startTime, $endTime]);
$stmt->bind_param($types, ...$params);

$stmt->execute();

$result = $stmt->get_result();

// Создаем массив для хранения результатов
$filteredData = array();
while ($row = $result->fetch_assoc()) {
    $filteredData[] = $row;
}

echo json_encode($filteredData);

// Закрываем запрос и соединение
$stmt->close();
$db->close();
?>
