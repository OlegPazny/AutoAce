<?php
    require_once "db_connect.php";

    $serviceName = $_POST['service_name'];
    $serviceDescription = $_POST['service_description'];
    $servicePrice = $_POST['service_price'];
    $serviceType = $_POST['service_type'];
    $serviceDiscount = $_POST['service_discount'];

    if($serviceDiscount!=""){
        $query="INSERT INTO `services` (`id`, `service_name`, `description`, `duration`, `id_service_type`, `discount`) VALUES (NULL, '$serviceName', '$serviceDescription', $servicePrice, $serviceType, $serviceDiscount)";

        if(mysqli_query($db, $query)){
            $serviceId=mysqli_insert_id($db);
    
            $service_type=mysqli_query($db, "SELECT `type` FROM `service_type` WHERE `id`=$serviceType");
            $service_type=mysqli_fetch_assoc($service_type);
    
            $response = [
                'success' => true,
                'service' => [
                    'id' => $serviceId,
                    'service_name' => $serviceName,
                    'service_description' => $serviceDescription,
                    'service_hours' => "$servicePrice",
                    'service_type' => $service_type['type'],
                    'service_discount' => $serviceDiscount
                ]
            ];
            echo json_encode($response);
        }else{
            $response = ['success' => false];
            echo json_encode($response);
        }
    }else{
        $query="INSERT INTO `services` (`id`, `service_name`, `description`, `duration`, `id_service_type`, `discount`) VALUES (NULL, '$serviceName', '$serviceDescription', $servicePrice, $serviceType, NULL)";

        if(mysqli_query($db, $query)){
            $serviceId=mysqli_insert_id($db);
    
            $service_type=mysqli_query($db, "SELECT `type` FROM `service_type` WHERE `id`=$serviceType");
            $service_type=mysqli_fetch_assoc($service_type);
    
            $response = [
                'success' => true,
                'service' => [
                    'id' => $serviceId,
                    'service_name' => $serviceName,
                    'service_description' => $serviceDescription,
                    'service_hours' => "$servicePrice",
                    'service_type' => $service_type['type'],
                    'service_discount' => ""
                ]
            ];
            echo json_encode($response);
        }else{
            $response = ['success' => false];
            echo json_encode($response);
        }
    }

?>