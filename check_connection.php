<?php

header('Content-Type: application/json');

require_once 'db.php';

$status = [
    "database" => "ONLINE",
    "timestamp" => date('H:i:s')
];

echo json_encode($status);

?>