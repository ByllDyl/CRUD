<?php 

include "../../database/config.php";

$sql = "SELECT purok_no, COUNT(id) as resident_count 
FROM residents 
GROUP BY purok_no 
ORDER BY purok_no ASC";
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





