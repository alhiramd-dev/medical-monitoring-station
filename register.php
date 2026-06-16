<?php
require_once 'db.php';

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $patient_id = mysqli_real_escape_string($conn, $_POST['patient_id']);
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $age = intval($_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (patient_id, fullname, email, password, age, gender)
            VALUES ('$patient_id','$fullname','$email','$password','$age','$gender')";

    if(mysqli_query($conn, $sql)){
        header("Location: login.php?registered=1");
        exit();
    }else{
        $message = "Email already registered or database error.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register - Med Station</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{background:linear-gradient(135deg,#ffe6f7,#f3e8ff);font-family:Arial;}
.box{max-width:500px;margin:60px auto;background:white;padding:30px;border-radius:25px;box-shadow:0 10px 25px rgba(0,0,0,0.1);}
.btn-purple{background:#c084fc;color:white;border:0;border-radius:15px;}
</style>
</head>
<body>
<div class="box">
<h2 class="text-center mb-3">💜 Patient Register</h2>

<?php if($message!=""){ ?>
<div class="alert alert-danger"><?php echo $message; ?></div>
<?php } ?>

<form method="POST">
<input class="form-control mb-3" type="text" name="patient_id" placeholder="Patient ID e.g. P001" required>
<input class="form-control mb-3" type="text" name="fullname" placeholder="Full Name" required>
<input class="form-control mb-3" type="email" name="email" placeholder="Email" required>
<input class="form-control mb-3" type="number" name="age" placeholder="Age" required>

<select class="form-select mb-3" name="gender" required>
<option value="">Select Gender</option>
<option>Female</option>
<option>Male</option>
</select>

<input class="form-control mb-3" type="password" name="password" placeholder="Password" required>

<button class="btn btn-purple w-100 py-2">Register</button>
</form>

<p class="text-center mt-3">Already have account? <a href="login.php">Login</a></p>
</div>
</body>
</html>