<?php
    require_once "db_connect.php";

    $relationId = $_POST['relation_id'];
    $delete_relation=mysqli_query($db, "DELETE FROM `service_workshop_relationships` WHERE `id`=$relationId");
?>