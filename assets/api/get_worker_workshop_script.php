<?php
session_start();
require_once "db_connect.php";

if(isset($_GET['worker_id'])){
    $worker_id=$_GET['worker_id'];

    $get_workshops=mysqli_query($db, "SELECT DISTINCT `workshops`.`name` FROM `workers`
    INNER JOIN `workshops` ON `workers`.`workshop_id`=`workshops`.`id`
    WHERE `workers`.`id`=$worker_id
    ");
    // Создаем массив для хранения данных о работниках
    $workshops = [];

    // Перебираем результаты запроса и добавляем их в массив
    while ($row = mysqli_fetch_all($get_workshops)) {
        $workshops = $row;
    }

    // Возвращаем данные о работниках в формате JSON
    echo json_encode($workshops);
}else{
    echo json_encode([]);
}

?>