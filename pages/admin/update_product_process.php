<?php
include "../../db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $image = mysqli_real_escape_string($conn, $_POST['image']);

    $sql = "UPDATE product SET Name='$name', Description='$description', Price=$price, StockQuantity=$stock_quantity, Category='$category', Image='$image' WHERE ProductID=$id";

    if (mysqli_query($conn, $sql)) {
        echo "Product updated successfully!";
        echo '<meta http-equiv="refresh" content="2;url=product_list.php">';
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
