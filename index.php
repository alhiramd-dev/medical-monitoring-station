<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

require_once 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Med Station Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body{
    background:linear-gradient(135deg,#ffe6f7,#f3e8ff,#ead7ff);
    font-family:Arial, sans-serif;
    min-height:100vh;
}

.main-box{
    background:white;
    border-radius:30px;
    padding:30px;
    box-shadow:0 10px 30px rgba(160,80,180,0.18);
}

.nav-btn{
    background:#c084fc;
    color:white;
    border-radius:15px;
    padding:10px 18px;
    text-decoration:none;
    margin:5px;
    display:inline-block;
}

.nav-btn:hover{
    background:#a855f7;
    color:white;
}

.sensor-card{
    border-radius:25px;
    padding:22px;
    color:white;
    text-align:center;
    box-shadow:0 8px 20px rgba(0,0,0,0.12);
    min-height:220px;
}

.sensor-card h5{
    font-size:1.4rem;
}

.sensor-card h2{
    font-size:2.6rem;
    font-weight:bold;
}

.sensor-desc{
    background:rgba(255,255,255,0.25);
    border-radius:15px;
    padding:10px;
    margin-top:12px;
    font-size:0.9rem;
}

.sensor-desc b{
    display:block;
}

.pink{background:#f472b6;}
.purple{background:#a78bfa;}
.blue{background:#7dd3fc;}
.green{background:#86efac;}
.orange{background:#fdba74;}

.panel{
    background:white;
    border-radius:25px;
    padding:25px;
    box-shadow:0 8px 22px rgba(160,80,180,0.15);
}

.info-card{
    background:white;
    border-radius:25px;
    padding:20px;
    height:100%;
    box-shadow:0 8px 22px rgba(160,80,180,0.12);
    border-left:8px solid #c084fc;
}

.info-card h5{
    color:#7e22ce;
    font-weight:bold;
}

.table thead th{
    background:#e9d5ff;
    color:#6b21a8;
}

.small-note{
    font-size:0.9rem;
    color:#6b21a8;
}
</style>
</head>

<body>

<div class="container py-4">

    <div class="main-box text-center mb-4">
        <h1>💜 Smart Medical Monitoring Station 💜</h1>
        <p>
            Welcome, <?php echo $_SESSION['fullname']; ?> |
            Patient ID: <?php echo $_SESSION['patient_id']; ?>
        </p>

        <a class="nav-btn" href="index.php">Dashboard</a>
        <a class="nav-btn" href="records.php">Sensor Records</a>
        <a class="nav-btn" href="feedback_page.php">Feedback</a>
        <a class="nav-btn" href="logout.php">Logout</a>
    </div>

    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="sensor-card pink">
                <h5>❤️ Heart Rate</h5>
                <div id="bpm-value">Loading...</div>

                <div class="sensor-desc">
                    <b>Sensor: MAX30100</b>
                    Measures patient heart rate in beats per minute (BPM).
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="sensor-card purple">
                <h5>🩸 SpO₂</h5>
                <div id="spo2-value">Loading...</div>

                <div class="sensor-desc">
                    <b>Sensor: MAX30100</b>
                    Measures blood oxygen saturation level in percentage (%).
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="sensor-card blue">
                <h5>🌡 Body Temperature</h5>
                <div id="bodytemp-value">Loading...</div>

                <div class="sensor-desc">
                    <b>Sensor: DS18B20</b>
                    Measures body temperature in degree Celsius (°C).
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="sensor-card green">
                <h5>🏠 Room Temperature</h5>
                <div id="roomtemp-value">Loading...</div>

                <div class="sensor-desc">
                    <b>Sensor: BME280</b>
                    Measures surrounding room temperature in degree Celsius (°C).
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="sensor-card orange">
                <h5>💧 Room Humidity</h5>
                <div id="humidity-value">Loading...</div>

                <div class="sensor-desc">
                    <b>Sensor: BME280</b>
                    Measures surrounding air humidity in percentage (%RH).
                </div>
            </div>
        </div>

    </div>

    <div class="panel mb-4">
        <h3>🔎 Sensor Information</h3>
        <p class="small-note">
            This section explains the sensor modules used in the IoT health monitoring system.
            These descriptions support sensor data labels, units and function identification.
        </p>

        <div class="row g-3 mt-2">

            <div class="col-md-3">
                <div class="info-card">
                    <h5>MAX30100</h5>
                    <p>
                        Used to measure heart rate and SpO₂. It supports non-invasive pulse and oxygen monitoring.
                    </p>
                    <b>Parameters:</b>
                    BPM, SpO₂ (%)
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-card">
                    <h5>DS18B20</h5>
                    <p>
                        Used to measure patient body temperature. A calibration offset is applied for skin temperature reading.
                    </p>
                    <b>Parameter:</b>
                    Body Temperature (°C)
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-card">
                    <h5>BME280</h5>
                    <p>
                        Used to measure surrounding environmental condition including room temperature and humidity.
                    </p>
                    <b>Parameters:</b>
                    Room Temp (°C), Humidity (%RH)
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-card">
                    <h5>AD8232 ECG</h5>
                    <p>
                        Used to monitor electrical activity of the heart and display ECG signal waveform in real time.
                    </p>
                    <b>Parameter:</b>
                    ECG Analog Value
                </div>
            </div>

        </div>
    </div>

    <div class="row g-4">

        <div class="col-lg-7">
            <div class="panel">
                <h4>📈 Live Sensor Trend Graph</h4>
                <p class="small-note">
                    This graph displays heart rate, body temperature, room temperature and humidity trends.
                    The data refreshes automatically every 5 seconds.
                </p>
                <canvas id="sensorChart"></canvas>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="panel">
                <h4>💓 ECG Live Graph</h4>
                <p class="small-note">
                    Sensor: AD8232 ECG Module. This graph shows real-time ECG analog signal values from the patient.
                </p>
                <canvas id="ecgChart"></canvas>
            </div>
        </div>

    </div>

</div>

<script>
function loadCards(){
    $("#bpm-value").load("bpm.php");
    $("#spo2-value").load("spo2.php");
    $("#bodytemp-value").load("body_temp.php");
    $("#roomtemp-value").load("room_temp.php");
    $("#humidity-value").load("humidity.php");
}

const sensorChart = new Chart(document.getElementById('sensorChart'),{
    type:'line',
    data:{
        labels:[],
        datasets:[
            {
                label:'Heart Rate (BPM)',
                data:[],
                borderColor:'#ec4899',
                backgroundColor:'rgba(236,72,153,0.15)',
                tension:0.3
            },
            {
                label:'Body Temperature (°C)',
                data:[],
                borderColor:'#8b5cf6',
                backgroundColor:'rgba(139,92,246,0.15)',
                tension:0.3
            },
            {
                label:'Room Temperature (°C)',
                data:[],
                borderColor:'#38bdf8',
                backgroundColor:'rgba(56,189,248,0.15)',
                tension:0.3
            },
            {
                label:'Humidity (%RH)',
                data:[],
                borderColor:'#fb923c',
                backgroundColor:'rgba(251,146,60,0.15)',
                tension:0.3
            }
        ]
    },
    options:{
        responsive:true,
        plugins:{
            legend:{
                position:'top'
            }
        }
    }
});

const ecgChart = new Chart(document.getElementById('ecgChart'),{
    type:'line',
    data:{
        labels:[],
        datasets:[
            {
                label:'ECG Analog Value (AD8232)',
                data:[],
                borderColor:'#ef4444',
                backgroundColor:'rgba(239,68,68,0.15)',
                tension:0.2
            }
        ]
    },
    options:{
        responsive:true,
        plugins:{
            legend:{
                position:'top'
            }
        }
    }
});

function loadChart(){
    fetch("chart_data.php")
    .then(res=>res.json())
    .then(data=>{
        sensorChart.data.labels=[];
        ecgChart.data.labels=[];

        for(let i=0;i<4;i++){
            sensorChart.data.datasets[i].data=[];
        }

        ecgChart.data.datasets[0].data=[];

        data.forEach(row=>{
            sensorChart.data.labels.push(row.time);

            sensorChart.data.datasets[0].data.push(row.bpm);
            sensorChart.data.datasets[1].data.push(row.body_temp);
            sensorChart.data.datasets[2].data.push(row.room_temp);
            sensorChart.data.datasets[3].data.push(row.humidity);

            ecgChart.data.labels.push(row.time);
            ecgChart.data.datasets[0].data.push(row.ecg);
        });

        sensorChart.update();
        ecgChart.update();
    });
}

loadCards();
loadChart();

setInterval(function(){
    loadCards();
    loadChart();
},5000);
</script>

</body>
</html>