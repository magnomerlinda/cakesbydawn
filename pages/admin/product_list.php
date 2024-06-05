<?php
include "db_connection.php";

// Fetch products from database
$sql = "SELECT * FROM product";
$result = mysqli_query($conn, $sql);
?>
<?php $title = "Product"; ?>
<?php include("layout/header.php"); ?>

    <style>
		/* General styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    margin: 0;
}

h2 {
    text-align: center;
    color: #333;
}

/* Action buttons */
.action-buttons {
    text-align: center;
    margin-bottom: 20px;
}

.action-buttons a {
    display: inline-block;
    text-decoration: none;
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    margin: 0 5px;
    font-size: 16px;
}

.action-buttons a:hover {
    background-color: #45a049;
}

/* Table styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

table th, table td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

table th {
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
}

table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tbody tr:hover {
    background-color: #ddd;
}

/* Action links in table */
table td a {
    text-decoration: none;
    color: #4CAF50;
    margin-right: 10px;
}

table td a:hover {
    text-decoration: underline;
}

    </style>


<body>
<div style="padding: 2% 7%;">
    <h2>Product List</h2>
    <div class="action-buttons">
        <a href="insert_product.php">Add Product</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['Name'] . "</td>";
                    echo "<td>" . $row['Price'] . "</td>";
                    echo "<td>" . $row['Category'] . "</td>";
                    echo "<td>
                            <a href='update_product.php?id=" . $row['ProductID'] . "'>Update</a>
                            <a href='delete_product_process.php?id=" . $row['ProductID'] . "'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No product found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
	</div><br>
	<div style="padding: 2% 10%;">
	<?php include "../auth/layout/footer.php"; ?>
	</div>
</body>
</html>


