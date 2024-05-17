<?php
    require_once "db_connect.php";
    session_start();
    $user_id=$_SESSION['user']['id'];
    $vehicleBrand = $_POST['vehicleBrand'];
    $numberPlate = $_POST['numberPlate'];

    $query="INSERT INTO `vehicles` (`brand`, `num_plate`, `user_id`) VALUES ('$vehicleBrand', '$numberPlate', 
    $user_id)";

    if(mysqli_query($db, $query)){
        $vehicle_id=mysqli_insert_id($db);

        $response = [
            'success' => true,
            'vehicle' => [
                'id' => $vehicle_id,
                'brand' => $vehicleBrand,
                'number_plate' => $numberPlate
            ]
        ];
        echo json_encode($response);
    }else{
        $response = ['success' => false];
        echo json_encode($response);
    }
?>