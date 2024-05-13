<?php
// Подключаемся к базе данных
require_once "db_connect.php";


// Проверяем соединение
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Получаем id выбранной услуги
$serviceId = $_POST['serviceId'];

$sql = "SELECT DISTINCT w.id, w.name AS master_name FROM workers w
        INNER JOIN service_workshop_relationships swr ON swr.workshop_id = w.workshop_id
        WHERE swr.service_id = $serviceId";$sql = "SELECT DISTINCT w.id, w.name AS master_name FROM workers w
        INNER JOIN service_workshop_relationships swr ON swr.workshop_id = w.workshop_id
        WHERE swr.service_id = $serviceId";
        
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // Создаем опции для выбора мастера в HTML-форме
    while($row = $result->fetch_assoc()) {
        echo "<option value='" . $row["id"] . "'>" . $row["master_name"] . "</option>";
    }
} else {
    echo "<option value=''>Мастеры не найдены</option>";
}
$db->close();
?>
