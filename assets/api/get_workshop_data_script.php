<?php
require_once "db_connect.php";

if (isset($_GET['id'])) {
    $workshop_id = $_GET['id'];

    $workshop_services_data = mysqli_query($db, "SELECT st.type AS service_type, s.id AS service_id, s.service_name AS service_name 
        FROM workshops w 
        JOIN service_workshop_relationships swr ON w.id = swr.workshop_id 
        JOIN services s ON swr.service_id = s.id 
        JOIN service_type st ON s.id_service_type = st.id 
        WHERE w.id = $workshop_id;");
    $services_data = mysqli_fetch_all($workshop_services_data);

    $services_arr=[];
    foreach($services_data as $service_data){
        $service_type=$service_data[0];
        $service_id=$service_data[1];
        $service_name=$service_data[2];
        if(!in_array($service_type, $services_arr)){
            $services_arr[$service_type][]=array(
                'id'=>$service_id,
                'name'=>$service_name
            );
        }
    }
    $workshop=array();
    $workshop_location=mysqli_query($db, "SELECT * FROM `workshops` WHERE `id`=$workshop_id;");
    while ($row = mysqli_fetch_assoc($workshop_location)) {
        $workshop[] = $row;
    }
    echo json_encode($workshop, JSON_UNESCAPED_UNICODE);
} else {
    die("Данные не переданы");
}

?>