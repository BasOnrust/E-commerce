<?php
session_start();
require_once('scripts/autoload.php');
$user = new User\User();

if (isset($_POST['register'])) {
	$name = $_POST['name'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$errors = array();
	
	if (empty($name) || strlen($name)  < 3) {
		$errors[] = 'De naam moet minstens 3 karakters lang zijn.';
	}
	if (!preg_match('/[a-zA-Z]+/', $password) || !preg_match('/[0-9]+/', $password)) {
		$errors[] = 'Het wachtwoord moet minstens een letter en een cijfer bevatten.';
	}
	if (!preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $email)) {
		$errors[] = 'Voer een juist emailadres in.';
	}
	if(!empty($user->doesUsernameExist($name))) {
		$errors[] = 'Deze gebruiksnaam ' .$name. ' bestaat al.';
	} 
	
	if(count($errors) > 0) {
		$statusMsg = '<div class="form-group-fix"><label>';
		foreach ($errors as $error) {
			$statusMsg .= $error . '<br>';
		}
		$statusMsg .= '</label></div>';
	} else {
		$user->addUser(htmlspecialchars($name), htmlspecialchars($password), htmlspecialchars($email));
		$_SESSION['user'] = $name;
		$_SESSION['logged'] = true;	
		header('Location: products.php');
		exit();		
	}
}

require_once('scripts/userarray.php');
require_once('scripts/navmainarray.php');

?>
<!DOCTYPE html>
<html lang="nl-NL">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-commerce website: Registreren</title>
    <link rel="stylesheet" href="css/font-awesome-5.8.2.min.css">
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/menu_animation.js"></script>
</head>
<body>
	<?php require_once('scripts/header.php'); ?>
	<main>					
		<form method="POST" action="<?=$_SERVER['PHP_SELF'];?>" class="registerform">
			<div id="title-group">
				<h2>Registeren</h2>
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
				<label for="password">Wachtwoord:</label>
				<input type="password" id="password" name="password" required value="<?=$password ?? '';?>">
			</div>                           
			<div class="form-group">				
				<input type="submit" name="register" value="Registreer">
			</div>
			<?= ((isset($statusMsg)) ? $statusMsg : '') ?>
		</form>
	</main>
	<?php require_once('scripts/footer.php'); ?>
</body>
</html>

    