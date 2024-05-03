<?php
    session_start();
    $isAdmin=false;
    $isClient=false;
    $isWorker=false;
    $isMechanic=false;
    if(isset($_SESSION["user"]["role"])){
        if ($_SESSION["user"]["role"] == "admin") {
            $isAdmin = true;
        } else if ($_SESSION["user"]["role"] == "client") {
            $isClient = true;
        } else if ($_SESSION["user"]["role"] == "worker") {
            $isWorker = true;
        } else if ($_SESSION["user"]["role"] == "mechanic") {
            $isMechanic = true;
        }
    }
?>