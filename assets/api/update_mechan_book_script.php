<?php
require_once "db_connect.php";
require_once "mail_client_connect.php";
header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);
$book_id = $input['book_id'];
$mechan_comment = $input['mechan_comment'];
$newStatus = $input['status'];
$vehicle = $input['vehicle'];
$plate = $input['plate'];
$vin = $input['vin'];

$oldStatus = mysqli_query($db, "SELECT `status` FROM `service_bookings` WHERE `id`=$book_id");
$oldStatus = mysqli_fetch_assoc($oldStatus);

if (isset($input['total_price'])) {
    $total_price = $input['total_price'];
    if ($total_price != "") {
        $update_total_price = mysqli_query($db, "UPDATE `service_bookings` SET `total_price`=$total_price WHERE `id`=$book_id");
    }
}
$select_car = mysqli_query($db, "SELECT `vehicles`.`id` FROM `service_bookings` INNER JOIN `vehicles` ON `service_bookings`.`vehicle_id`=`vehicles`.`id` WHERE `service_bookings`.`id`=$book_id");


if (($vehicle == "" && $plate == "" && $vin == "") || ($vehicle != "" && $plate != "" && $vin != "")) {
    if (mysqli_num_rows($select_car) > 0 && ($vehicle == "" || $plate == "" || $vin == "")) {
        $response = [
            "success" => false,
            "message" => "Введите все данные автомобиля."
        ];
        echo json_encode($response);
        die();
    }
    if ($vehicle != "" && $plate != "" && $vin != "") {
        $user_id = mysqli_query($db, "SELECT `user_id` FROM `service_bookings` WHERE `id`=$book_id");
        $user_id = mysqli_fetch_assoc($user_id);
        $user_id = $user_id['user_id'];

        if (strlen($vin) == 17 && preg_match('/^[A-HJ-NPR-Z0-9]{17}$/', $vin)) {
            if (mysqli_num_rows($select_car) > 0) {
                $current_vehicle_id = mysqli_fetch_assoc($select_car);
                $car_id = $current_vehicle_id['id'];
                $update_car = mysqli_query($db, "UPDATE `vehicles` SET `brand`='$vehicle', `num_plate`='$plate', `vin`='$vin' WHERE `id`=$car_id");
            } else {
                $insert_car = mysqli_query($db, "INSERT INTO `vehicles` VALUES (NULL, '$vehicle', '$plate', $user_id, '$vin')");
                $new_car_id = mysqli_insert_id($db);
                $update_book = mysqli_query($db, "UPDATE `service_bookings` SET `vehicle_id`=$new_car_id WHERE `id`=$book_id");
            }
        } else {
            $response = [
                "success" => false,
                "message" => "VIN-код должен состоять из 17 символов, содержащих только латинские буквы и цифры."
            ];
            echo json_encode($response);
            die();
        }
    }
} else {
    $response = [
        "success" => false,
        "message" => "Введите все данные автомобиля."
    ];
    echo json_encode($response);
    die();
}

//обновление комментария механика
if ($mechan_comment != "") {
    $update_mechan_comment = mysqli_query($db, "UPDATE `service_bookings` SET `comment`='$mechan_comment' WHERE `id`=$book_id");
}
//обновление статуса
$date = date("Y-m-d");
$time = date("H:i:s");

$client = mysqli_query($db, "SELECT `users`.`name`, `users`.`email` FROM `service_bookings`
    INNER JOIN `users` ON `service_bookings`.`user_id`=`users`.`id`
    WHERE `service_bookings`.`id`=$book_id");
$client = mysqli_fetch_assoc($client);

$service = mysqli_query($db, "SELECT `services`.`service_name` FROM `service_bookings`
    INNER JOIN `worker_service_relationships` ON `service_bookings`.`worker_service_id`=`worker_service_relationships`.`id`
    INNER JOIN `services` ON `worker_service_relationships`.`service_id`=`services`.`id`
    WHERE `service_bookings`.`id`=$book_id");
$service = mysqli_fetch_assoc($service);

if ($newStatus == "completed" && $newStatus != $oldStatus['status']) {
    $move_to_history = mysqli_query($db, "INSERT INTO `service_history` (`id`, `booking_id`, `completion_date`, `completion_time`) VALUES (NULL, '$book_id', '$date', '$time')");
    $price_str = "";
    if ($total_price != "") {
        $price_str = "<p>Окончательная стоимость ремонта составила " . $total_price . " р.</p>";
    }
    $body = "
        <p>Здравствуйте, " . $client['name'] . "</p>
        <p>Услуга " . $service['service_name'] . " выполнена!</p>
        " . $price_str . "
        <p>Приезжайте за автомобилем в удобное для Вас время!</p>
        <p>Спасибо за выбор автосервиса!</p>
        <p>С уважением AutoAce!</p>
    ";
    send_mail($settings['mail_settings'], [$client['email']], 'Статус выполнения изменен!', $body);
} else if ($newStatus == "pending" && $newStatus != $oldStatus['status']) {
    $delete_from_history = mysqli_query($db, "DELETE FROM `service_history` WHERE `booking_id`=$book_id");
} else if ($newStatus == "confirmed" && $newStatus != $oldStatus['status']) {
    $delete_from_history = mysqli_query($db, "DELETE FROM `service_history` WHERE `booking_id`=$book_id");
    $body = "
        <p>Здравствуйте, " . $client['name'] . "</p>
        <p>Мы начали выполнение услуги " . $service['service_name'] . ".</p>
        <p>Как только работы будут завершены, мы обязательно Вам сообщим!</p>
        <p>Спасибо за выбор автосервиса!</p>
        <p>С уважением AutoAce!</p>
    ";
    send_mail($settings['mail_settings'], [$client['email']], 'Статус выполнения изменен!', $body);
}
$update_status = mysqli_query($db, "UPDATE `service_bookings` SET `status`='$newStatus' WHERE `id`=$book_id");


echo json_encode(["success" => true]);

?>