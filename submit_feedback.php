<?php

require_once 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);

    if(strlen($fullname) < 4){
        die("Error: Full name must be at least 4 characters.");
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        die("Error: Invalid email format.");
    }

    if(empty($category)){
        die("Error: Please select feedback category.");
    }

    if(strlen($description) < 10){
        die("Error: Description must be at least 10 characters.");
    }

    if(!isset($_FILES['feedback_image']) || $_FILES['feedback_image']['error'] != 0){
        die("Error: Image upload is required.");
    }

    $target_dir = "uploads/";

    if(!is_dir($target_dir)){
        mkdir($target_dir, 0777, true);
    }

    $file_name = time() . "_" . basename($_FILES["feedback_image"]["name"]);
    $target_file = $target_dir . $file_name;

    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed = ["jpg","jpeg","png"];

    if(!in_array($file_type, $allowed)){
        die("Error: Only JPG, JPEG and PNG files are allowed.");
    }

    if($_FILES["feedback_image"]["size"] > 2 * 1024 * 1024){
        die("Error: Image size must be less than 2MB.");
    }

    if(move_uploaded_file($_FILES["feedback_image"]["tmp_name"], $target_file)){

        $fullname = mysqli_real_escape_string($conn, $fullname);
        $email = mysqli_real_escape_string($conn, $email);
        $category = mysqli_real_escape_string($conn, $category);
        $description = mysqli_real_escape_string($conn, $description);
        $image_path = mysqli_real_escape_string($conn, $target_file);

        $sql = "
        INSERT INTO feedback
        (fullname,email,category,description,image_path)
        VALUES
        ('$fullname','$email','$category','$description','$image_path')
        ";

        if(mysqli_query($conn,$sql)){
            header("Location: feedback_page.php");
            exit();
        }else{
            echo "Database error.";
        }

    }else{
        echo "Image upload failed.";
    }
}

?>