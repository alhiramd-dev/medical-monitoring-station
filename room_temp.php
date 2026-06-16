<?php

require_once 'db.php';

$sql = mysqli_query($conn, "
SELECT room_temp
FROM sensor_data
ORDER BY id DESC
LIMIT 1
");

$row = mysqli_fetch_assoc($sql);

echo "<h2>".$row['room_temp']." °C</h2>";

?>