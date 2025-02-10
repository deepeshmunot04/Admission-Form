<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Include database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admission";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' is passed in the URL
if (isset($_GET['admission_id'])) {
    // Escape the input to prevent SQL injection
    $admission_id = $conn->real_escape_string($_GET['admission_id']);

    // SQL to delete the record
    $sql = "DELETE FROM admissions WHERE admission_id = '$admission_id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Record deleted successfully...!!');
                window.location.href = 'records.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
                window.location.href = 'records.php';
              </script>";
    }
} else {
    echo "<script>
            alert('No ID provided.');
            window.location.href = 'records.php';
          </script>";
}

$conn->close();
?>