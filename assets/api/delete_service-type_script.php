<?php
    require_once "db_connect.php";

    $serviceTypeId = $_POST['service_type_id'];
    $query="DELETE FROM `service_type` WHERE `id`=$serviceTypeId";

    if(mysqli_query($db, $query)){
        echo json_encode([
            'success' => true,
            'message' => 'Тип услуги успешно удален.'
        ]);
    }else{
        echo json_encode([
            'success' => false,
            'message' => 'Ошибка при удалении типа услуги.'
        ]);
    }
?>