<?php
include "../../db_connection.php"; // Adjust the path to your db_connection.php file

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "SELECT * FROM product WHERE ProductID=$id"; // Changed to 'product' table
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Product not found";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Product</title>
</head>
<body>
    <h2>Update Product</h2>
    <form action="update_product_process.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $row['Name']; ?>" required><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required><?php echo $row['Description']; ?></textarea><br>
        
        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" min="0" step="0.01" value="<?php echo $row['Price']; ?>" required><br>
        
        <label for="stock_quantity">Stock Quantity:</label><br>
        <input type="number" id="stock_quantity" name="stock_quantity" min="0" value="<?php echo $row['StockQuantity']; ?>" required><br>
        
        <label for="category">Category:</label><br>
        <input type="text" id="category" name="category" value="<?php echo $row['Category']; ?>" required><br>
        
        <label for="image">Image:</label><br>
        <input type="text" id="image" name="image" value="<?php echo $row['Image']; ?>" required><br><br>
        
        <input type="submit" value="Update Product">
    </form>
</body>
</html>
