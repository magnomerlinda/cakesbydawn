<!DOCTYPE html>
<html lang="en">
<title>Cake by Dawn - Home</title>
<link rel="icon" href="assets/favicon.ico" type="image/x-icon">
<!-- header -->
<?php include("layout/layout.php"); ?>
<link rel="stylesheet" href="style/main.css">
<link rel="stylesheet" href="style/main_index2.css">
<body>
<!-- menu -->
<?php include("layout/menu.php"); ?>

<!-- body -->
<div class="container">
    <!-- content -->
<?php include("components/indexc1.php"); ?>

</div>

<?php include("components/map/map.php"); ?>

<!-- footer -->
<?php include("layout/footer.php"); ?>
<script>
    document.querySelector('.menu-icon').addEventListener('click', function() {
        document.querySelector('.menu-items').classList.toggle('active');
    });
</script>
</body>
</html>
