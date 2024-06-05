<?php
include "../../../db_connection.php";

// Start session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['orderId']) && isset($_POST['paymentMethod'])) {
    // Get data from the form
    $orderId = $_POST['orderId'];
    $paymentMethod = $_POST['paymentMethod'];

    // Initialize GCash screenshot variable
    $gcashScreenshot = "";

    // Check if payment method is GCash and handle screenshot upload
    if ($paymentMethod == 'gcash' && isset($_FILES['gcashScreenshot'])) {
        $targetDir = "uploads/"; // Directory where the screenshots will be uploaded
        $targetFile = $targetDir . basename($_FILES["gcashScreenshot"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["gcashScreenshot"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["gcashScreenshot"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow only certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["gcashScreenshot"]["tmp_name"], $targetFile)) {
                $gcashScreenshot = $targetFile;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Get total amount from the form
    $totalAmount = $_POST['totalAmount'];

    // Get address, reference, receiver, and phone from the form
    $address = $_POST['address'];
    $reference = $_POST['reference'];
    $receiver = $_POST['receiver'];
    $phone = $_POST['phone'];

    // Insert payment details into the database
    $paymentDate = date('Y-m-d H:i:s');
    $sql = "INSERT INTO payment (OrderID, TotalAmount, PaymentMethod, GCashScreenshot, PaymentDate, address, reference, receiver, phone) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iissssssi", $orderId, $totalAmount, $paymentMethod, $gcashScreenshot, $paymentDate, $address, $reference, $receiver, $phone);

    // Execute statement
    if (mysqli_stmt_execute($stmt)) {
        // Delete all records from cart and insert into cartlog
        $sessionID = session_id();
        $deleteSql = "DELETE FROM cart WHERE SessionID = ?";
        $deleteStmt = mysqli_prepare($conn, $deleteSql);
        mysqli_stmt_bind_param($deleteStmt, "s", $sessionID);

        if (mysqli_stmt_execute($deleteStmt)) {
            // Insert deleted data into cartlog
            $insertSql = "INSERT INTO cartlog (CartID, SessionID, ProductID, Quantity, Price, DateCreated)
                          SELECT CartID, SessionID, ProductID, Quantity, Price, DateCreated FROM cart WHERE SessionID = ?";
            $insertStmt = mysqli_prepare($conn, $insertSql);
            mysqli_stmt_bind_param($insertStmt, "s", $sessionID);
            if (mysqli_stmt_execute($insertStmt)) {
                echo "<h2>Payment Successful</h2>";
                echo "<p>Your payment has been successfully processed.</p>";
                // Redirect to thankyou.php after 2 seconds
                header("refresh:2;url=thankyou.php");
                exit(); // Make sure no further output is sent
            } else {
                echo "Error inserting into cartlog: " . mysqli_error($conn);
            }
        } else {
            echo "Error deleting from cart: " . mysqli_error($conn);
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close statements
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($deleteStmt);
    mysqli_stmt_close($insertStmt);

} else {
    echo "Invalid request.";
}

// Close connection
mysqli_close($conn);
?>
