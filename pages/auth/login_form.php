<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php $title = "Admin"; ?>
<link rel="icon" href="../../assets/favicon.ico" type="image/x-icon">
</head>
<body style="padding:0; margin-top:0;">
<div style="padding: 2% 6%; margin-top:4%">
    <h2 style="color:#F652A0;">Admin <span style="color: #333;">Login</span></h2>
    <form action="login_process.php" method="post" style="width: 80%;box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); padding: 2% 5%; border-radius: 5px; border: 1px solid white; color: #333;">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
	</div>
	<div style="padding:2% 5%;margin-top: 20px;">
	<br>
	<a href="../../index.php" style="text-decoration: none; background-color: #333; color: white; padding: 10px 30px; border-radius: 7px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">Back</a>
	<br></div><br>

<div style="padding:2% 5%; background-color:#F652A0; color: white; ">
<?php include("layout/footer.php"); ?>
</div>
</body>