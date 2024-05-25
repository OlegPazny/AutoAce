<?php
    require_once "db_connect.php";

    $name = $_POST['workshop_name'];
    $address = $_POST['workshop_address'];
    $hours = $_POST['workshop_hours'];
    $price = $_POST['workshop_price'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $photo = $_POST['photo'];

    $query="INSERT INTO `workshops` (`name`, `address`, `latitude`, `longitude`, `working_hours`, `standart_hour`, `photo`) VALUES ('$name', '$address', 
    $latitude, $longitude, '$hours', $price, '$photo')";

    if(mysqli_query($db, $query)){
        $workshop_id=mysqli_insert_id($db);

        $response = [
            'success' => true,
            'workshop' => [
                'id' => $workshop_id,
                'workshop_name' => $name,
                'workshop_address' => $address,
                'workshop_hours' => $hours,
                'workshop_price' => $price,
                'photo' => $photo
            ]
        ];
        echo json_encode($response);
    }else{
        $response = ['success' => false];
        echo json_encode($response);
    }
?>