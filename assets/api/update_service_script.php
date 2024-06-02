<?php
    require_once "db_connect.php";
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);
    $service_id = $input['service_id'];
    $discount = $input['discount'];

    if($discount!=""){
        $query="UPDATE `services` SET `discount`=$discount WHERE `id`=$service_id";
    }else{
        $query="UPDATE `services` SET `discount`=NULL WHERE `id`=$service_id";
    }


    if(mysqli_query($db, $query)){
        echo json_encode(["success" => true]);
    }else{
        echo json_encode(["success" => false]);
    }

?>