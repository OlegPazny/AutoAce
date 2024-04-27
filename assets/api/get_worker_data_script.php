<?php
session_start();
require_once "db_connect.php";

if(isset($_GET['service_id'])){
    $service_id=$_GET['service_id'];

    // $get_workers=mysqli_query($db, "SELECT DISTINCT workers.id, workers.name, services.service_name, workshops.name 
    // FROM workers
    // JOIN workshops ON workers.workshop_id = workshops.id
    // JOIN service_workshop_relationships ON workshops.id = service_workshop_relationships.workshop_id
    // JOIN services ON service_workshop_relationships.service_id = services.id
    // LEFT JOIN worker_service_relationships ON services.id = worker_service_relationships.service_id
    // WHERE services.id = $service_id;");
    $get_workers=mysqli_query($db, "SELECT w.name, w.id FROM worker_service_relationships wsr
    inner join workers w on wsr.worker_id=w.id
    WHERE service_id=$service_id");
    // Создаем массив для хранения данных о работниках
    $workers = [];

    // Перебираем результаты запроса и добавляем их в массив
    while ($row = mysqli_fetch_all($get_workers)) {
        $workers = $row;
    }

    // Возвращаем данные о работниках в формате JSON
    echo json_encode($workers);
}else{
    echo json_encode([]);
}

?>