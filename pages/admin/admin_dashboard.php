
<?php $title = "Dash"; ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Admin Dashboard</title>
	<link rel="icon" href="../../assets/favicon.ico" type="image/x-icon">
</head>
<body>
<?php include("layout/header.php"); ?>
<div style="padding: 2% 10%;">
    <h2>Welcome, <?php echo $username; ?></h2>
    <?php include("sales.php"); ?>
	</div>

</body>
</html>
