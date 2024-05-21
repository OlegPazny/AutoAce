<?php
// Подключаемся к базе данных
require_once "db_connect.php";


// Проверяем соединение
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Получаем id выбранной услуги и автосервиса
$serviceId = $_POST['serviceId'];
$workshopId = $_POST['workshopId'];

$sql = "SELECT `workers`.`id`, `workers`.`name`
FROM `worker_service_relationships`
INNER JOIN `workers` ON `worker_service_relationships`.`worker_id`=`workers`.`id`
INNER JOIN `workshops` ON `workers`.`workshop_id`=`workshops`.`id`
WHERE `worker_service_relationships`.`service_id`=$serviceId AND `workshops`.`id`=$workshopId;";
        
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // Создаем опции для выбора мастера в HTML-форме
    while($row = $result->fetch_assoc()) {
        echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
    }
} else {
    echo "<option value=''>Мастеры не найдены</option>";
}
$db->close();
?>
