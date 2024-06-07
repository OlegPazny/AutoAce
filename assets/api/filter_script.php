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

$params = [];
$types = '';

if (!empty($selectedServices)) {
    $sql .= " AND w.id IN (
                SELECT wo.workshop_id
                FROM workers wo
                INNER JOIN worker_service_relationships ws ON wo.id = ws.worker_id
                WHERE ws.service_id IN (" . implode(',', array_fill(0, count($selectedServices), '?')) . ")
                GROUP BY wo.workshop_id
                HAVING COUNT(DISTINCT ws.service_id) = ?
              )";
    $params = array_merge($params, $selectedServices);
    $params[] = count($selectedServices);
    $types .= str_repeat('i', count($selectedServices)) . 'i';
}

if (!empty($workingHours)) {
    $startTime = $workingHours['start'];
    $endTime = $workingHours['end'];

    $sql .= " AND (
        TIME(SUBSTRING_INDEX(w.working_hours, '-', 1)) <= TIME(?) 
        AND TIME(SUBSTRING_INDEX(w.working_hours, '-', -1)) >= TIME(?)
    )";
    $params[] = $startTime;
    $params[] = $endTime;
    $types .= 'ss';
}

$stmt = $db->prepare($sql);

if ($types) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();

$result = $stmt->get_result();

$filteredData = array();
while ($row = $result->fetch_assoc()) {
    $filteredData[] = $row;
}

echo json_encode($filteredData);

$stmt->close();
$db->close();
?>
