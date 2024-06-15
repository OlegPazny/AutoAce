<?php
require_once "db_connect.php";
require_once "mail_client_connect.php";
header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);
$book_id = $input['book_id'];
$vin = $input['vin'];
$select_car = mysqli_query($db, "SELECT `vehicles`.`id` FROM `service_bookings` INNER JOIN `vehicles` ON `service_bookings`.`vehicle_id`=`vehicles`.`id` WHERE `service_bookings`.`id`=$book_id");


if (strlen($vin) == 17 && preg_match('/^[A-HJ-NPR-Z0-9]{17}$/', $vin)) {
    if (mysqli_num_rows($select_car) > 0) {
        $current_vehicle_id = mysqli_fetch_assoc($select_car);
        $car_id = $current_vehicle_id['id'];
        $update_car = mysqli_query($db, "UPDATE `vehicles` SET `vin`='$vin' WHERE `id`=$car_id");
    }else{
        $response = [
            "success" => false,
            "message" => "Чтобы изменить VIN-код необходимо добавить автомобиль."
        ];
        echo json_encode($response);
        die();
    }
} else {
    $response = [
        "success" => false,
        "message" => "VIN-код должен состоять из 17 символов, содержащих только латинские буквы и цифры."
    ];
    echo json_encode($response);
    die();
}

echo json_encode(["success" => true]);

?>