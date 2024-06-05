<?php
// Include database connection
include "db_connection.php";

// Define a flag to indicate whether the page should refresh
$insert_success = false;

// Fetch delivery data with status "pending"
$query = "SELECT * FROM delivery WHERE Status = 'pending'";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result === false) {
    die("Error executing the query: " . mysqli_error($conn));
}

// Insert selected delivery into riders table and update status
if (isset($_POST['insert'])) {
    $delivery_id = $_POST['delivery_id'];
    
    $insert_query = "INSERT INTO riders (DeliveryID, PaymentID, OrderID, TotalAmount, PaymentMethod, GCashScreenshot, PaymentDate, Reference, Address, Receiver, Phone, Status, Location, Rider) 
                     SELECT DeliveryID, PaymentID, OrderID, TotalAmount, PaymentMethod, GCashScreenshot, PaymentDate, reference, address, receiver, phone, Status, Location, Rider FROM delivery WHERE DeliveryID = $delivery_id";
    $insert_result = mysqli_query($conn, $insert_query);

    if ($insert_result === false) {
        die("Error inserting data: " . mysqli_error($conn));
    } else {
        // Update delivery table status to "processing"
        $update_query = "UPDATE delivery SET Status = 'processing' WHERE DeliveryID = $delivery_id";
        $update_result = mysqli_query($conn, $update_query);
        
        if ($update_result === false) {
            die("Error updating status: " . mysqli_error($conn));
        } else {
            // Set flag to indicate successful insertion
            $insert_success = true;
        }
    }
}

// Close the database connection (optional)
mysqli_close($conn);

// If insertion is successful, redirect to insert_delivery.php after 1 second
if ($insert_success) {
    echo '<meta http-equiv="refresh" content="1;url=insert_delivery.php">';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Delivery</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            padding: 5px 10px;
            border: none;
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Delivery Table</h1>
    <table>
        <tr>
            <th>DeliveryID</th>
            <th>PaymentID</th>
            <th>OrderID</th>
            <th>TotalAmount</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['DeliveryID']; ?></td>
                <td><?php echo $row['PaymentID']; ?></td>
                <td><?php echo $row['OrderID']; ?></td>
                <td><?php echo $row['TotalAmount']; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="delivery_id" value="<?php echo $row['DeliveryID']; ?>">
                        <button type="submit" name="insert">Insert</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
