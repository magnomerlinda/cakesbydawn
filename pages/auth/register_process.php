<?php
// Include database connection file
include "../../db_connection.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $type = mysqli_real_escape_string($conn, $_POST['type']);

    // Check if passwords match
    if ($password != $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare insert statement
    $sql = "INSERT INTO users (username, email, password, first_name, middle_name, last_name, type) VALUES ('$username', '$email', '$hashed_password', '$first_name', '$middle_name', '$last_name', '$type')";

    if (mysqli_query($conn, $sql)) {
        echo "Registration successful!";
        // Redirect to login page after 2 seconds
        header("refresh:2;url=login_form.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
}
?>
