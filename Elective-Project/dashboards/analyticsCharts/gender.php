<?php 

include "../../database/config.php";

$sql = "SELECT gender, COUNT(id) as gender_count 
FROM residents 
GROUP BY gender";
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





