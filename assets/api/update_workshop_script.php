<?php
    require_once "db_connect.php";
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);
    $workshop_id = $input['workshop_id'];
    $workshop_name = $input['workshop_name'];
    $workshop_address = $input['workshop_address'];
    $workshop_hours = $input['workshop_hours'];
    $workshop_price = $input['workshop_price'];
    $workshop_photo = $input['photo'];

    $query="UPDATE `workshops` SET `name`='$workshop_name', `address`='$workshop_address', `working_hours`='$workshop_hours', `standart_hour`='$workshop_price', `photo`='$workshop_photo' WHERE `id`=$workshop_id";

    if(mysqli_query($db, $query)){
        echo json_encode(["success" => true]);
    }else{
        echo json_encode(["success" => false]);
    }

?>