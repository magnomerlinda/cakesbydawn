<?php
include "../../db_connection.php";

// Start session
session_start();

// Check if the form is submitted
if(isset($_POST['updateCart'])) {
    foreach($_POST['quantity'] as $cartID => $quantity) {
        // Sanitize input
        $cartID = mysqli_real_escape_string($conn, $cartID);
        $quantity = mysqli_real_escape_string($conn, $quantity);
        
        // Fetch stock quantity from database
        $fetchStockQty = "SELECT ProductID, StockQuantity FROM product WHERE ProductID IN (SELECT ProductID FROM cart WHERE CartID = '$cartID')";
        $stockResult = mysqli_query($conn, $fetchStockQty);
        $stockData = mysqli_fetch_assoc($stockResult);
        $stockQuantity = $stockData['StockQuantity'];
        
        // If requested quantity exceeds stock, set quantity to stock quantity
        if ($quantity > $stockQuantity) {
            $quantity = $stockQuantity;
        }
        
        // Update quantity in the cart
        $sql = "UPDATE cart SET Quantity = '$quantity' WHERE CartID = '$cartID'";
        $result = mysqli_query($conn, $sql);
        
        if(!$result) {
            echo "Error updating quantity: " . mysqli_error($conn);
            exit;
        }
    }
    
    // Redirect back to cart page
    header("Location: showcart.php");
    exit;
}

// Check if the item needs to be deleted
if(isset($_POST['deleteCartItem'])) {
    $productIdToRemove = mysqli_real_escape_string($conn, $_POST['deleteCartItem']);
    
    // Remove the item from the cart
    $sql = "DELETE FROM cart WHERE ProductID = '$productIdToRemove' AND SessionID = '" . session_id() . "'";
    $result = mysqli_query($conn, $sql);
    
    if(!$result) {
        echo "Error removing item from cart: " . mysqli_error($conn);
        exit;
    }
    
    // Redirect back to cart page
    header("Location: showcart.php");
    exit;
}

// Redirect to cart page if form is not submitted
header("Location: showcart.php");
exit;

// Close connection
mysqli_close($conn);
?>
