<?php
// Start session
session_start();

// Check if the user is logged in and has the 'rider' type
if (!isset($_SESSION['username']) || $_SESSION['type'] != 'rider') {
    header("Location: access_denied.php");
    exit();
}

// Include header
include "header.php";
?>

<!-- Content for riders page -->
<h1>Welcome, Rider!</h1>
<p>This is the riders page.</p>
<?php include "pending.php";?>
<?php
// Include footer
include "footer.php";
?>
