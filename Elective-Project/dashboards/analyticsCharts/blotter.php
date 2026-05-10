<?php 

include "../../database/config.php";

$sql = "SELECT 
    s.status,
    COUNT(b.id) AS total_count
FROM (
    SELECT 'Pending' AS status
    UNION ALL SELECT 'Under Investigation'
    UNION ALL SELECT 'Settled'
    UNION ALL SELECT 'Referred to Court'
) s
LEFT JOIN blotter_records b ON b.status = s.status
GROUP BY s.status
ORDER BY FIELD(s.status, 'Pending', 'Under Investigation', 'Settled', 'Referred to Court')";
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





