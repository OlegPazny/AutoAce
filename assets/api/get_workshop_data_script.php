<?php
session_start();
require_once "db_connect.php";

if (isset($_SESSION['workshop_id'])) {
    $workshop_id = $_SESSION['workshop_id'];

    $workshop_data=mysqli_query($db, "SELECT * FROM `workshops` WHERE `id`=$workshop_id");
    $workshop_data=mysqli_fetch_assoc($workshop_data);

    $worker_services_data = mysqli_query($db, "SELECT
                                                service_id,
                                                service_name,
                                                service_type,
                                                service_duration,
                                                service_discount,
                                                workshop_id,
                                                workshop_name
                                            FROM (
                                                SELECT
                                                    s.id AS service_id,
                                                    s.service_name AS service_name,
                                                    st.type AS service_type,
                                                    s.duration AS service_duration,
                                                    s.discount AS service_discount,
                                                    ws.id AS workshop_id,
                                                    ws.name AS workshop_name,
                                                    COUNT(s.id) OVER (PARTITION BY st.id) AS service_count
                                                FROM workers w
                                                INNER JOIN worker_service_relationships wsr ON w.id = wsr.worker_id
                                                INNER JOIN services s ON wsr.service_id = s.id
                                                INNER JOIN service_type st ON s.id_service_type = st.id
                                                INNER JOIN workshops ws ON w.workshop_id = ws.id
                                                WHERE w.workshop_id = $workshop_id
                                            ) AS ServiceCounts
                                            ORDER BY service_count DESC, service_type, service_name;");
    $services_data = mysqli_fetch_all($worker_services_data);
    $services_arr=[];
    foreach($services_data as $service_data){
        $service_type=$service_data[2];
        $service_id=$service_data[0];
        $service_name=$service_data[1];
        $service_price=$service_data[3];
        if(!in_array($service_type, $services_arr)){
            $services_arr[$service_type][]=array(
                'id'=>$service_id,
                'name'=>$service_name,
                'price'=>$service_price
            );
        }
    }
} else {
    die("Данные не переданы");
}

?>