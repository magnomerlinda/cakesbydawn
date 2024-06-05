<?php
// Include database connection
include "db_connection.php";

// Query to count pending deliveries
$query = "SELECT COUNT(*) AS pending_count FROM delivery WHERE Status = 'pending'";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result === false) {
    die("Error executing the query: " . mysqli_error($conn));
}

// Fetch the result
$row = mysqli_fetch_assoc($result);
$pending_count = $row['pending_count'];

// Close the database connection (optional)
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Deliveries</title>
    <style>
        .notification {
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            display: inline-block;
        }

        .notification:hover {
            opacity: 0.8;
        }

        .yellow {
            background-color: yellow;
        }

        .orange {
            background-color: orange;
        }

        .red {
            background-color: red;
        }
    </style>
</head>
<body>
    <div class="notification <?php echo ($pending_count <= 10) ? 'yellow' : (($pending_count > 10 && $pending_count <= 20) ? 'orange' : 'red'); ?>" onclick="window.location.href='insert_delivery.php'">
        <?php echo $pending_count; ?> pending deliveries
    </div>
</body>
</html>
