<?php
session_start();
require_once('scripts/autoload.php');
$products = new Products\Products();
$user = new User\User();

require_once('scripts/shopcartprice.php');
require_once('scripts/unsetlogout.php');
require_once('scripts/userarray.php');
require_once('scripts/navmainarray.php');

switch(isset($_GET["cnm"]) ? $_GET["cnm"] : '') {
	case "g":
		$cid = 1;
		$catname = "Groente";
		$check1 = "check-";
		break;
	case "f":
		$cid = 2;
		$catname = "Fruit";
		$check2 = "check-";
		break;
	case "ns" || "ns_f" || "ns_g":
		$cid = 3;
		$check3 = "check-";
		break;
	default:	
}

$products->setSortName(isset($_GET["cnm"]) ? $_GET["cnm"] : '');
$products->setSortId((isset($_GET["sid"]) ? ($_GET["sid"]) : ''));
$products->getSortNames(isset($_GET["cnm"]) ? $cid : '', isset($catname) ? $catname : '');

?>
<!DOCTYPE html>
<html lang="nl-NL">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-commerce website: Toevoegen</title>
    <link rel="stylesheet" href="css/font-awesome-5.8.2.min.css">
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/menu_animation.js"></script>
    <script>
		$(document).ready(function() {
			$('.integers').on('change',function() {
				let priceint = $(".integers option:selected").text();
				0 == priceint ? $(".addform input[type=number]").attr('min', 1) : $(".addform input[type=number]").attr('min', 0);
    		});

			$(".addform input[type=number]").keypress(function(e) {
				let keyCode = e.which;
				let pricedecimal = $(this).val();
				if((keyCode != 8 || keyCode == 32 ) && (keyCode < 48 || keyCode > 57)) { return false; } 
				if(/^[^%]{2,}$/.test( pricedecimal)) { return false; }	
			});

			$('.addform #file').on('change',function() {
				$(".addform #filecheck").css("opacity", "0.9");
    		});
		});
    </script>
