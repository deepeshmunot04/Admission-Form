<?php
session_start(); // Start the session
if (isset($_SESSION['email'])) {
    header("Location: admission.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admission";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login Page (login.php)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];

    $_SESSION['email'] = $email;

    // Check if the captcha is correct
    if ($_SESSION['captcha'] !== $captcha) {
        echo "<script>alert('Invalid credentials!');</script>";
    } else {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                echo "<script>alert('Login successful..!! Opening Admission Form'); window.location.href = 'admission.php';</script>";
            } else {
                echo "<script>alert('Invalid credentials!');</script>";
            }
        } else {
            echo "<script>alert('User does not exist!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
 /* Global Reset and Basic Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f7f7f7; /* Light background for the page */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Container for the Login Form */
.container {
    width: 100%;
    max-width: 450px;
    padding: 30px;
    background-color: #ffffff; /* White background for form */
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
    border-radius: 15px;
}

/* Form Heading */
h2 {
    text-align: center;
    font-size: 28px;
    color: #6f42c1; /* Purple color for the heading */
    margin-bottom: 30px;
}

/* Form Input Styles */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-weight: bold;
    color: #555;
    font-size: 14px;
    display: block;
    margin-bottom: 5px;
}

.form-group input {
    width: 100%;
    padding: 12px 15px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f8f9fa;
    color: #333;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
}

.form-group input:focus {
    border-color: #17a2b8; /* Cyan color when focused */
    outline: none;
    box-shadow: 0 0 5px rgba(23, 162, 184, 0.5); /* Soft cyan shadow */
}

/* Button Style */
button[type="submit"] {
    width: 100%;
    padding: 12px;
    background-color: #fd7e14; /* Orange color for the button */
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #e86c00; /* Darker orange when hovering */
}

/* Captcha Styling */
.captcha-img {
    text-align: center;
    margin-bottom: 20px;
}

.captcha-img img {
    max-width: 100px;
    height: auto;
}

/* Register Link */
.register-link {
    text-align: center;
    margin-top: 20px;
}

.register-link p {
    font-size: 14px;
    color: #333;
}

.register-link a {
    color: #e83e8c; /* Pink color for the link */
    text-decoration: none;
}

.register-link a:hover {
    text-decoration: underline; /* Underline on hover */
}

/* Success/Alert Message */
.alert {
    font-size: 14px;
    padding: 10px;
    margin-top: 20px;
    border-radius: 8px;
    color: white;
    background-color: #28a745; /* Green color for success */
}

.alert-error {
    background-color: #dc3545; /* Red background for error */
}

    </style>
</head>
<body>
 <div class="container login-container">
        <h2><b>Login</b></h2>

        <form method="POST" id="loginForm">
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
            </div>

            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
            </div>

            <div class="form-group mb-3 captcha-img">
                <label for="captcha">Captcha</label><br>
                <img src="captcha.php" alt="Captcha Image" class="img-fluid" style="max-width: 100px;">
            </div>

            <div class="form-group mb-3">
                <input type="text" name="captcha" id="captcha" class="form-control" placeholder="Enter Captcha" required>
            </div>

            <button type="submit" name="login">Login</button>
        </form>

        <!-- Success/Error Message (Example) -->
        <?php if (isset($msg)) { ?>
            <div class="alert alert-success mt-3"><?php echo $msg; ?></div>
        <?php } ?>

        <!-- Register Link -->
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Sign Up</a></p>
        </div>
    </div>

    <!-- Bootstrap JS & Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- jQuery for form validation -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
