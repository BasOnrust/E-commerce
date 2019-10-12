<?php
session_start();
require_once('scripts/autoload.php');
$products = new Products\Products();
$user = new User\User();

require_once('scripts/shopcartprice.php');
require_once('scripts/unsetlogout.php');
require_once('scripts/userarray.php');
require_once('scripts/navmainarray.php');
?>
<!DOCTYPE html>
<html lang="nl-NL">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-commerce website: Home</title>
    <link rel="stylesheet" href="css/font-awesome-5.8.2.min.css">
    <link rel="stylesheet" href="css/stylesheet.css">
	<link href="https://fonts.googleapis.com/css?family=Jua" rel="stylesheet">
    <script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/menu_animation.js"></script>
	<style>
		.image-group {			
			text-align: center;
		}
		h1, h2 {
			font-family: 'Jua', sans-serif;
			border-bottom: 2px solid #eeeeee;
			padding-bottom: 20px;
			margin-top: -30px;
		}
		h1 {
			border-top: 2px solid #eeeeee;
			padding-top: 30px;
			margin-top: 55px;
		}
		.title-group {
			position: absolute;
			margin-top: 140px;
			width: 100%;
			text-align: center;
			color: #ffffff;
			font-size: 46px;
		}	
	</style>
</head>
<body>
	<?php require_once('scripts/header.php'); ?>
	<main>	
		<div class="title-group">
			<h1>Groente en Fruit</h1>
			<h2>E-commerce Website</h2>
		</div>				
		<div class="image-group">
			<img src="images/GroenteFruit.png" alt="Groente en Fruit">
		</div>
	</main>
	<?php require_once('scripts/footer.php'); ?>
</body>
</html>     