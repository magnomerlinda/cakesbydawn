<?php
include "../../db_connection.php";
// Start session
session_start();

// Check if a category is selected and store it in session
if(isset($_POST['category'])) {
    $_SESSION['category'] = $_POST['category'];
}

// Default category is 'choco'
$categoryFilter = isset($_SESSION['category']) ? $_SESSION['category'] : 'choco';
$filterCondition = $categoryFilter ? "WHERE Category = '$categoryFilter'" : "";

// Initialize message variables
$message = "";
$isError = false;

// Handle adding to cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addToCart'])) {
    // Get product details
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productQuantity = 1; // Default quantity is 1
    $sessionId = session_id(); // Get the session ID of the user

    // Insert into cart table
    $sql = "INSERT INTO cart (SessionID, ProductID, Quantity, Price) VALUES ('$sessionId', '$productId', '$productQuantity', '$productPrice')";
    if (mysqli_query($conn, $sql)) {
        $message = "Product '$productName' added to cart successfully!";
    } else {
        $isError = true;
        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM product $filterCondition";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon">
    <style>
       body {
        font-family: Arial, sans-serif;
    }

    form {
        margin-bottom: 20px;
    }

    button {
        background-color: #f0f0f0;
        border: 1px solid #ddd;
        color: #432F70;
        padding: 10px 20px;
        margin-right: 10px;
        cursor: pointer;
        font-size: 16px;
    }

    button.active {
        background-color: #432F70;
        color: #ffffff;
        border: 1px solid #432F70;
    }

    h2 {
        color: #432F70;
    }

    h2 span {
        color: #B34270;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        margin-bottom: 10px;
    }
    </style>
</head>
<body>
    <form method="post">
        <button type="submit" name="category" value="choco">Choco</button>
        <button type="submit" name="category" value="vanilla">Vanilla</button>
        <button type="submit" name="category" value="mixed">Mixed</button>
    </form>

    <!-- Message slot -->
    <?php if (!empty($message)): ?>
        <div style="padding: 10px; background-color: <?php echo $isError ? '#ffcccc' : '#ccffcc'; ?>; margin-bottom: 10px;">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="mobile">
        <h2 style="color: #432F70;">Product List - Category: <span style="color: #B34270;"><?php echo ucfirst($categoryFilter); ?></span></h2>
    
        <?php @include("product/layout/p_list.php"); ?>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const buttons = document.querySelectorAll("button[name='category']");
            const currentCategory = "<?php echo $categoryFilter; ?>";

            buttons.forEach(button => {
                if (button.value === currentCategory) {
                    button.classList.add("active");
                }

                button.addEventListener("click", function() {
                    buttons.forEach(btn => btn.classList.remove("active"));
                    button.classList.add("active");
                });
            });
        });
    </script>

</body>
</html>

<?php
// Close connection
mysqli_close($conn);
?>
