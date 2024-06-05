<?php
include "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape other user inputs for security
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    
    // File upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            exit();
        }
        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            exit();
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Insert product data into database
            $sql = "INSERT INTO product (Name, Description, Price, StockQuantity, Category, Image) VALUES ('$name', '$description', $price, $stock_quantity, '$category', '$target_file')";
            if (mysqli_query($conn, $sql)) {
                echo "Product added successfully!";
                echo '<meta http-equiv="refresh" content="2;url=product_list.php">';
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }

    // Close connection
    mysqli_close($conn);
}
?>
