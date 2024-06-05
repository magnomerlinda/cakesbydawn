<?php
include "../../db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sessionId'])) {
    $sessionId = $_POST['sessionId'];
    
    // Update product table
    $sql = "UPDATE product p
            JOIN cart c ON p.ProductID = c.ProductID
            SET p.StockQuantity = p.StockQuantity - c.Quantity
            WHERE c.SessionID = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $sessionId);
    
    if (mysqli_stmt_execute($stmt)) {
        // Successfully updated product table
        echo "Product table updated successfully.";
    } else {
        // Error updating product table
        echo "Error updating product table: " . mysqli_error($conn);
    }
    
    mysqli_stmt_close($stmt);
} else {
    // Invalid request
    echo "Invalid request.";
}

// Close connection
mysqli_close($conn);
?>
