<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
require_once 'db.php';
$records = mysqli_query($conn, "SELECT * FROM sensor_data ORDER BY id DESC LIMIT 30");
?>
<!DOCTYPE html>
<html>
<head>
<title>Sensor Records</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{background:linear-gradient(135deg,#ffe6f7,#f3e8ff);font-family:Arial;}
.box{background:white;border-radius:25px;padding:25px;margin:30px auto;box-shadow:0 10px 25px rgba(0,0,0,0.1);}
.nav-btn{background:#c084fc;color:white;border-radius:15px;padding:10px 18px;text-decoration:none;margin:5px;display:inline-block;}
.table thead th{background:#e9d5ff;color:#6b21a8;}
</style>
</head>
<body>
<div class="container">
<div class="box">
<h2>📊 Sensor Database Records</h2>
<a class="nav-btn" href="index.php">Dashboard</a>
<a class="nav-btn" href="feedback_page.php">Feedback</a>
<a class="nav-btn" href="logout.php">Logout</a>

<div class="table-responsive mt-3">
<table class="table table-bordered">
<thead>
<tr>
<th>ID</th><th>Patient ID</th><th>BPM</th><th>SpO₂</th><th>Body Temp</th><th>Room Temp</th><th>Humidity</th><th>ECG</th><th>Time</th>
</tr>
</thead>
<tbody>
<?php while($r=mysqli_fetch_assoc($records)){ ?>
<tr>
<td><?php echo $r['id']; ?></td>
<td><?php echo $r['patient_id']; ?></td>
<td><?php echo $r['bpm']; ?></td>
<td><?php echo $r['spo2']; ?></td>
<td><?php echo $r['body_temp']; ?> °C</td>
<td><?php echo $r['room_temp']; ?> °C</td>
<td><?php echo $r['humidity']; ?> %</td>
<td><?php echo $r['ecg_value']; ?></td>
<td><?php echo $r['recorded_at']; ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</body>
</html>