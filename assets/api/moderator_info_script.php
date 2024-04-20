<?php
    require_once "db_connect.php";

    $users=mysqli_query($db, "SELECT * FROM `users`");
    $users=mysqli_fetch_all($users);
//записи на услуги
    $accounts_books=mysqli_query($db, "SELECT `service_bookings`.`id`, `workshops`.`name`, `services`.`service_name`, `message`, `service_date`, `service_time`, `status`, `services`.`price` FROM `service_bookings`
    INNER JOIN `workshops` ON `service_bookings`.`workshop_id`=`workshops`.`id`
    inner join `services` on `service_bookings`.`service_id`=`services`.`id`
    ORDER BY `service_date` ASC, `service_time` ASC");
    $accounts_books=mysqli_fetch_all($accounts_books);
//история записей
    $accounts_history=mysqli_query($db, "SELECT `workshops`.`name`, `services`.`service_name`, `service_bookings`.`message`, `service_history`.`completion_date`, `service_history`.`completion_time`, `service_bookings`.`status`, `service_history`.`booking_id` FROM `service_history`
    INNER JOIN `service_bookings` ON `service_history`.`booking_id` = `service_bookings`.`id`
    INNER JOIN `services` ON `service_bookings`.`service_id` = `services`.`id`
    INNER JOIN `users` ON `service_bookings`.`user_id` = `users`.`id`
    INNER JOIN `workshops` ON `service_bookings`.`workshop_id`=`workshops`.`id`;");
    $accounts_history=mysqli_fetch_all($accounts_history);
//услуги
    $services=mysqli_query($db, "SELECT `services`.`id`, `service_name`, `description`, `price`, `service_type`.`type`, `discount` FROM `services`
    INNER JOIN `service_type` ON `services`.`id_service_type`=`service_type`.`id`");
    $services=mysqli_fetch_all($services);
//автосервисы
    $workshops=mysqli_query($db, "SELECT * FROM `workshops`");
    $workshops=mysqli_fetch_all($workshops);
//типы услуг
    $services_types=mysqli_query($db, "SELECT * FROM `service_type`");
    $services_types=mysqli_fetch_all($services_types);
//отношения сервис-услуга
    $relationships=mysqli_query($db, "SELECT `service_workshop_relationships`.`id`, `workshops`.`name`, `services`.`service_name` FROM `service_workshop_relationships`
    INNER JOIN `workshops` ON `service_workshop_relationships`.`workshop_id`=`workshops`.`id`
    INNER JOIN `services` ON `service_workshop_relationships`.`service_id`=`services`.`id`
    ORDER BY `workshops`.`name` DESC");
    $relationships=mysqli_fetch_all($relationships);




?>