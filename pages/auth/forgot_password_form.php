<?php $title = "Forgot Password"; ?>
<?php include("layout/header.php"); ?>
<body>
    <h2>Forgot Password</h2>
    <form action="forgot_password_process.php" method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <input type="submit" value="Reset Password">
    </form>
</body>
<?php include("layout/footer.php"); ?>
