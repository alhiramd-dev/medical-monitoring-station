<?php

require_once 'db.php';

$sql = mysqli_query($conn,
"SELECT spo2
FROM sensor_data
ORDER BY id DESC
LIMIT 1");

$spo2 = 0;

if($row=mysqli_fetch_assoc($sql)){
    $spo2 = $row['spo2'];
}

?>

<h1><?php echo $spo2; ?> %</h1>