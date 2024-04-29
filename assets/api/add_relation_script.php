<?php
    require_once "db_connect.php";

    $serviceNameRelation = $_POST['service_name_relation'];
    $workerNameRelation = $_POST['worker_name_relation'];

    $add_relation=mysqli_query($db, "INSERT INTO `worker_service_relationships` (`worker_id`, `service_id`) VALUES ($workerNameRelation, $serviceNameRelation)");
?>