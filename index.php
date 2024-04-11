<?php
    session_start();

    require_once "assets/api/isAdmin.php";

    if($isAdmin==true||$isClient==true||$isWorker==true){
        header('Location: pages/index.php');
    }
?>