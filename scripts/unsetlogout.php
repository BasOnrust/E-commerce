<?php
	if(isset($_POST['logout'])) {	
		unset($_SESSION['logged']);
		unset($_SESSION['user']);
		unset($_SESSION['id']);
		header('Location: login.php');
		exit();
	}
?>