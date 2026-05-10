<?php 

include "../../database/config.php";

$sql = "SELECT civil_status, COUNT(id) AS total_count
FROM residents
WHERE civil_status IN ('Single', 'Married', 'Widowed', 'Separated')
GROUP BY civil_status";
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





