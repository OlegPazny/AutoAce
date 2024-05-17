<?php
require_once "db_connect.php";

// Запрос к базе данных для получения времени работы
$working_hours_query = mysqli_query($db, "SELECT
    TIME_FORMAT(MIN(STR_TO_DATE(SUBSTRING_INDEX(working_hours, '-', 1), '%H:%i')), '%H:%i') AS min_opening_time, 
    TIME_FORMAT(MAX(STR_TO_DATE(SUBSTRING_INDEX(working_hours, '-', -1), '%H:%i')), '%H:%i') AS max_closing_time, 
    TIME_FORMAT(MAX(STR_TO_DATE(SUBSTRING_INDEX(working_hours, '-', 1), '%H:%i')), '%H:%i') AS max_opening_time, 
    TIME_FORMAT(MIN(STR_TO_DATE(SUBSTRING_INDEX(working_hours, '-', -1), '%H:%i')), '%H:%i') AS min_closing_time
    FROM workshops;");

// Проверка на ошибки в запросе
if (!$working_hours_query) {
    die('Ошибка выполнения запроса: ' . mysqli_error($db));
}

// Создание массива для хранения отформатированных данных
$working_hours = array();

// Цикл по каждой строке результата запроса
while ($row = mysqli_fetch_assoc($working_hours_query)) {
    // Преобразование времени и добавление в массив
    $formatted_row = array(
        "min_opening_time" => $row["min_opening_time"],
        "max_closing_time" => $row["max_closing_time"],
        "max_opening_time" => $row["max_opening_time"],
        "min_closing_time" => $row["min_closing_time"]
    );
    // Добавление отформатированных данных в массив
    $working_hours[] = $formatted_row;
}

// Возвращаем отформатированные данные в формате JSON
echo json_encode($working_hours);

// Закрываем соединение с базой данных
mysqli_close($db);
?>
