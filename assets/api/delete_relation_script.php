<?php
    require_once "db_connect.php";

    $relationId = $_POST['relation_id'];
    $query="DELETE FROM `worker_service_relationships` WHERE `id`=$relationId";

    if(mysqli_query($db, $query)){
        echo json_encode([
            'success' => true,
            'message' => 'Услуга успешно удалена.'
        ]);
    }else{
        echo json_encode([
            'success' => false,
            'message' => 'Ошибка при удалении услуги.'
        ]);
    }
?>