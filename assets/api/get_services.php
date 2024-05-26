<?php
session_start();
require_once "db_connect.php";

// Проверяем соединение
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$response = ["status" => false]; // Default response

if (isset($_SESSION['workshop_id'])) {
    $workshop_id = $_SESSION['workshop_id'];

    $workshop_price=mysqli_query($db, "SELECT standart_hour FROM workshops WHERE id=$workshop_id");
    $workshop_price=mysqli_fetch_assoc($workshop_price);

    // Выполняем запрос к базе данных для получения списка услуг
    $worker_services_data = mysqli_query($db, "SELECT DISTINCT
        s.id AS service_id, s.service_name AS service_name, st.type AS service_type, s.duration AS service_duration, s.discount AS service_discount, ws.id AS workshop_id, ws.name AS workshop_name
        FROM workers w
        INNER JOIN worker_service_relationships wsr ON w.id = wsr.worker_id
        INNER JOIN services s ON wsr.service_id = s.id
        INNER JOIN service_type st ON s.id_service_type=st.id
        INNER JOIN workshops ws ON w.workshop_id = ws.id
        WHERE w.workshop_id=$workshop_id AND w.vacation=0;");
    $services_data = mysqli_fetch_all($worker_services_data);

    if ($services_data) {
        $services_arr = [];
        foreach ($services_data as $service_data) {
            $service_type = $service_data[2];
            $service_id = $service_data[0];
            $service_name = $service_data[1];
            $service_duration = $service_data[3];
            if (!isset($services_arr[$service_type])) {
                $services_arr[$service_type] = [];
            }
            $services_arr[$service_type][] = [
                'id' => $service_id,
                'name' => $service_name,
                'duration' => $service_duration,
                'price' => $service_duration*$workshop_price['standart_hour']
            ];
        }

        $options = "";
        foreach ($services_arr as $service_type => $services) {
            $options .= "<option disabled class='disabled-option'>$service_type</option>";
            foreach ($services as $service) {
                $options .= "<option class='service-option' data-duration='{$service['duration']}' value='{$service['id']}'>{$service['name']} {$service['price']} р.</option>";
            }
        }

        $response = ["status" => true, "options" => $options];
    }
}

// Отправляем ответ
echo json_encode($response);

// Закрываем соединение с базой данных
$db->close();
?>