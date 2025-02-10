<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
// Start output buffering at the top
ob_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "admission";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Export to Excel logic
if (isset($_POST['export_excel'])) {
    // Export headers should come first before any output
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=admission_report.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    $output = fopen("php://output", "w");

    // Column headers
    fputcsv($output, ['Admission ID', 'Title', 'First Name', 'Middle Name', 'Last Name', 'Full Name', 'Mother Name', 'Gender', 'Address', 'Mobile', 'Email', 'DOB', 'Age', 'District', 'Taluka', 'State', 'Religion', 'Caste', 'Physically Handicapped', 'Marksheet', 'Photo', 'Signature']);

    // Query to fetch data
    $sql = "SELECT admission_id, title, first_name, middle_name, last_name, CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name, mother_name, gender, address, mobile, email, dob, age, district, taluka, state, religion, caste, physically_handicapped, marksheet, photo, signature FROM admissions";
    
    $result = $conn->query($sql);

    // Fetch each row and write to the CSV
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    fclose($output);
    exit;
}

// Report Section (report.php)
$sql = "SELECT * FROM admissions";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Report</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

  <style>
/* General styles */
/* General body styling */
/* General body styling */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color:rgb(213, 180, 103); /* Light off-white background */
    color: #333; /* Dark text for better contrast */
    margin: 0;
    padding: 0;
}

/* Container for content */
.container {
    width: 85%;
    margin: 30px auto;
    padding: 20px;
    background-color: #ffffff; /* White background for the content */
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(10, 33, 243, 0.53); /* Soft shadow for depth */
}

/* Header styles */
h2 {
    text-align: center;
    font-size: 24px;
    color: black; /* Dark gray for the title */
    margin-bottom: 20px;
    font-weight: 600;
}

/* Button styling */
button {
    font-size: 14px;
    padding: 10px 20px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
}

/* Default buttons (Neutral light color) */
.btn {
    background-color:rgb(85, 249, 9); /* Very light neutral color */
    color: #444;
}


/* Export button (Pastel color) */
.btn-export {
    background-color:rgb(6, 4, 0); /* Light pastel cream */
    color:rgb(16, 4, 1); /* Darker brown for contrast */
}

/* Table styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #D1D1D1; /* Soft border color */
}

th, td {
    padding: 12px;
    text-align: left;
    font-size: 15px;
    font-weight: 400;
}

/* Table headers */
th {
    background-color: #FFF3E0; /* Light peach color for headers */
    color:rgb(11, 3, 1); /* Dark brown text for contrast */
    font-weight: 600;
}

/* Table row striping */
tr:nth-child(even) {
    background-color:rgb(246, 185, 3); /* Soft yellow for even rows */
}

/* Table responsive design */
@media (max-width: 768px) {
    table, th, td {
        font-size: 12px; /* Smaller text for smaller screens */
        padding: 10px;
    }

    .container {
        width: 95%;
        padding: 15px;
    }

    h2 {
        font-size: 22px;
    }
}

/* Form section */
form {
    text-align: center;
    margin-bottom: 20px;
}

/* Focused input fields (if applicable) */
input:focus, select:focus, textarea:focus {
    outline: 2px solid #D7CCC8; /* Focus color */
    border-color: #D7CCC8;
}

/* Additional styling for table buttons */
.table-buttons {
    display: flex;
    justify-content: space-around;
    align-items: center;
}

/* Add icons or additional buttons */
.table-buttons .btn {
    margin-right: 10px;
}

/* Styling for the "Actions" column in table */
.table-actions {
    text-align: center;
}

  </style>
</head>
<body>
<div class="container table-container">
    <div class="header-container">
        <h2><b>Admission Record</b></h2>
    </div>
<!-- Report Table -->
<?php
if ($result->num_rows > 0) {
    echo "<div class='table-responsive'>
            <table id='reportTable' class='table table-striped table-bordered align-middle'>
                 <thead style=\"background-color:rgb(251, 205, 4); color: #fff;\">
                   <tr>
                        <th>Admission ID</th>
                        <th>Title</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Full Name</th>
                        <th>Mother Name</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Taluka</th>
                        <th>District</th>
                        <th>Pin Code</th>
                        <th>State</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Aadhaar Number</th>
                        <th>Date of Birth</th>
                        <th>Age</th>
                        <th>Religion</th>
                        <th>Caste Category</th>
                        <th>Caste</th>
                        <th>Physically Handicapped</th>
                        <th>Marksheet</th>
                        <th>Photo</th>
                        <th>Signature</th>
                        <th>Actions</th>
                   </tr>
                 </thead>
                 <tbody>";
                 
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['admission_id']}</td>
                <td>{$row['title']}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['middle_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['full_name']}</td>
                <td>{$row['mother_name']}</td>
                <td>{$row['gender']}</td>
                <td>{$row['address']}</td>
                <td>{$row['taluka']}</td>
                <td>{$row['district']}</td>
                <td>{$row['pin_code']}</td>
                <td>{$row['state']}</td>
                <td>{$row['mobile']}</td>
                <td>{$row['email']}</td>
                <td>{$row['aadhaar']}</td>
                <td>{$row['dob']}</td>
                <td>{$row['age']}</td>
                <td>{$row['religion']}</td>
                <td>{$row['caste_category']}</td>
                <td>{$row['caste']}</td>
                <td>{$row['physically_handicapped']}</td>
                <td><img src='{$row['marksheet']}' alt='marksheet' height='50' /></td>
                <td><img src='{$row['photo']}' alt='Photo' height='50' /></td>
                <td><img src='{$row['signature']}' alt='Signature' height='50' /></td>
                <td>
                    <a href='edit.php?admission_id={$row['admission_id']}' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='delete.php?admission_id={$row['admission_id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you do you want to delete this record if yes then click ok.?');\">Delete</a>
                </td>
            </tr>";
    }
    
    echo "</tbody></table></div>";
} else {
    echo "<p class='text-center'>No records found.</p>";
}

?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
<!-- JSZip (Required for Excel export) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<!-- Excel Export Plugin for DataTables -->
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#reportTable').DataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [5, 10, 15, 20],
            responsive: true,
            dom: 'Bfrtip', // Required to show buttons (B - Buttons)
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Export to Excel',
                    title: 'Admission Record', // Custom Excel file title
                    className: 'btn btn-success',
                    exportOptions: {
                      columns: ':visible:not(:last-child)' // Exclude the last column (Actions)
                    },
                    customize: function (xlsx) {
                        var sheet = xlsx.xl.worksheets.sheet1;
                        
                        // Change header row style (make it bold)
                        $(sheet).find('row c[r="A1"]').attr('s', '54'); // Apply bold style to A1 cell
                        $(sheet).find('row c[r="B1"]').attr('s', '54'); // Apply bold style to B1 cell
                        $(sheet).find('row c[r="C1"]').attr('s', '54'); // Apply bold style to C1 cell
                        // Repeat this for each header cell you want to make bold
                        
                        // Apply bold style to the entire header row
                        $(sheet).find('row').eq(0).children('c').each(function () {
                            $(this).attr('s', '54'); // Apply bold style
                        });

                        // You can also apply other formatting, like changing column width, etc.
                        var colWidth = 20; // Set the width of columns (example)
                        $(sheet).find('row c').each(function () {
                            $(this).attr('width', colWidth);
                        });
                    }
                }
            ]
        });
    });
    
</script>
</body>
</html>
