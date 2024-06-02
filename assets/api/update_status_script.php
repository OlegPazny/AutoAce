<?php
    require_once "db_connect.php";
    require_once "mail_client_connect.php";

    $bookingId = $_POST['booking_id'];
    $newStatus = $_POST['new_status'];
    $date=date("Y-m-d");
    $time=date("H:i:s");

    $client=mysqli_query($db, "SELECT `users`.`name`, `users`.`email` FROM `service_bookings`
    INNER JOIN `users` ON `service_bookings`.`user_id`=`users`.`id`
    WHERE `service_bookings`.`id`=$bookingId");
    $client=mysqli_fetch_assoc($client);

    $service=mysqli_query($db, "SELECT `services`.`service_name` FROM `service_bookings`
    INNER JOIN `worker_service_relationships` ON `service_bookings`.`worker_service_id`=`worker_service_relationships`.`id`
    INNER JOIN `services` ON `worker_service_relationships`.`service_id`=`services`.`id`
    WHERE `service_bookings`.`id`=$bookingId");
    $service=mysqli_fetch_assoc($service);

    if($newStatus=="completed"){
        $move_to_history=mysqli_query($db,"INSERT INTO `service_history` (`id`, `booking_id`, `completion_date`, `completion_time`) VALUES (NULL, '$bookingId', '$date', '$time')");
        $body="
        <p>Здравствуйте, ".$client['name']."</p>
        <p>Услуга ".$service['service_name']." выполнена!</p>
        <p>Приезжайте за автомобилем в удобное для Вас время!</p>
        <p>Спасибо за выбор автосервиса!</p>
        <p>С уважением AutoAce!</p>
    ";
        var_dump(send_mail($settings['mail_settings'], [$client['email']], 'Статус выполнения изменен!', $body));
    }else if($newStatus=="pending"){
        $delete_from_history=mysqli_query($db,"DELETE FROM `service_history` WHERE `booking_id`=$bookingId");
    }else if($newStatus=="confirmed"){
        $delete_from_history=mysqli_query($db,"DELETE FROM `service_history` WHERE `booking_id`=$bookingId");
        $body="
        <p>Здравствуйте, ".$client['name']."</p>
        <p>Мы начали выполнение услуги ".$service['service_name'].".</p>
        <p>Как только работы будут завершены, мы обязательно Вам сообщим!</p>
        <p>Спасибо за выбор автосервиса!</p>
        <p>С уважением AutoAce!</p>
    ";
        var_dump(send_mail($settings['mail_settings'], [$client['email']], 'Статус выполнения изменен!', $body));
    }
    $update_status=mysqli_query($db,"UPDATE `service_bookings` SET `status`='$newStatus' WHERE `id`=$bookingId");
?>