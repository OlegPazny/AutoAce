<?php
    require_once "db_connect.php";

    $serviceNameRelation = $_POST['service_name_relation'];
    $workerNameRelation = $_POST['worker_name_relation'];

    $query="INSERT INTO `worker_service_relationships` (`worker_id`, `service_id`) VALUES ($workerNameRelation, $serviceNameRelation)";

    if(mysqli_query($db, $query)){
        $relation_id=mysqli_insert_id($db);

        $workshop_name=mysqli_query($db, "SELECT `workshops`.`name`
        FROM `workers`
        INNER JOIN `workshops` ON `workers`.`workshop_id`=`workshops`.`id`
        WHERE `workers`.`id`=$workerNameRelation");
        $workshop_name=mysqli_fetch_assoc($workshop_name);

        $worker_name=mysqli_query($db, "SELECT `name` FROM `workers` WHERE `id`=$workerNameRelation");
        $worker_name=mysqli_fetch_assoc($worker_name);

        $service_name=mysqli_query($db, "SELECT `service_name` FROM `services` WHERE `id`=$serviceNameRelation");
        $service_name=mysqli_fetch_assoc($service_name);

        $response = [
            'success' => true,
            'relation' => [
                'id' => $relation_id,
                'workshop_name' => $workshop_name['name'],
                'worker_name' => $worker_name['name'],
                'service_name' => $service_name['service_name'],
            ]
        ];
        echo json_encode($response);
    }else{
        $response = ['success' => false];
        echo json_encode($response);
    }
?>