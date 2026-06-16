<?php

require_once 'db.php';

if(
    !isset($_GET['patient_id']) ||
    !isset($_GET['bpm']) ||
    !isset($_GET['spo2']) ||
    !isset($_GET['body_temp']) ||
    !isset($_GET['room_temp']) ||
    !isset($_GET['humidity']) ||
    !isset($_GET['ecg_value'])
){
    http_response_code(400);
    die("Missing parameters");
}

$patient_id = mysqli_real_escape_string($conn, $_GET['patient_id']);
$bpm = floatval($_GET['bpm']);
$spo2 = floatval($_GET['spo2']);
$body_temp = floatval($_GET['body_temp']);
$room_temp = floatval($_GET['room_temp']);
$humidity = floatval($_GET['humidity']);
$ecg_value = intval($_GET['ecg_value']);

$sql = "
INSERT INTO sensor_data
(patient_id, bpm, spo2, body_temp, room_temp, humidity, ecg_value)
VALUES
('$patient_id', '$bpm', '$spo2', '$body_temp', '$room_temp', '$humidity', '$ecg_value')
";

if(mysqli_query($conn, $sql)){
    echo "Success";
}else{
    echo "Database Error: " . mysqli_error($conn);
}

?>