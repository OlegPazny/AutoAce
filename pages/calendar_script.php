<?php

// Подключение к базе данных (замените данными вашего хоста, пользователя, пароля и имени базы данных)
$mysqli = new mysqli("localhost", "root", "", "AutoAce");

// Проверка соединения
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: " . $mysqli->connect_error;
    exit();
}

$service = $_POST['service'];
$worker = $_POST['worker'];
$start = ['start'];
$end = $_POST['end'];

function getAvailableSlots($mysqli, $service, $worker, $start, $end) {
    // Пример запроса к базе данных для получения доступных слотов времени
    $sql = "SELECT service_date, service_time FROM service_bookings 
            WHERE service_id IN (SELECT id FROM services WHERE service_name = '$service') 
            AND worker_id IN (SELECT id FROM workers WHERE name = '$worker') 
            AND service_date >= '$start' 
            AND service_date <= '$end'";
    $result = $mysqli->query($sql);

    $availableSlots = array();

    if ($result) {
        // Проход по результатам запроса
        while($row = $result->fetch_assoc()) {
            // Форматирование времени
            $startTime = date('Y-m-d\TH:i:s', strtotime($row['service_date'] . ' ' . $row['service_time']));
            $endTime = date('Y-m-d\TH:i:s', strtotime($row['service_date'] . ' ' . $row['service_time'] . '+30 minutes'));

            // Добавление доступного слота времени в массив
            $availableSlots[] = array(
                'start' => $startTime,
                'end' => $endTime
            );
        }
    } else {
        // Если возникла ошибка при выполнении запроса, выводим сообщение об ошибке
        echo "Ошибка при выполнении запроса: " . $mysqli->error;
    }

    // Возвращаем список доступных слотов времени в формате JSON
    return json_encode($availableSlots);
}

// Выполняем логику проверки доступных слотов на сервере
$availableSlots = getAvailableSlots($mysqli, $service, $worker, $start, $end);

// Возвращаем список доступных слотов времени в формате JSON
echo $availableSlots;

// Закрываем соединение с базой данных
$mysqli->close();

?>
