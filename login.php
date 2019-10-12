<?php
session_start();
require_once('scripts/autoload.php');
$user = new User\User();
$_SESSION['logged'] = false;

if (isset($_POST['login'])) {	
	$password = $_POST['password'];
	$email = $_POST['email'];
	$errors = array();
	
	if (!preg_match('/[a-zA-Z]+/', $password) || !preg_match('/[0-9]+/', $password)) {
		$errors[] = 'Password must contain at least one letter and one number.';
	}
	if (!preg_match('/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD', $email)) {
		$errors[] = 'Please enter a valid email address.';
	}
	
	if (count($errors) > 0) {
		$statusMsg = '<div class="form-group-fix"><label>';
		foreach ($errors as $error) {
			$statusMsg .= $error;
		}	
		$statusMsg .= '</label></div>';
	} else {	
		if ($user->passwordCheck($_POST['email'], $_POST['password'])) {
			$_SESSION['logged'] = true;
			$_SESSION['user'] = $user->getUserName($_POST['email']);

			if($user->isAuthor() && $user->isLogged()) {
				header('Location: toevoegen.php');
			} else {
				header('Location: products.php');
			}
			exit();
		} else {
			$statusMsg = '<div class="form-group-fix"><label>Uw wachtwoord of gebruikersnaam is incorrect.</label></div>';
		}	
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
    <title>E-commerce website: Login</title>
    <link rel="stylesheet" href="css/font-awesome-5.8.2.min.css">
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/menu_animation.js"></script>
	<script src="js/scripts.js"></script>
	<style> 
		::placeholder { 
			font-style: italic;
			opacity: 0.4;
		}  
		:-ms-input-placeholder { 
			font-style: italic;
			opacity: 0.4;
		}  
		::-ms-input-placeholder { 
			font-style: italic;
			opacity: 0.4;
		} 
	</style> 
</head>
<body>
	<?php require_once('scripts/header.php'); ?>
	<main>					
		<form method="POST" action="<?=$_SERVER['PHP_SELF'];?>" class="loginform"  style="margin:<?= (isset($statusMsg) ? '140' : '') ?>px auto auto;">
			<div id="title-group">
				<h2>Login</h2>
			</div>
			<div class="form-group">
				<label for="email">E-mailadres:</label>
				<input type="email" id="email" name="email" value="<?=$email ?? '';?>" placeholder="author@email.com">
			</div> 
			<div class="form-group">
				<label for="password">Wachtwoord:</label>
				<input type="password" id="password" name="password" value="<?=$password ?? '';?>" placeholder="wwauthor1">
			</div>                           
			<div class="form-group">				
				<input type="submit" name="login" value="Log in">
			</div>
		    <div class="form-group">
				<a href="#">Wachtwoord vergeten?</a>
			</div>
			<?= (isset($statusMsg) ? $statusMsg : '') ?>
		</form>
	</main>
	<?php require_once('scripts/footer.php');  ?>
</body>
</html>

    