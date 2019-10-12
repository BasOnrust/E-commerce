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
    <title>E-commerce website: Over Mij</title>
    <link rel="stylesheet" href="css/font-awesome-5.8.2.min.css">
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/menu_animation.js"></script>
	<style>
		.image-group img {
			width: 40%;
			border-radius: 1px;
    		box-shadow: 0 0 3px 1px #989898a3;
		} 
		.aboutme {
			margin-top: 120px;
    		margin-left: 500px;
		}
		.paragraph-group p {
			font-size: 17px;
			color: #555555e3;
		}
		.paragraph-group {
			float: left;
			width: 40%;
			margin-top: -10px;
		}
		.image-group {
			float: right;
			width: 50%;
			margin-right: 60px;
		}
		#title-group {
			width: 180px;
			text-align: center
		}
	</style>
</head>
<body>
	<?php require_once('scripts/header.php'); ?>
	<main>
		<div class="aboutme">
			<div id="title-group">
				<h2>Over Bas</h2>
			</div>
			<div class="paragraph-group">
				<p>Ik ben een beginnend Front- en backend webdeveloper die op zoek is naar een nieuwe uitdaging. Het afgelopen jaar heb ik ervaring opgedaan met Javascript, JQuery, HTML, CSS, PHP, Bootstrap, OOP, SQL en SEO. De meeste van deze programma’s heb ik toegepast op mijn e-commerce website. Begin 2019 heb ik de opleiding Webdeveloper back-end bij SlimInICT met goed gevolg afgerond. Daarna heb ik de cursus Software Testengineer gevolgd. Eerder heb ik onder meer de mbo-opleiding Juridisch Medewerker gedaan. Daar heb ik ook een extra certificaat Microsoft Office Specialist gehaald.</p>
				<p>Ik zou graag mijn opgedane ervaringen in de praktijk willen toepassen. Op stages ben ik altijd een gewaardeerde medewerker die, wanneer ik opdrachten kreeg, zo goed mogelijk uitvoerde. Ik zal zeker de eerste periode enige begeleiding nodig hebben bij de uitvoering van de mij opgedragen taken. Ik ben precies, creatief en analytisch. Ik heb een voorkeur voor overzichtelijke websites, met een gestructureerde opbouw, waarbinnen het makkelijk en logisch navigeren is. Ik nodig u uit om mijn e-commerce website te bekijken.</p>
			</div>
			<div class="image-group">
				<img src="images/BasOnrust.jpg" alt="Bas Onrust">
			</div>
		</div>
	</main>
	<?php require_once('scripts/footer.php'); ?>
</body>
</html>     