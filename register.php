<?php

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admission";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Registration Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $fullname = $fname . ' ' . $mname . ' ' . $lname;
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        $photo = $_FILES['photo'];

        if ($photo['size'] > 1048576) {
            echo "<script>alert('File size should be under 1MB!');</script>";
        } else {
            $allowed = ['jpeg', 'jpg', 'png'];
            $file_ext = pathinfo($photo['name'], PATHINFO_EXTENSION);

            if (!in_array(strtolower($file_ext), $allowed)) {
                echo "<script>alert('Invalid file format!');</script>";
            } else {
                $photo_name = uniqid() . '.' . $file_ext;
                move_uploaded_file($photo['tmp_name'], "uploads/$photo_name");

                $hashed_password = password_hash($password, PASSWORD_BCRYPT);


                $sql = $conn->prepare("INSERT INTO users (first_name, middle_name, last_name, full_name, mobile_number, photo, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $sql->bind_param("ssssssss", $fname, $mname, $lname, $fullname, $mobile,$photo_name, $email, $hashed_password);
                if ($sql->execute()) {
                    echo "<script>alert('Registration successful..!!'); window.location.href = 'login.php';</script>";
                } else {
                    echo "<script>alert('Error occurred. Please try again.');</script>";
                }

            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
/* Global Body Styles */
body {
    background: linear-gradient(135deg, #f0f4f8, #e0e7ff);
    font-family: 'Poppins', sans-serif;
    color: #333;
    margin: 0;
    padding: 0;
}

/* Navbar Styles */
.navbar {
    background: linear-gradient(135deg, rgb(59, 191, 99), #2e5bbf);
    padding: 0.8rem 1.5rem;
    position: sticky;
    top: 0;
    z-index: 1000;
    transition: background 0.3s ease;
}

.navbar:hover {
    background: linear-gradient(135deg, #ff7f50, #6a1b9a); /* Orange to Purple gradient */
}

.navbar-brand {
    color: #fff;
    font-size: 1.6rem;
    font-weight: bold;
    text-decoration: none;
    transition: color 0.3s ease;
}

.navbar-brand:hover {
    color: #f3f4f6;
}

.navbar-toggler {
    border: none;
    outline: none;
}

.navbar-toggler-icon {
    background-color: #fff;
}

.navbar-nav {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    flex-grow: 1;
}

.nav-item {
    padding: 0.4rem 1rem;
}

.nav-link {
    color: #fff;
    font-size: 1.1rem;
    text-transform: uppercase;
    font-weight: bold;
    letter-spacing: 0.8px;
    transition: color 0.3s ease;
}

.nav-link:hover {
    color: #f1f5f9;
    text-decoration: none;
}

@media (max-width: 991px) {
    .navbar-nav {
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
        padding: 0.8rem;
    }

    .nav-item {
        width: 100%;
        text-align: left;
    }

    .nav-link {
        padding: 0.6rem 1.2rem;
        font-size: 1.2rem;
    }
}

/* Register Form Styles */
.register-container {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    padding: 30px;
    max-width: 500px;
    margin: 50px auto;
    transition: transform 0.3s ease-in-out;
}

.register-container:hover {
    transform: scale(1.02);
}

h2 {
    text-align: center;
    font-weight: 600;
    margin-bottom: 20px;
    color: #9c27b0; /* Purple for the heading */
    font-size: 1.8rem;
}

.form-floating label {
    font-size: 1rem;
    color: #444;
}

.form-control {
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    font-size: 1rem;
    padding: 1rem;
}

.form-control:focus {
    border-color: #ff7043; /* Orange color on focus */
    box-shadow: 0 0 4px rgba(255, 112, 67, 0.4); /* Soft orange glow */
}

.btn-primary {
    background: linear-gradient(90deg, #4caf50, #ff7043); /* Green to Orange gradient */
    border: none;
    font-weight: 600;
    border-radius: 8px;
    padding: 0.7rem 1.5rem;
    font-size: 1.1rem;
    transition: background 0.3s ease, transform 0.2s ease;
    width: 100%;
}

.btn-primary:hover {
    background: linear-gradient(90deg, #ff7043, #4caf50); /* Inverted gradient on hover */
    transform: scale(1.05);
}

/* Login Link Styles */
.login-link {
    text-align: center;
    margin-top: 20px;
}

.login-link a {
    color: #9c27b0; /* Purple color for the login link */
    font-weight: bold;
    text-decoration: none;
}

.login-link a:hover {
    text-decoration: underline;
    color: #6a1b9a; /* Darker purple on hover */
}

/* Form Floating Styles */
.form-floating {
    margin-bottom: 20px;
}

/* Mobile Styling */
@media (max-width: 768px) {
    .register-container {
        padding: 20px;
    }

    h2 {
        font-size: 1.6rem;
    }

    .btn-primary {
        font-size: 1rem;
    }
}

    </style>
</head>
<body>

<!-- Registration Form -->
<div class="container register-container">
    <h2>Registration Form</h2>
    <div class="scrollable-form">
        <form method="POST" enctype="multipart/form-data" id="registrationForm">
            <div class="form-floating mb-3">
                <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name" required>
                <label for="fname">First Name</label>
                <div id="fnameError" class="text-danger"></div>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="mname" id="mname" class="form-control" placeholder="Middle Name" required>
                <label for="mname">Middle Name</label>
                <div id="mnameError" class="text-danger"></div>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="lname" id="lname" class="form-control" placeholder="Last Name" required>
                <label for="lname">Last Name</label>
                <div id="lnameError" class="text-danger"></div>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile Number" maxlength="10" required oninput="this.value = this.value.replace(/[^0-9]/g, '');" pattern="^[9876]\d{9}$" title="Mobile number must start with 9, 8, 7, or 6 and contain only digits.">
                <label for="mobile">Mobile Number</label>
                <div id="mobileError" class="text-danger"></div>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Upload Photo</label>
                <input type="file" name="photo" id="photo" class="form-control" accept=".jpeg, .jpg, .png" required>
                <div id="photoError" class="text-danger"></div>
            </div>

            <div class="form-floating mb-3">
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required pattern="[a-zA-Z0-9._%+-]+@gmail\.com" title="Email must be a valid Gmail address (e.g., example@gmail.com)">
                <label for="email">Email</label>
                <div id="emailError" class="text-danger"></div>
            </div>

            <div class="form-floating mb-3">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                <label for="password">Password</label>
                <div id="passwordError" class="text-danger"></div>
            </div>

            <div class="form-floating mb-3">
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" required>
                <label for="confirm_password">Confirm Password</label>
                <div id="confirmPasswordError" class="text-danger"></div>
            </div>

            <button type="submit" name="register" class="btn btn-primary">Register</button>
        </form>
    </div>
    <div class="login-link">
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Form Validation Script -->
<script>
    $(document).ready(function() {
        $('#registrationForm').submit(function(e) {
            let isValid = true;

            // Clear previous error messages
            $('.text-danger').text('');

            // First Name Validation
            if ($('#fname').val() === '') {
                $('#fnameError').text('First name is required.');
                isValid = false;
            }

            // Mobile Validation
            const mobile = $('#mobile').val();
            if (mobile.length !== 10 || isNaN(mobile)) {
                $('#mobileError').text('Enter a valid 10-digit mobile number.');
                isValid = false;
            }

            // Email Validation
            const email = $('#email').val();
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
                $('#emailError').text('Enter a valid email address.');
                isValid = false;
            }

            // Password Validation
            const password = $('#password').val();
            const confirmPassword = $('#confirm_password').val();
            if (password !== confirmPassword) {
                $('#confirmPasswordError').text('Passwords do not match.');
                isValid = false;
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>

</body>
</html>



