<?php
session_start();
include "../../db_connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve order details from the form
    $customerName = $_POST['customerName'];
    $totalAmount = $_POST['totalAmount'];
    $paymentMethod = 'cash_on_delivery'; // Assuming payment method is cash on delivery

    // Additional details for orders table
    $sessionId = session_id();
    $orderDate = date('Y-m-d H:i:s'); // Current date and time
    $status = "process"; // Status updated to "process"
    $receiver = $_POST['receiver'];
    $phone = $_POST['phone'];
    $reference = $_POST['reference'];
    $address = $_POST['address']; // Retrieve address from the form

    // Insert order data into 'orders' table
    $insertOrderSql = "INSERT INTO orders (SessionID, TotalAmount, PaymentMethod, OrderDate, Status, CustomerName, Receiver, Phone, Reference, Address, date_updated) VALUES ('$sessionId', $totalAmount, '$paymentMethod', '$orderDate', '$status', '$customerName', '$receiver', '$phone', '$reference', '$address', '$orderDate')";

    if (mysqli_query($conn, $insertOrderSql)) {
        $orderId = mysqli_insert_id($conn); // Get the last inserted order ID

        // Insert order items data into 'order_items' table
        $sql = "SELECT c.CartID, p.ProductID, p.Name AS ProductName, c.Quantity, c.Price FROM cart c JOIN product p ON c.ProductID = p.ProductID WHERE SessionID = '$sessionId'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $productId = $row['ProductID'];
            $productName = $row['ProductName'];
            $quantity = $row['Quantity'];
            $price = $row['Price'];
            $insertOrderItemSql = "INSERT INTO order_items (OrderID, ProductID, ProductName, Quantity, Price) VALUES ($orderId, $productId, '$productName', $quantity, $price)";
            mysqli_query($conn, $insertOrderItemSql);
        }

        // Clear the cart after placing the order
        $deleteCartItemsSql = "SELECT * FROM cart WHERE SessionID = '$sessionId'";
        $result = mysqli_query($conn, $deleteCartItemsSql);

        // Insert deleted cart items into cartlog
        while ($row = mysqli_fetch_assoc($result)) {
            $cartId = $row['CartID'];
            $productId = $row['ProductID'];
            $quantity = $row['Quantity'];
            $price = $row['Price'];
            $dateCreated = $row['DateCreated'];

            // Insert into cartlog
            $insertCartLogSql = "INSERT INTO cartlog (CartID, SessionID, ProductID, Quantity, Price, DateCreated) VALUES ($cartId, '$sessionId', $productId, $quantity, $price, '$dateCreated')";
            mysqli_query($conn, $insertCartLogSql);
        }

        // Delete cart items
        $deleteCartItemsSql = "DELETE FROM cart WHERE SessionID = '$sessionId'";
        mysqli_query($conn, $deleteCartItemsSql);

        // Redirect to a thank you page or order confirmation page
        header("Location: product/thankyou.php?orderId=$orderId");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Redirect to the cart page if the form is not submitted
    header("Location: cart.php");
    exit();
}

// Close connection
mysqli_close($conn);
?>
