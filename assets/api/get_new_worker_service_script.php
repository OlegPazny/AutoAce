<?php
session_start();
require_once "db_connect.php";

if(isset($_GET['worker_id'])){
    $worker_id=$_GET['worker_id'];

    $new_services=mysqli_query($db, "SELECT * FROM `services`
    WHERE `id` NOT IN (
        SELECT DISTINCT `service_id` FROM `worker_service_relationships`
        WHERE `worker_id`=$worker_id
        );
    ");
    // Создаем массив для хранения данных об услугах
    $services = [];

    // Перебираем результаты запроса и добавляем их в массив
    while ($row = mysqli_fetch_all($new_services)) {
        $services = $row;
    }

    // Возвращаем данные об услугах в формате JSON
    echo json_encode($services);
}else{
    echo json_encode([]);
}

?>