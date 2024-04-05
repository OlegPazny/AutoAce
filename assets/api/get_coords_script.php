<?php
    require_once "db_connect.php";

    $workshops = array();
    $result = mysqli_query($db, "SELECT * FROM `workshops`");
    while ($row = mysqli_fetch_assoc($result)) {
        $workshops[] = $row;
    }

    echo(json_encode($workshops));
?>