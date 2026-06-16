<?php

header('Content-Type: application/json');
require_once 'db.php';

$query = "
SELECT
    bpm,
    spo2,
    body_temp,
    room_temp,
    humidity,
    ecg_value,
    recorded_at
FROM sensor_data
ORDER BY id DESC
LIMIT 20
";

$result = mysqli_query($conn, $query);

$data = [];

while($row = mysqli_fetch_assoc($result))
{
    $data[] = [
        "bpm"       => floatval($row['bpm']),
        "spo2"      => floatval($row['spo2']),
        "body_temp" => floatval($row['body_temp']),
        "room_temp" => floatval($row['room_temp']),
        "humidity"  => floatval($row['humidity']),
        "ecg"       => intval($row['ecg_value']),
        "time"      => date('H:i:s', strtotime($row['recorded_at']))
    ];
}

echo json_encode(array_reverse($data));

?>