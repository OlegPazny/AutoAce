<?php
    require_once "db_connect.php";

    $workshopId = $_POST['workshop_id'];
    $delete_workshop=mysqli_query($db, "DELETE FROM `workshops` WHERE `id`=$workshopId");
?>