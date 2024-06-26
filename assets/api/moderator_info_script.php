<?php
    require_once "db_connect.php";
//пользователи
    $users=mysqli_query($db, "SELECT * FROM `users`");
    $users=mysqli_fetch_all($users);
//работники
    $workers=mysqli_query($db, "SELECT `workers`.`id`, `workers`.`name`, `workshops`.`name`, `workers`.`login`, `workers`.`email`, `workers`.`vacation`
    FROM `workers`
    INNER JOIN `workshops` ON `workers`.`workshop_id`=`workshops`.`id`
    ");
    $workers=mysqli_fetch_all($workers);
//записи на услуги
    $accounts_books=mysqli_query($db, "SELECT `service_bookings`.`id`, `workshops`.`name`, `services`.`service_name`, `message`, `service_date`, `service_time`, `status`, `services`.`duration`, `workshops`.`standart_hour`, `services`.`discount`, `users`.`name`, `workshops`.`standart_hour`, `vehicles`.`brand`, `vehicles`.`vin`, `vehicles`.`num_plate` FROM `service_bookings`
    INNER JOIN `worker_service_relationships` ON `service_bookings`.`worker_service_id`=`worker_service_relationships`.`id`
    inner join `services` on `worker_service_relationships`.`service_id`=`services`.`id`
    INNER JOIN `workers` ON `worker_service_relationships`.`worker_id`=`workers`.`id`
    INNER JOIN `workshops` ON `workers`.`workshop_id`=`workshops`.`id`
    LEFT JOIN `users` ON `service_bookings`.`user_id`=`users`.`id`
    LEFT JOIN `vehicles` ON `service_bookings`.`vehicle_id`=`vehicles`.`id`
    ORDER BY `service_date` ASC, `service_time` ASC");
    $accounts_books=mysqli_fetch_all($accounts_books);
//история записей
    $accounts_history=mysqli_query($db, "SELECT `workers`.`name`, `services`.`service_name`, `service_bookings`.`comment`, `service_history`.`completion_date`, `service_history`.`completion_time`, `service_bookings`.`status`, `service_history`.`booking_id`, `workshops`.`name`, `services`.`duration`, `workshops`.`standart_hour`, `services`.`discount`, `users`.`name`, `service_bookings`.`total_price`, `vehicles`.`brand`, `vehicles`.`vin` FROM `service_history`
    INNER JOIN `service_bookings` ON `service_history`.`booking_id`=`service_bookings`.`id`
    INNER JOIN `vehicles` ON `service_bookings`.`vehicle_id`=`vehicles`.`id`
    INNER JOIN `worker_service_relationships` ON `service_bookings`.`worker_service_id`=`worker_service_relationships`.`id`
    inner join `services` on `worker_service_relationships`.`service_id`=`services`.`id`
    INNER JOIN `workers` ON `worker_service_relationships`.`worker_id`=`workers`.`id`
    INNER JOIN `workshops` ON `workers`.`workshop_id`=`workshops`.`id`
    INNER JOIN `users` ON `service_bookings`.`user_id` = `users`.`id`
    ORDER BY `service_history`.`completion_date` DESC");
    $accounts_history=mysqli_fetch_all($accounts_history);
//услуги
    $services=mysqli_query($db, "SELECT `services`.`id`, `service_name`, `description`, `duration`, `service_type`.`type`, `discount` FROM `services`
    INNER JOIN `service_type` ON `services`.`id_service_type`=`service_type`.`id`");
    $services=mysqli_fetch_all($services);
//автосервисы
    $workshops=mysqli_query($db, "SELECT * FROM `workshops`");
    $workshops=mysqli_fetch_all($workshops);
//типы услуг
    $services_types=mysqli_query($db, "SELECT * FROM `service_type`");
    $services_types=mysqli_fetch_all($services_types);
//отношения работник-услуга
    $worker_services=mysqli_query($db, "SELECT `worker_service_relationships`.`id`, `workers`.`name`, `services`.`service_name`, `workshops`.`name` FROM `worker_service_relationships`
    INNER JOIN `workers` ON `worker_service_relationships`.`worker_id`=`workers`.`id`
    INNER JOIN `services` ON `worker_service_relationships`.`service_id`=`services`.`id`
    INNER JOIN `workshops` ON `workers`.`workshop_id`=`workshops`.`id`
    ORDER BY `workers`.`name` DESC");
    $worker_services=mysqli_fetch_all($worker_services);


?>