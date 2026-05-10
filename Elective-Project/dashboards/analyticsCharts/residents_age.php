<?php 

include "../../database/config.php";

$sql = "SELECT 
            CASE 
                WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 0 AND 12 THEN '0-12'
                WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 13 AND 17 THEN '13-17'
                WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 18 AND 35 THEN '18-35'
                WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 36 AND 59 THEN '36-59'
                WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) >= 60 THEN '60+'
            END AS age_group,
            COUNT(id) AS resident_count
        FROM residents
        WHERE date_of_birth IS NOT NULL
        GROUP BY age_group";
$result = mysqli_query($conn, $sql);

$data = array();

if($result && mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

mysqli_close($conn);

echo json_encode($data);

?>





