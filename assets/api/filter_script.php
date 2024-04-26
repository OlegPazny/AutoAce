<?php
require_once "db_connect.php";

// Получаем JSON данные из тела запроса
$json = file_get_contents('php://input');

// Преобразуем JSON в массив
$data = json_decode($json, true);

// Получаем выбранные услуги из данных
$selectedServices = isset($data['services']) ? $data['services'] : [];

// Проверяем, есть ли выбранные услуги
if (!empty($selectedServices)) {
    // Подготавливаем SQL запрос
    $sql = "SELECT w.*
            FROM workshops w
            WHERE NOT EXISTS (
                SELECT 1 FROM services s
                WHERE s.id NOT IN (
                    SELECT service_id FROM service_workshop_relationships swr
                    WHERE swr.workshop_id = w.id
                ) AND s.id IN (";

    // Добавляем плейсхолдеры для параметров
    $placeholders = rtrim(str_repeat("?,", count($selectedServices)), ",");

    // Завершаем запрос
    $sql .= $placeholders . "))";

    // Подготавливаем запрос
    $stmt = $db->prepare($sql);

    // Привязываем параметры
    $stmt->bind_param(str_repeat("i", count($selectedServices)), ...$selectedServices);

    // Выполняем запрос
    $stmt->execute();

    // Получаем результаты запроса
    $result = $stmt->get_result();

    // Создаем массив для хранения результатов
    $filteredData = array();

    // Перебираем результаты и добавляем их в массив
    while ($row = $result->fetch_assoc()) {
        $filteredData[] = $row;
    }

    // Возвращаем отфильтрованные данные в формате JSON
    echo json_encode($filteredData);

    // Закрываем запрос и соединение
    $stmt->close();
} else {
    // Если выбранных услуг нет, просто возвращаем пустой массив
    echo json_encode([]);
}

$db->close();
?>
