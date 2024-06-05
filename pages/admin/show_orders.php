<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders in Process</title>

   
	<link rel="icon" href="../../assets/favicon.ico" type="image/x-icon">



<style>
/* General Styles */

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
    background-color: #f4f4f4;
}

h2 {
    text-align: center;
    color: #333;
}

h3 {
    color: #555;
}

p {
    color: #666;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 10px;
    text-align: left;
}

th {
    background-color: #f4f4f4;
}

td {
    background-color: #fff;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

hr {
    border: 0;
    height: 1px;
    background: #ddd;
    margin: 20px 0;
}


/* Mobile Styles */

@media only screen and (max-width: 600px) {
    .container {
        padding: 2% 15%;
        border-radius: 0;
    }

    table {
        margin-top: 10px;
    }

    th, td {
        padding: 8px;
        font-size: 14px;
    }

    h2, h3, p {
        font-size: 18px;
    }

    hr {
        margin: 10px 0;
    }
}

</style>
</head>
<?php include("layout/header.php"); ?>
<div class="container">
  
<?php

include "../../db_connection.php";

// Retrieve all orders with status 'process'
$sql = "SELECT o.OrderID, o.CustomerName, o.TotalAmount, o.OrderDate, o.Receiver, o.Phone, o.Reference
        FROM orders o
        WHERE o.Status = 'process'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2>Orders in Process</h2>";
    while ($order = mysqli_fetch_assoc($result)) {
        $orderId = $order['OrderID'];
        $customerName = $order['CustomerName'];
        $totalAmount = $order['TotalAmount'];
        $orderDate = $order['OrderDate'];
        $receiver = $order['Receiver'];
        $phone = $order['Phone'];
        $reference = $order['Reference'];

        echo "<h3>Order ID: $orderId</h3>";
        echo "<p>Customer Name: $customerName</p>";
        echo "<p>Total Amount: ₱$totalAmount</p>";
        echo "<p>Order Date: $orderDate</p>";
        echo "<p>Receiver: $receiver</p>";
        echo "<p>Phone: $phone</p>";
        echo "<p>Reference: $reference</p>";

        // Retrieve order items for the current order
        $itemsSql = "SELECT oi.ProductName, oi.Quantity, oi.Price 
                     FROM order_items oi
                     WHERE oi.OrderID = $orderId";
        $itemsResult = mysqli_query($conn, $itemsSql);

        if (mysqli_num_rows($itemsResult) > 0) {
            echo "<table border='1' style='width: 100%;'>";
            echo "<tr><th>Product Name</th><th>Quantity</th><th>Price</th><th>Total</th></tr>";
            while ($item = mysqli_fetch_assoc($itemsResult)) {
                $productName = $item['ProductName'];
                $quantity = $item['Quantity'];
                $price = $item['Price'];
                $total = $quantity * $price;

                echo "<tr>";
                echo "<td>" . $productName . "</td>";
                echo "<td>" . $quantity . "</td>";
                echo "<td>₱" . $price . "</td>";
                echo "<td>₱" . $total . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No items found for this order.</p>";
        }

        echo "<hr>";
    }
} else {
    echo "<p>No orders with status 'process' found.</p>";
}

// Close connection
mysqli_close($conn);
?>
</div>