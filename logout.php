<?php
// logout.php

// Start the session
session_start();

// Destroy all session data
session_unset(); // Removes all session variables
session_destroy(); // Destroys the session

// Output JavaScript to show an alert
echo "<script>
        alert('Logout successful..!!');
        window.location.href = 'login.php';
      </script>";
exit();
?>