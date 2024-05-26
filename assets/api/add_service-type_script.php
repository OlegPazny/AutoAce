<?php
    require_once "db_connect.php";
    session_start();
    $serviceType=$_POST['service_type_name'];

    $query="INSERT INTO `service_Type` (`type`) VALUES ('$serviceType')";

    if(mysqli_query($db, $query)){
        $service_type_id=mysqli_insert_id($db);

        $response = [
            'success' => true,
            'serviceType' => [
                'id' => $service_type_id,
                'type' => $serviceType
            ]
        ];
        echo json_encode($response);
    }else{
        $response = ['success' => false];
        echo json_encode($response);
    }
?>