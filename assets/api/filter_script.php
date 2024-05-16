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
    $sql = "SELECT DISTINCT w.*
            FROM workshops w
            JOIN workers wr ON wr.workshop_id = w.id
            JOIN worker_service_relationships wsr ON wsr.worker_id = wr.id
            JOIN services s ON s.id = wsr.service_id
            WHERE s.id IN (";

    // Добавляем плейсхолдеры для параметров
    $placeholders = rtrim(str_repeat("?,", count($selectedServices)), ",");

    // Завершаем запрос
    $sql .= $placeholders . ")
            GROUP BY w.id
            HAVING COUNT(DISTINCT s.id) = ?";

    // Подготавливаем запрос
    if ($stmt = $db->prepare($sql)) {
        // Привязываем параметры
        $types = str_repeat("i", count($selectedServices)) . "i";
        $params = array_merge($selectedServices, [count($selectedServices)]);
        $stmt->bind_param($types, ...$params);

        // Выполняем запрос
        if ($stmt->execute()) {
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
        } else {
            // Обработка ошибки выполнения запроса
            echo json_encode(["error" => "Ошибка выполнения запроса."]);
        }

        // Закрываем запрос
        $stmt->close();
    } else {
        // Обработка ошибки подготовки запроса
        echo json_encode(["error" => "Ошибка подготовки запроса."]);
    }
} else {
    // Если выбранных услуг нет, просто возвращаем пустой массив
    echo json_encode([]);
}

// Закрываем соединение с базой данных
$db->close();
?>
