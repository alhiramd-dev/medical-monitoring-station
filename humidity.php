<?php

require_once 'db.php';

$sql = mysqli_query($conn,
"SELECT humidity
FROM sensor_data
ORDER BY id DESC
LIMIT 1");

$humidity = 0;

if($row=mysqli_fetch_assoc($sql)){
    $humidity = $row['humidity'];
}

?>

<h1><?php echo $humidity; ?> %</h1>