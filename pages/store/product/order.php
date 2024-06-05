<?php
include "../../db_connection.php";



// Retrieve orders from the database
$sessionID = session_id();
$sql = "SELECT * FROM orders WHERE SessionID = '$sessionID'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Display orders
   
    echo "<table border='1'  class='ordert'>";
    echo "<tr><th>Order ID</th><th>Session ID</th><th>Total Amount</th><th>Order Date</th><th>Status</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['OrderID'] . "</td>";
        echo "<td>" . $row['SessionID'] . "</td>";
        echo "<td>$" . $row['TotalAmount'] . "</td>";
        echo "<td>" . $row['OrderDate'] . "</td>";
        echo "<td>" . $row['Status'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No orders available for this session.</p>";
}

// Close connection
mysqli_close($conn);
?>