</head>
<body>
	<?php require_once('scripts/header.php'); ?>
	<main>					
		<form method="POST" enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF'].(isset($_GET["cnm"]) ? ('?cnm='.$_GET["cnm"]) : '').(isset($_GET["sid"]) ? ('&sid='.$_GET["sid"]) : ''); ?>" class="addform">
			<div id="title-group">
				<h2>Toevoegen</h2>
			</div>
			<div class="form-group">
				<ul class="options">
				  <li><a href="toevoegen.php?cnm=g"><i class="far fa-<?= $check1 ?? '' ?>circle"></i><span>Groente</span></a></li>
				  <li><a href="toevoegen.php?cnm=f"><i class="far fa-<?= $check2 ?? '' ?>circle"></i><span>Fruit</span></a></li>
				  <li><a href="toevoegen.php?cnm=ns"><i class="far fa-<?= $check3 ?? '' ?>circle"></i><span>Nieuwe soort</span></a></li>
				</ul>
			</div>	
			<?php
				if(($_SERVER['REQUEST_URI'] == '/E-commerce/toevoegen.php') || (isset($_POST['addproduct']) ? $_POST['addproduct'] : '') || (isset($_POST['addsort']) ? $_POST['addsort'] : '')) {
			?>
			<div class="form-group-fix">				
				<label>Selecteer wat u wilt toevoegen.</label>
			</div>
			<?php
					if(isset($_POST['addproduct']) ? $_POST['addproduct'] : '') {
						$name = ucfirst(strtolower($_POST['name']));	
						$priceint = $_POST['priceint'];
						$pricedec = preg_match('/^\d$/', $_POST['pricedec']) ? $_POST['pricedec'].'0' : $_POST['pricedec'];
						$price = $priceint.'.'.$pricedec;
						$amount = $_POST['amount'];
						$products->getSearchedProduct(ucfirst(strtolower($name)));

						if($products->doesProductExist()) {
							$html = '<div class="form-group-fix"><label>Het product bestaat al. Probeer het opnieuw.</label></div>';
							$html .= '<div class="form-group"><input type="submit" name="back" value="Terug"></div>';
							echo $html;
						} else {
							if(!(preg_match('/^[a-zA-Z]+$/', $name))) {
								echo '<div class="form-group-fix"><label>Gebruik een productnaam met alleen letters.</label></div>';
								echo '<div class="form-group"><input type="submit" name="back" value="Terug"></div>';
							} else {
								$path_info = pathinfo($_FILES['file']['name']);
								$file = $path_info['filename'].'.png';

								if ($path_info['extension'] != 'jpg' && $path_info['extension']!= 'png' && $path_info['extension']!= 'gif' && $path_info['extension']!= 'jpeg') {
									echo '<div class="form-group-fix"><label>Uw bestand heeft geen toegestaan bestandstype.</label></div>';
									echo '<div class="form-group"><input type="submit" name="back" value="Terug"></div>';
								} elseif ($_FILES['file']['size'] > 1048576) {
									echo '<div class="form-group-fix"><label>Uw bestand is te groot (groter dan 1MB).</label></div>';
									echo '<div class="form-group"><input type="submit" name="back" value="Terug"></div>';
								} else {
									//echo '<p>Cid: '.$cid.'</p><p>Sid: '.(isset($_GET["sid"]) ? $_GET["sid"] : '').'</p><p>Name: '.$name.'</p><p>Price: '.$price.'</p><p>Amount: '.$amount.'</p><p>File: '.$file.'</p>';
									echo $products->addProduct($cid, (isset($_GET["sid"]) ? $_GET["sid"] : ''), $name, $price, $amount, $file);
								}
							} 			
						}	
					}
					if(isset($_POST['addsort']) ? $_POST['addsort'] : '') {
						$sortname = ucfirst(strtolower($_POST['sortname']));

						if($products->doesSortExist($sortname)) {
							$html = '<div class="form-group-fix"><label>De soort bestaat al. Probeer het opnieuw.</label></div>';
							$html .= '<div class="form-group"><input type="submit" name="back" value="Terug"></div>';
							echo $html;
						} else {
							if(!(preg_match('/^[a-zA-Z]+$/', $sortname))) {
								echo '<div class="form-group-fix"><label>Gebruik een naamsoort met alleen letters.</label></div>';
								echo '<div class="form-group"><input type="submit" name="back" value="Terug"></div>';
							} else {
								$cid = ((isset($_GET["cnm"]) ? $_GET["cnm"] : '') == "ns_g") ? 1 : 2;
								//echo '<p>Cid: '.$cid.'</p><p>Name: '.$sortname.'</p>';
								echo $products->addSortProduct($cid, $sortname);
							}
						}	
					}
				} elseif((((isset($_GET["cnm"]) ? $_GET["cnm"] : '') == 'g') || ((isset($_GET["cnm"]) ? $_GET["cnm"] : '') == 'f')) && (!isset($_GET["sid"]))) {	
			?>
			<div class="selecties">        
				<div class="dropdown">
				<button class="dropbtn"><span>Soorten </span><i class="fas fa-sort-down"></i></button>
					<?= $products->showSortNames(false); ?>     
				</div>
			</div>
			<?php
				} elseif((isset($_GET["sid"]) ? $_GET["sid"] : '')) {
			?>
			<div class="selecties">        
				<div class="dropdown">
				<button class="dropbtn"><span>Soorten </span><i class="fas fa-sort-down"></i></button>
					<?= $products->showSortNames(false); ?>     
				</div>
			</div>
			<div class="form-group">
				<label for="name">Productnaam:</label>
				<input type="text" id="name" name="name" required value="<?=$name ?? '';?>">
			</div>
			<div class="form-group price">
				<label for="price">Prijs:</label>
				<span id="mrg">€&nbsp;</span>     
					<select class="integers" name="priceint">
						<?php for($x = 0; $x <= 9; $x++) {echo '<option value="'.$x.'">'.$x.'</option>';} ?>
					</select>
				<span>&nbsp;,&nbsp;</span>
				<input type="number" name="pricedec" min="1" max="99" pattern="\d" required value="<?=$pricedec ?? '';?>">
			</div>	
			<div class="form-group">
				<label for="amount">Hoeveelheid:</label>
				<input type="amount" id="amount" name="amount" required value="<?=$amount ?? '';?>">
			</div>  
			<div class="form-group">	
				<label>Afbeelding:</label>
				<input type="file" name="file" id="file" class="inputfile" />
				<label for="file" id="filestyle">Upload afbeelding</label>
				<i id="filecheck" class="fas fa-clipboard-check"></i>
			</div>
			<div class="form-group">				
				<input type="submit" name="addproduct" value="Toevoegen">
			</div>
			<?php
				} elseif((isset($_GET["cnm"]) ? $_GET["cnm"] : '') == 'ns') { 
			?>
			<div class="form-group-fix">
				<ul class="options">
					<li><a href="toevoegen.php?cnm=ns_g"><i class="far fa-<?= $check4 ?? '' ?>circle"></i><span>Groente</span></a></li>
					<li><a href="toevoegen.php?cnm=ns_f"><i class="far fa-<?= $check5 ?? '' ?>circle"></i><span>Fruit</span></a></li>
				</ul>
			</div>
			<?php
				} elseif(((isset($_GET["cnm"]) ? $_GET["cnm"] : '') == 'ns_g') || ( (isset($_GET["cnm"]) ? $_GET["cnm"] : '') == 'ns_f')) { 
					if(isset($_GET["cnm"])) {
						if('ns_g' == $_GET["cnm"]) {
							$check4 = "check-";
						} elseif('ns_f' == $_GET["cnm"]) {
							$check5 = "check-";
						}
					}
			?>
			<div class="form-group-fix">
				<ul class="options">
					<li><a href="toevoegen.php?cnm=ns_g"><i class="far fa-<?= $check4 ?? '' ?>circle"></i><span>Groente</span></a></li>
					<li><a href="toevoegen.php?cnm=ns_f"><i class="far fa-<?= $check5 ?? '' ?>circle"></i><span>Fruit</span></a></li>
				</ul>
			</div>
			<div class="form-group">
				<label for="sortname">Soortnaam:</label>
				<input type="text" id="sortname" name="sortname" required value="<?=$sortname ?? '';?>">
			</div>  
			<div class="form-group">				
				<input type="submit" name="addsort" value="Toevoegen">
			</div>  
			<?php
				} else {} 
			?>
		</form>
	</main>
	<?php require_once('scripts/footer.php'); ?>
</body>
</html>   