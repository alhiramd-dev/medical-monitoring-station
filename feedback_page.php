<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

require_once 'db.php';
$feedbacks = mysqli_query($conn, "SELECT * FROM feedback ORDER BY submitted_at DESC LIMIT 10");
?>

<!DOCTYPE html>
<html>
<head>
<title>Feedback</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:linear-gradient(135deg,#ffe6f7,#f3e8ff);
    font-family:Arial;
}
.box{
    background:white;
    border-radius:25px;
    padding:25px;
    margin:30px auto;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
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
.btn-cute{
    background:#ec4899;
    color:white;
    border:0;
    border-radius:15px;
    padding:10px;
}
.table thead th{
    background:#e9d5ff;
    color:#6b21a8;
}
</style>
</head>

<body>

<div class="container">

<div class="box">
<h2>📝 Stakeholder Feedback</h2>

<a class="nav-btn" href="index.php">Dashboard</a>
<a class="nav-btn" href="records.php">Sensor Records</a>
<a class="nav-btn" href="logout.php">Logout</a>

<form class="mt-3" action="submit_feedback.php" method="POST" enctype="multipart/form-data" onsubmit="return validateFeedbackForm()">

<input class="form-control mb-3" type="text" name="fullname" id="fullname" placeholder="Full Name">

<input class="form-control mb-3" type="email" name="email" id="email" placeholder="Email">

<select class="form-select mb-3" name="category" id="category">
<option value="">Select Feedback Category</option>
<option value="Sensor Performance">Sensor Performance</option>
<option value="Dashboard Interface">Dashboard Interface</option>
<option value="System Usability">System Usability</option>
<option value="Real-Time Update">Real-Time Update</option>
</select>

<textarea class="form-control mb-3" name="description" id="description" rows="4" placeholder="Detailed feedback"></textarea>

<input class="form-control mb-3" type="file" name="feedback_image" id="feedback_image" accept=".jpg,.jpeg,.png">

<button class="btn btn-cute w-100">Submit Feedback</button>

</form>
</div>

<div class="box">
<h3>📋 Latest Feedback Records</h3>

<div class="table-responsive">
<table class="table table-bordered">
<thead>
<tr>
<th>Time</th>
<th>Name</th>
<th>Email</th>
<th>Category</th>
<th>Description</th>
<th>Image</th>
</tr>
</thead>

<tbody>
<?php while($fb=mysqli_fetch_assoc($feedbacks)){ ?>
<tr>
<td><?php echo $fb['submitted_at']; ?></td>
<td><?php echo htmlspecialchars($fb['fullname']); ?></td>
<td><?php echo htmlspecialchars($fb['email']); ?></td>
<td><?php echo htmlspecialchars($fb['category']); ?></td>
<td><?php echo htmlspecialchars($fb['description']); ?></td>
<td>
<?php if(!empty($fb['image_path'])){ ?>
<a href="<?php echo $fb['image_path']; ?>" target="_blank">View</a>
<?php } else { echo "-"; } ?>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>

</div>
</div>

<script>
function validateFeedbackForm(){

    let fullname = document.getElementById("fullname").value.trim();
    let email = document.getElementById("email").value.trim();
    let category = document.getElementById("category").value;
    let description = document.getElementById("description").value.trim();
    let image = document.getElementById("feedback_image");
    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if(fullname.length < 4){
        alert("Full name must be at least 4 characters.");
        return false;
    }

    if(!emailPattern.test(email)){
        alert("Please enter a valid email address.");
        return false;
    }

    if(category === ""){
        alert("Please select a feedback category.");
        return false;
    }

    if(description.length < 10){
        alert("Description must be at least 10 characters.");
        return false;
    }

    if(image.files.length === 0){
        alert("Please upload an image file.");
        return false;
    }

    let file = image.files[0];
    let allowedTypes = ["image/jpeg","image/jpg","image/png"];

    if(!allowedTypes.includes(file.type)){
        alert("Only JPG, JPEG and PNG images are allowed.");
        return false;
    }

    if(file.size > 2 * 1024 * 1024){
        alert("Image size must be less than 2MB.");
        return false;
    }

    return true;
}
</script>

</body>
</html>