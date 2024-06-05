<?php
include "../../db_connection.php";

// Start session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['total'])) {
    // Validate total amount
    $totalAmount = floatval($_GET['total']);
    if ($totalAmount <= 0 || !is_numeric($totalAmount)) {
        // Invalid total amount
        echo "Invalid total amount.";
        exit();
    }

    // Retrieve cart items for the current session
    $sessionId = session_id();
    $sql = "SELECT * FROM cart WHERE SessionID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $sessionId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Insert cart items into cartlog table
        while ($row = mysqli_fetch_assoc($result)) {
            $cartId = $row['CartID'];
            $productId = $row['ProductID'];
            $quantity = $row['Quantity'];
            $price = $row['Price'];
            $dateCreated = $row['DateCreated'];
            $sql = "INSERT INTO cartlog (CartID, SessionID, ProductID, Quantity, Price, DateCreated) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssss", $cartId, $sessionId, $productId, $quantity, $price, $dateCreated);
            mysqli_stmt_execute($stmt);
        }

        // Insert order details into the orders table
        $orderDate = date('Y-m-d H:i:s');
        $status = "pending"; // Default status
        $sql = "INSERT INTO orders (SessionID, TotalAmount, OrderDate, Status) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sds", $sessionId, $totalAmount, $orderDate, $status);
        if (mysqli_stmt_execute($stmt)) {
            $orderId = mysqli_insert_id($conn); // Get the ID of the inserted order

            // Insert order items into the order_items table
            mysqli_data_seek($result, 0); // Reset the pointer to the beginning of the result set
            while ($row = mysqli_fetch_assoc($result)) {
                $productId = $row['ProductID'];
                $quantity = $row['Quantity'];
                $price = $row['Price'];
                $productName = $row['ProductName']; // Retrieve product name from the cart
                $sql = "INSERT INTO order_items (OrderID, ProductID, ProductName, Quantity, Price) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "isssi", $orderId, $productId, $productName, $quantity, $price);
                mysqli_stmt_execute($stmt);

                // Update product stock quantity
                $updateSql = "UPDATE product SET StockQuantity = StockQuantity - ? WHERE ProductID = ?";
                $stmt = mysqli_prepare($conn, $updateSql);
                mysqli_stmt_bind_param($stmt, "ii", $quantity, $productId);
                mysqli_stmt_execute($stmt);
            }

            // Clear the cart after checkout
            $sql = "DELETE FROM cart WHERE SessionID = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "s", $sessionId);
            mysqli_stmt_execute($stmt);

            echo "<h2>Order Placed Successfully</h2>";
            echo "<p>Order ID: $orderId</p>";
            echo "<p>Total Amount: $" . number_format($totalAmount, 2) . "</p>";
            echo "<p>Thank you for your purchase!</p>";

            // Include payment form
            include("payment.php");

        } else {
            echo "Error: Unable to place the order. Please try again later.";
        }
    } else {
        echo "Your cart is empty.";
    }
} else {
    echo "Invalid request.";
}

// Close connection
mysqli_close($conn);
?>
