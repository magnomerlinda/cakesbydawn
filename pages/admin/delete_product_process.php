<?php
include "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM product WHERE ProductID = $id";

    if (mysqli_query($conn, $sql)) {
        echo "Product deleted successfully!";
        echo '<meta http-equiv="refresh" content="2;url=product_list.php">';
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
