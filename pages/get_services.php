<?php
    $host="localhost";
    $database="AutoAce";
    $user="root";
    $password="";
    $db=mysqli_connect($host, $user, $password, $database) or die("Ошибка ".mysqli_error($db));
    $db->set_charset("utf8mb4");

// Проверяем соединение
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Выполняем запрос к базе данных для получения списка услуг
$sql = "SELECT id, service_name, duration FROM services";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // Создаем опции для выбора услуги в HTML-форме
    while($row = $result->fetch_assoc()) {
        echo "<option value='" . $row["id"] . "' data-duration='" . $row["duration"] . "'>" . $row["service_name"] . "</option>";
    }
} else {
    echo "0 результатов";
}
$db->close();
?>
