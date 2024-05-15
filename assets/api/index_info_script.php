<?php
    require_once "db_connect.php";

    $discounts=mysqli_query($db, "SELECT DISTINCT `services`.`id`, `services`.`service_name`, `services`.`discount`
    FROM `worker_service_relationships`
    INNER JOIN `services` ON `worker_service_relationships`.`service_id`=`services`.`id`
    WHERE `services`.`discount` IS NOT NULL
    ORDER BY RAND()
    LIMIT 8 ");
    $discounts=mysqli_fetch_all($discounts);
?>