<?php
    require_once "db_connect.php";

    $serviceNameRelation = $_POST['service_name_relation'];
    $workshopNameRelation = $_POST['workshop_name_relation'];

    $add_relation=mysqli_query($db, "INSERT INTO `service_workshop_relationships` (`service_id`, `workshop_id`)
    SELECT * FROM (SELECT $serviceNameRelation, $workshopNameRelation) AS tmp
    WHERE NOT EXISTS (
        SELECT * FROM `service_workshop_relationships`
        WHERE `service_id` = $serviceNameRelation AND `workshop_id` = $workshopNameRelation
    ) LIMIT 1;");
?>