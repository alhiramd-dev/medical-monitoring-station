<?php
session_start();
require_once 'db.php';

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' LIMIT 1");

    if($user = mysqli_fetch_assoc($sql)){
        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['patient_id'] = $user['patient_id'];
            $_SESSION['fullname'] = $user['fullname'];
            header("Location: index.php");
            exit();
        }else{
            $message = "Wrong password.";
        }
    }else{
        $message = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login - Med Station</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{background:linear-gradient(135deg,#ffe6f7,#f3e8ff);font-family:Arial;}
.box{max-width:450px;margin:80px auto;background:white;padding:30px;border-radius:25px;box-shadow:0 10px 25px rgba(0,0,0,0.1);}
.btn-purple{background:#c084fc;color:white;border:0;border-radius:15px;}
</style>
</head>
<body>
<div class="box">
<h2 class="text-center mb-3">💜 Patient Login</h2>

<?php if(isset($_GET['registered'])){ ?>
<div class="alert alert-success">Registration successful. Please login.</div>
<?php } ?>

<?php if($message!=""){ ?>
<div class="alert alert-danger"><?php echo $message; ?></div>
<?php } ?>

<form method="POST">
<input class="form-control mb-3" type="email" name="email" placeholder="Email" required>
<input class="form-control mb-3" type="password" name="password" placeholder="Password" required>
<button class="btn btn-purple w-100 py-2">Login</button>
</form>

<p class="text-center mt-3">No account? <a href="register.php">Register here</a></p>
</div>
</body>
</html>