<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="../../assets/favicon.ico" type="image/x-icon">
    <title>Add Product</title>
	<style>
	/* General form styles */
form {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
}

/* Label styles */
form label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
    color: #333;
}

/* Input and textarea styles */
form input[type="text"],
form input[type="number"],
form textarea,
form input[type="file"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
}

/* Textarea specific styles */
form textarea {
    resize: vertical;
    height: 100px;
}

/* Submit button styles */
form input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

/* Submit button hover effect */
form input[type="submit"]:hover {
    background-color: #45a049;
}

/* Hidden input styles */
form input[type="number"][hidden] {
    display: none;
}

	</style>
</head>
<body>
<?php include("layout/header.php"); ?>
<div style="padding: 2% 10%;">
    <h2>Welcome, <?php echo $username; ?></h2>
    <!-- Admin dashboard content goes here -->
	
    <h2>Add Product</h2>
    <form action="insert_product_process.php" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br>
        
        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" min="0" step="0.01" required><br>
        
        <input type="number" id="stock_quantity" name="stock_quantity" min="0" value="100" hidden><br>
        
        <label for="category">Category:</label>
            <select id="category" name="category" style="width: 50%; margin: 20px;" required>
                <option value="choco">Choco</option>
                <option value="vanilla">Vanilla</option>
                <option value="mixed">Mixed</option>
        <br><br>
        <label for="image" >Image:</label><br>
        <input type="file" id="image" name="image" style="margin-top: 20px;" required><br><br>
        
        <input type="submit" value="Add Product">
    </form>
	</div>
</body>
</html>
