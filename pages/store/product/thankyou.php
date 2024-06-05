    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../../../assets/favicon.ico" type="image/x-icon">
<?php
session_start();
include "../../../db_connection.php";

// Check if orderId is set in the URL
if (isset($_GET['orderId'])) {
    $orderId = intval($_GET['orderId']);
    
    // Retrieve order items for the given order ID and status 'process'
    $sql = "SELECT oi.ProductName, oi.Quantity, oi.Price 
            FROM order_items oi
            JOIN orders o ON oi.OrderID = o.OrderID
            WHERE oi.OrderID = $orderId AND o.Status = 'process'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='container'>";
        echo "<h2 style='color: #EF7C8E;'>Thank You for Your Order!</h2>";
        echo "<p style='color: #333'>Your payment has been successfully processed. Here are the details of your order:</p>";
        echo "<table border='1'>";
        echo "<tr><th>Product Name</th><th>Quantity</th><th>Price</th><th>Total</th></tr>";
        $totalAmount = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $productName = $row['ProductName'];
            $quantity = $row['Quantity'];
            $price = $row['Price'];
            $total = $quantity * $price;
            $totalAmount += $total;

            echo "<tr>";
            echo "<td>" . $productName . "</td>";
            echo "<td>" . $quantity . "</td>";
            echo "<td>₱" . $price . "</td>";
            echo "<td>₱" . $total . "</td>";
            echo "</tr>";
        }
        echo "<tr><td colspan='3'><strong>Total Amount</strong></td><td><strong>₱" . $totalAmount . "</strong></td></tr>";
        echo "</table>";
        echo "<button onclick='redirectToIndex()'>Back to Home</button>";
        echo "</div>";
    } else {
        echo "<h2>No items found for this order.</h2>";
    }
} else {
    echo "<h2>Invalid Order ID.</h2>";
}

// Close connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: 100px auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
			color:#333;
        }
        th {
            background-color: #EF7C8E;
			color: white;
        }
        button {
			border-radius: 5px;
            padding: 10px 20px;
            background-color: #2D1674;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 20px;
			box-shadow: 2px 2px 25px 2px rgba(0, 0, 0, 0.2);
        }
    </style>
    <link rel="icon" href="../../../assets/favicon.ico" type="image/x-icon">
</head>
<body>
    <script>
        function redirectToIndex() {
            window.location.href = "../../../";
        }
    </script>
</body>
</html>
