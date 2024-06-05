<?php
// Database configuration
$db_host = "localhost"; // Your database host
$db_user = "root"; // Your database username
$db_pass = ""; // Your database password
$db_name = "mcake"; // Your database name

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
