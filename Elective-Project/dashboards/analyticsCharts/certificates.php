<?php 

include "../../database/config.php";

$sql = "SELECT certificate_type, COUNT(id) AS total_count
FROM certificates
WHERE certificate_type IN ('Barangay Clearance', 'Certificate of Indigency', 'Certificate of Residency', 'Business Permit Clearance')
GROUP BY certificate_type";

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





