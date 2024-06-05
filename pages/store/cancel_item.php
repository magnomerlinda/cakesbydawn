<?php
session_start();
include "../../db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cartId = $_POST['cartId'];
    $sessionId = session_id();

    // Retrieve the cart item details
    $sql = "SELECT * FROM cart WHERE CartID = $cartId";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $productId = $row['ProductID'];
        $quantity = $row['Quantity'];
        $price = $row['Price'];
        $dateCreated = $row['DateCreated'];

        // Insert the cart item into the cartlog table
        $insertCartLogSql = "INSERT INTO cartlog (CartID, SessionID, ProductID, Quantity, Price, DateCreated) VALUES ($cartId, '$sessionId', $productId, $quantity, $price, '$dateCreated')";
        mysqli_query($conn, $insertCartLogSql);

        // Delete the cart item
        $deleteCartItemSql = "DELETE FROM cart WHERE CartID = $cartId";
        mysqli_query($conn, $deleteCartItemSql);
    }
}

// Redirect back to the cart page after deletion
header("Location: showcart.php");
exit();

// Close connection
mysqli_close($conn);
?>
