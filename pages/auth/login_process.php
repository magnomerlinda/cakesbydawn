<?php
// Start session
session_start();

// Include database connection
include "db_connection.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check user credentials
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Password correct, set session variables and redirect
            $_SESSION['username'] = $username;
            $_SESSION['type'] = $row['type']; // Assuming 'type' is the column that holds user role
            
            // Redirect based on user type
            if ($_SESSION['type'] == 'rider') {
                header("Location: ../driver/riders.php");
            } else {
                header("Location: ../admin/admin_dashboard.php");
            }
            exit();
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "User not found";
    }

    // Close connection
    mysqli_close($conn);
}
?>
