<?php
    require_once "db_connect.php";
    require_once "mail_client_connect.php";

    $get_bookings=mysqli_query($db, "SELECT `services`.`service_name`, `workers`.`name`, `users`.`name`, `users`.`email`, `service_bookings`.`service_date`, `service_bookings`.`service_time`, `workshops`.`name`, `workshops`.`address`
    FROM `service_bookings`
    INNER JOIN `users` ON `service_bookings`.`user_id`=`users`.`id`
    INNER JOIN `worker_service_relationships` ON `service_bookings`.`worker_service_id`=`worker_service_relationships`.`id`
    INNER JOIN `services` ON `worker_service_relationships`.`service_id`=`services`.`id`
    INNER JOIN `workers` ON `worker_service_relationships`.`worker_id`=`workers`.`id`
    INNER JOIN `workshops` ON `workers`.`workshop_id`=`workshops`.`id`
    WHERE `service_bookings`.`status`='pending'
    ");
    $bookings=mysqli_fetch_all($get_bookings);

    $today=date("Y-m-d");
    $delayDate=date("Y-m-d", strtotime("+ 1 day"));

    foreach($bookings as $book){
        //если запись уже прошла пропускаем ее
        if(strtotime($book[4])<=strtotime($today)){
            continue;
        }
        //если запись завтра
        if($book[4]==$delayDate){
            //убираем секунды
            $formatted_time=substr($book[5], 0, -3);
            $body="
                <p>Здравствуйте, ".$book[2]."!</p>
                <p>Напоминаем, что у Вас завтра, в ".$formatted_time.", запись на услугу \"".$book[0]."\".</p>
                <p>Работы будет выполнять ".$book[1]." в ".$book[6].", который расположен по адресу: ".$book[7]."</p>
                <p>Ждем Вас!</p>
            ";

            send_mail($settings['mail_settings'], [$book[3]], 'Вы записаны на услугу!', $body);
        }
    }

?>