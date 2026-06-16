<?php

require_once 'db.php';

$sql = mysqli_query($conn,
"SELECT bpm
FROM sensor_data
ORDER BY id DESC
LIMIT 1");

$bpm = 0;

if($row=mysqli_fetch_assoc($sql)){
    $bpm = $row['bpm'];
}

?>

<h1><?php echo $bpm; ?> BPM</h1>