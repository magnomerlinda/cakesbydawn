<?php
include "../../db_connection.php";

// Start session
session_start();

// Check if the remove button is clicked
if(isset($_POST['removeCartItem'])) {
    // Sanitize the product ID
    $productIdToRemove = mysqli_real_escape_string($conn, $_POST['removeCartItem']);
    
    // Delete the item from the cart
    $sql = "DELETE FROM cart WHERE ProductID = '$productIdToRemove' AND SessionID = '" . session_id() . "'";
    $result = mysqli_query($conn, $sql);
    
    if(!$result) {
        echo "Error removing item from cart: " . mysqli_error($conn);
        exit;
    }
    
    // Redirect back to cart page
    header("Location: store.php");
    exit;
}
else {
    // Redirect to cart page if remove button is not clicked
    header("Location: store.php");
    exit;
}

// Close connection
mysqli_close($conn);
?>
