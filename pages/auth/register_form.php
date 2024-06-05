<?php $title = "Register"; ?>
<?php include("layout/header.php"); ?>
<body>
    <h2>Registration</h2>
    <form action="register_process.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        
        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
        
        <label for="first_name">First Name:</label><br>
        <input type="text" id="first_name" name="first_name"><br>
        
        <label for="middle_name">Middle Name:</label><br>
        <input type="text" id="middle_name" name="middle_name"><br>
        
        <label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name"><br><br>
        
        <label for="type">Type:</label><br>
        <select id="type" name="type" required>
            <option value="admin">Admin</option>
            <option value="seller">Seller</option>
            <option value="rider">Rider</option>
            <option value="customer">Customer</option>
        </select><br><br>
        
        <input type="submit" value="Register">
    </form>
</body>
<?php include("layout/footer.php"); ?>
