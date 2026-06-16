<?php

require_once 'db.php';

$sql = mysqli_query($conn,
"SELECT body_temp
FROM sensor_data
ORDER BY id DESC
LIMIT 1");

$temp = 0;

if($row=mysqli_fetch_assoc($sql)){
    $temp = $row['body_temp'];
}

?>

<h1><?php echo $temp; ?> °C</h1>