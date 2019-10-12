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
    <title>E-commerce website: Aanbiedingen</title>
    <link rel="stylesheet" href="css/font-awesome-5.8.2.min.css">
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/jquery.slides.min.js"></script>
	<script src="js/menu_animation.js"></script>
	<script src="js/slides_settings.js"></script>
	<style>
		#productcontent {
			margin-top: 80px;
    		margin-left: 500px;
		} 
		#productcontent article {
			width: 33.33%;
			float: left;
		} 
		#productcontent article img {
			width: 244px;
		} 
		#productcontent .slide {
			width: 100%;
		}
	</style>
</head>
<body>
	<?php require_once('scripts/header.php'); ?>
	<main>					
		<section id="productcontent">
			<header id="title-group" style="width: 240px">
				<h2>Aanbiedingen</h2>
			</header>
			<div class="slideshow">
				<div class="slide">
					<article>
						<img src="https://www.plus.nl/INTERSHOP/static/WFS/PLUS-Site/-/PLUS/nl_NL/product/L/113948.png" alt="Witlof">
						<p>Witlof</p>
						<p>500 gram</p>
						<span>0.</span>
						<sup>89</sup>
					</article>
					<article>
						<img src="https://www.plus.nl/INTERSHOP/static/WFS/PLUS-Site/-/PLUS/nl_NL/product/L/113945.png" alt="Winterpeen">
						<p>Winterpeen</p>
						<p>1 kilo</p>
						<span>0.</span>
						<sup>75</sup>
					</article>
					<article>
						<img src="https://www.plus.nl/INTERSHOP/static/WFS/PLUS-Site/-/PLUS/nl_NL/product/L/338955.png" alt="Walnoten">
						<p>Walnoten</p>
						<p>75 gram</p>
						<span>2.</span>
						<sup>59</sup>
					</article>
				</div>
				<div class="slide">
					<article>
						<img src="https://www.plus.nl/INTERSHOP/static/WFS/PLUS-Site/-/PLUS/nl_NL/product/L/113882.png" alt="Trostomaten">
						<p>Trostomaten</p>
						<p>500 gram</p>
						<span>0.</span>
						<sup>89</sup>
					</article>
					<article>
						<img src="https://www.plus.nl/INTERSHOP/static/WFS/PLUS-Site/-/PLUS/nl_NL/product/L/983671.png" alt="Tijm">
						<p>Tijm</p>
						<p>1 stuk</p>
						<span>0.</span>
						<sup>89</sup>
					</article>
					<article>
						<img src="https://www.plus.nl/INTERSHOP/static/WFS/PLUS-Site/-/PLUS/nl_NL/product/L/984773.png" alt="Sugarsnaps">
						<p>Sugarsnaps</p>
						<p>150 gram</p>
						<span>1.</span>
						<sup>39</sup>
					</article>
				</div>
				<div class="slide">
					<article>
						<img src="https://www.plus.nl/INTERSHOP/static/WFS/PLUS-Site/-/PLUS/nl_NL/product/L/114032.png" alt="Sperziebonen">
						<p>Sperziebonen</p>
						<p>500 gram</p>
						<span>1.</span>
						<sup>69</sup>
					</article>
					<article>
						<img src="https://www.plus.nl/INTERSHOP/static/WFS/PLUS-Site/-/PLUS/nl_NL/product/L/970399.png" alt="Snijbonen">
						<p>Snijbonen</p>
						<p>400 gram</p>
						<span>1.</span>
						<sup>49</sup>
					</article>
					<article>
						<img src="https://www.plus.nl/INTERSHOP/static/WFS/PLUS-Site/-/PLUS/nl_NL/product/L/415508.png" alt="Selderij">
						<p>Selderij</p>
						<p>30 gram</p>
						<span>0.</span>
						<sup>69</sup>
					</article>
				</div>
      		</div>
		</section>
	</main>
	<?php require_once('scripts/footer.php'); ?>
</body>
</html> 