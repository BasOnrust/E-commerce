<?php
session_start();
require_once('scripts/autoload.php');
$products = new Products\Products();
$user = new User\User();

if(isset($_SESSION['user']) && $_SESSION['logged']) {
	$userid = $user->getUserId($_SESSION['user']);
	$producten = $products->getUserProducts($userid);

	if(empty($producten)) {
		$producten = ''; 
	} else {
		$prijs = 0;
		foreach ($producten as $product) {
			$prijs+= $product['prijs'];
		}

		if (preg_match('/[0-9]+\.[0-9]$/', $prijs)) {
			$prijs = $prijs.'0';
		} 

		if(isset($_POST['delete'])) {
			$product_value = explode("_", $_POST['delete']);
			$products->removeShoppingCartProduct($product_value[0], $product_value[1]);
			header('Location: http://localhost/E-commerce/winkelwagen.php');
		}

		$producten = $products->showShoppingCartProducts($producten);
		$product_amount = $products->getNumberOfShoppingCartProducts();
	}
} else {
	$shopcart = '<p style="margin-left: 430px;" >Log in om toegang te krijgen tot uw winkelmand.</p>';
}	

require_once('scripts/unsetlogout.php');
require_once('scripts/userarray.php');
require_once('scripts/navmainarray.php');

?>

<!DOCTYPE html>
<html lang="nl-NL">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-commerce website: Over Mij</title>
    <link rel="stylesheet" href="css/font-awesome-5.8.2.min.css">
    <link rel="stylesheet" href="css/stylesheet.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/menu_animation.js"></script>
	<style>
		main {
			margin-top: 100px;
		}
		form #title-group h2 {
			width: 380px;
		}
		footer {
    		margin-top: 50px;
		}
	</style>
</head>
<body>
	<?php require_once('scripts/header.php'); ?>
	<main>
		<?php
			if(isset($shopcart)) { 
				echo $shopcart; 
			} else {
		?>
		<form method="POST" action="<?=$_SERVER['PHP_SELF'];?>" class="shopcartform">
			<div id="title-group">
				<h2>Producten in de winkelmand</h2>
			</div>
			<div class="shopcart-upper">
				<ul>
					<li>Producten</li>
					<li>Hoeveelheid</li>
					<li>Prijs</li>
				</ul>
			</div>
			<div class="shopcart-mid">
				<?= $producten = isset($producten) ? $producten : ''; ?>
			</div>
			<div class="shopcart-lower">
				<ul>
					<li><?= isset($product_amount) ? $product_amount : '0'; ?></li>
					<li><?= isset($prijs) ? '&euro; '.$prijs : '&euro; 0.00'; ?></li>
				</ul>
			</div>
			<div class="shopcart-buttons">
			
			</div>
		</form>
		<?php
			}
		?>
	</main>
	<?php require_once('scripts/footer.php'); ?>
</body>
</html>     