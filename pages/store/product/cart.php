<head>
 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>


body {
    font-family: Arial, sans-serif;
    margin: 0;
}

h2 {
    text-align: center;
    color: #333;
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

form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="submit"] {
    padding: 5px;
    width: 100%;
    box-sizing: border-box;
    margin-bottom: 10px;
}

input[type="submit"] {
    background-color: #432F70;
    color: white;
    border: none;
    cursor: pointer;
	box-shadow: 5px 5px 8px 2px rgba(0, 0, 0, 0.3);
	border-radius: 7px;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

/* Media Queries for Mobile Devices */

@media screen and (max-width: 600px) {
    table {
        font-size: 13px;
		width: 100%
    }
    
    input[type="text"],
    input[type="submit"] {
        font-size: 14px;
        padding: 5px;
    }
}

</style>
</dead>
<div style="padding: 2% 10%;">
<?php
session_start();
include "../../db_connection.php";

$totalAmount = 0;

// Retrieve cart items for the current session
$sessionId = session_id();
$sql = "SELECT c.CartID, p.ProductID, p.Name AS ProductName, c.Quantity, c.Price FROM cart c JOIN product p ON c.ProductID = p.ProductID WHERE SessionID = '$sessionId'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h2 style='color: #5D59AF;'>Your Cart <span style='color: orange;'><svg xmlns='http://www.w3.org/2000/svg' width='26' height='26' fill='currentColor' class='bi bi-bag-heart' viewBox='0 0 16 16'>
  <path fill-rule='evenodd' d='M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0M14 14V5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1M8 7.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132'/>
</svg></span></h2>";
    echo "<table border='1'>";
    echo "<tr><th>Product Name</th><th>Quantity</th><th>Price</th><th>Total</th><th>Action</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['ProductName'] . "</td>";
        echo "<td>" . $row['Quantity'] . "</td>";
        echo "<td>₱" . $row['Price'] . "</td>";
        $total = $row['Price'] * $row['Quantity'];
        $totalAmount += $total;
        echo "<td>₱" . $total . "</td>";
        echo "<td>
            <form action='cancel_item.php' method='post' style='display:inline;'>
                <input type='hidden' name='cartId' value='" . $row['CartID'] . "'>
                <input type='submit' value='Delete'>
            </form>
        </td>";
        echo "</tr>";
    }
    echo "</table>";

    // Form for placing the order
    echo "<h2>Enter Your Details</h2>";
    echo "<form id='orderForm' action='place_order.php' method='post'>";
    echo "<label for='customerName'>Customer Name:</label>";
    echo "<input type='text' id='customerName' name='customerName' required><br>";

    echo "<label for='receiver'>Receiver:</label>";
    echo "<input type='text' id='receiver' name='receiver' required><br>";

    echo "<label for='phone'>Phone:</label>";
    echo "<input type='text' id='phone' name='phone' required><br>";

    // Address field
    echo "<label for='address'>Address:</label>";
    echo "<textarea id='address' style='width: 100%;' name='address' required></textarea><br><br>";

    // Hidden input for total amount
    echo "<input type='hidden' name='totalAmount' value='" . $totalAmount . "'>";

    // Generate reference number
    $reference = uniqid(); // Generating a unique reference number
    echo "<input type='hidden' name='reference' value='" . $reference . "'>";

    // Submit button
    echo "<input type='submit' value='Place Order'>";
    echo "</form>";
} else {
    echo "<p>Your cart is empty.</p>";
}

// Close connection
mysqli_close($conn);
?>

</div>