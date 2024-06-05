<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store</title>

	<link rel="icon" href="../../assets/favicon.ico" type="image/x-icon">

</head>
<body style="padding:2% 6%;">
    <h2>Welcome to Our Store</h2>
	
    <p Style="color: #AABEC0;">Here you can browse and purchase our products.</p>
	<a href="showcart.php" style="
	padding: 10px 10px;
	color: white;
	background-color: orange;
	border-radius: 7px;
	text-decoration: none;
	box-shadow: 5px 5px 8px 2px rgba(0, 0, 0, 0.3);
	margin: 10px 10px;
	">show <span style=""><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bag-heart" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0M14 14V5H2v9a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1M8 7.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132"/>
</svg></span></a>
<br>
    <div class="container" ><br><br>
        <div class="p" >
            <?php include "../../db_connection.php"; ?>
            <?php include("product/product.php"); ?>
        </div>
  
    <div><br>
	<a href="../../" style="background-color: black; color: white; padding: 10px 20px; border-radius: 7px; box-shadow: 2px 2px 25px 5px rgba(0, 0, 0, 0.3);text-decoration: none;">back</a>
	</div>
</body>
</html>
