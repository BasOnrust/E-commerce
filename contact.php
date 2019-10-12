<?php
session_start();
require_once('scripts/autoload.php');
$products = new Products\Products();
$user = new User\User();

if (isset($_POST['send'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$topic = $_POST['topic'];
	$message = $_POST['message'];
	$errors = array();
	
	if (empty($name) || strlen($name)  < 3) {
		$errors[] = 'De naam moet minstens 3 karakters lang zijn.';
	}
	if (!preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $email)) {
		$errors[] = 'Voer een juist emailadres in.';
	}
	if (empty($topic) || strlen($topic)  < 3) {
		$errors[] = 'Het onderwerp moet minstens 3 karakters lang zijn.';
	}
	if (empty($message) || strlen($message)  < 3) {
		$errors[] = 'Het bericht moet minstens 3 karakters lang zijn.';
	}
	
	if(count($errors) > 0) {
		$statusMsg = '<div class="form-group-fix"><label>';
		foreach ($errors as $error) {
			$statusMsg .= $error . '<br>';
		}
		$statusMsg .= '</label></div>';
	} 
}

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
    <title>E-commerce website: Contact</title>
    <link rel="stylesheet" href="css/font-awesome-5.8.2.min.css">
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/menu_animation.js"></script>
    <script>
		$(document).ready(function() {
			if (!$(".form-group-fix")[0]) {
				let name = $(".form-group:nth-of-type(2) input").val();
				let mail = $(".form-group:nth-of-type(3) input").val();
				let topic = $(".form-group:nth-of-type(4) input").val();
				let message = $(".form-group:nth-of-type(5) textarea").text();
		
				if (name && mail && topic && message) {
					showcontent = new Array('U heeft het volgende ingevuld: ', '','Naam: '+name, 'E-mailadres: '+mail, 'Onderwerp: '+topic, 'Bericht: '+message);
					alert(showcontent.join('\n'));	
				}
			} 
		});
	</script>
	<style>
		footer {
			margin-top: 51px;
		} 
		textarea {
			min-height: 78px;
		}
	</style>
</head>
<body>
	<?php require_once('scripts/header.php'); ?>
	<main>					
		<form method="POST" action="<?=$_SERVER['PHP_SELF'];?>" class="contactform">
			<div id="title-group">
				<h2>Contactformulier</h2>
			</div>
			<div class="form-group">
				<label for="name">Naam:</label>
				<input type="text" id="name" name="name" required value="<?=$name ?? '';?>">
			</div>
			<div class="form-group">
				<label for="email">E-mailadres:</label>
				<input type="email" id="email" name="email" required value="<?=$email ?? '';?>">
			</div>  
			<div class="form-group">
				<label for="topic">Onderwerp:</label>
				<input type="text" id="topic" name="topic" required value="<?=$topic ?? '';?>">
			</div>  
			<div class="form-group">
				<label for="message">Bericht:</label>
				<textarea name="message" rows="4" cols="40"><?=$message ?? '';?></textarea>
			</div>                            
			<div class="form-group">				
				<input type="submit" name="send" value="Verzenden">
			</div>
			<?= ((isset($statusMsg)) ? $statusMsg : '') ?>
		</form>
	</main>
	<?php require_once('scripts/footer.php'); ?>
</body>
</html>     