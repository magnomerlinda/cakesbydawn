<?php
session_start();

// Check if user is not logged in or not an admin, redirect to login page
if (!isset($_SESSION['username']) || $_SESSION['type'] !== 'admin') {
    header("Location: ../auth/login_form.php");
    exit();
}
?>
<?php


// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get username from session
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="icon" href="../../assets/favicon.ico" type="image/x-icon">
    <title><?php echo isset($title) ? $title : "Untitled"; ?></title>
	<style>
	               body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #5C247A;
            padding: 20px;
            text-align: center;
        }

        nav {
            background-color: #f8f9fa;
            padding: 10px 0;
            text-align: center;
        }
        nav a {
            margin: 0 10px;
            color: #E56997;
            text-decoration: none;
        }
        nav a:hover {
            color: #BD97CB;
        }
        .footer {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        .menu-icon {
            display: none;
            cursor: pointer;
        }
        @media only screen and (max-width: 768px) {
            nav a {
                display: block;
                padding: 10px 0;
            }
            .menu-icon {
                display: block;
            }
            .menu-items {
                display: none;
            }
            .menu-items.active {
                display: block;
            }
        }
		</style>
		
</head>
<body>
    <header style="background-color: #432F70;">
        <h1 style="color:#66D2D6;">Cakes<span style="color:#66D2D6;"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-cake" viewBox="0 0 16 16">
  <path d="m7.994.013-.595.79a.747.747 0 0 0 .101 1.01V4H5a2 2 0 0 0-2 2v3H2a2 2 0 0 0-2 2v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a2 2 0 0 0-2-2h-1V6a2 2 0 0 0-2-2H8.5V1.806A.747.747 0 0 0 8.592.802zM4 6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v.414a.9.9 0 0 1-.646-.268 1.914 1.914 0 0 0-2.708 0 .914.914 0 0 1-1.292 0 1.914 1.914 0 0 0-2.708 0A.9.9 0 0 1 4 6.414zm0 1.414c.49 0 .98-.187 1.354-.56a.914.914 0 0 1 1.292 0c.748.747 1.96.747 2.708 0a.914.914 0 0 1 1.292 0c.374.373.864.56 1.354.56V9H4zM1 11a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.793l-.354.354a.914.914 0 0 1-1.293 0 1.914 1.914 0 0 0-2.707 0 .914.914 0 0 1-1.292 0 1.914 1.914 0 0 0-2.708 0 .914.914 0 0 1-1.292 0 1.914 1.914 0 0 0-2.708 0 .914.914 0 0 1-1.292 0L1 11.793zm11.646 1.854a1.915 1.915 0 0 0 2.354.279V15H1v-1.867c.737.452 1.715.36 2.354-.28a.914.914 0 0 1 1.292 0c.748.748 1.96.748 2.708 0a.914.914 0 0 1 1.292 0c.748.748 1.96.748 2.707 0a.914.914 0 0 1 1.293 0Z"/>
</svg></span> <span style="color:#FBC740;">by Dawn</span></h1>
    </header>
    <nav style="box-shadow: 5px 5px 8px 2px rgba(0, 0, 0, 0.1);">
        <!-- Burger Button -->
        <div class="menu-icon">&#9776;</div>
        <!-- Burger menu items -->
        <div class="menu-items">
           
                <a href="admin_dashboard.php">Dashboard</a>
				<a href="insert_product.php">ADD Product</a>
             <a href="product_list.php">Product</a>
			 <a href="show_orders.php">Orders</a>
              <a href="logout.php">Logout</a>
           
   </div>
    </nav>

<script>
    document.querySelector('.menu-icon').addEventListener('click', function() {
        document.querySelector('.menu-items').classList.toggle('active');
    });
</script>