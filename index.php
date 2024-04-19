<?php
    session_start();

    require_once "assets/api/isAdmin.php";

    if($isClient==true){
        header('Location: pages/index.php');
    }else if($isAdmin==true){
        header('Location: pages/admin.php');
    }else if($isWorker==true){
        header('Location: pages/moderator.php');
    }else if($isClient==false&&$isAdmin==false&&$isWorker==false){
        header('Location: pages/index.php');
    }
    
?>