<?php
session_start();
require_once('scripts/autoload.php');
$_SESSION['connected'] = false;

if (isset($_POST['connect'])) {	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$host = $_POST['host'];

	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];
	$_SESSION['host'] = $_POST['host'];

	header('Location: index.php');	
}

?>
<!DOCTYPE html>
<html lang="nl-NL">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-commerce website: Database Verbinding</title>
	<style>
		body {
			font-family: Verdana;
		}
		fieldset {
			background-color: #F2F2F2;
			width: 300px;
			margin: 200px auto;
		}
		legend {
			margin-left: 10px;
		}
		h4 {
			padding: 5px;
		}
		label {
			display: block;
			padding-bottom: 2px;
			margin-left: 7px;
		}
		input, select, textarea {
			margin-bottom: 20px;
			display: block;
			border-radius: 3px;
			font-size: 18px;
			margin-left: 5px;
		}
		textarea {
			margin-right: 20px;
			resize: none;
		}
		input[type="submit"]:hover {
			cursor: pointer;
		}
	</style>
</head>
<body >
	<main>					
		<form method="POST" enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF'];?>" class="connectdbform">
			<fieldset>
				<legend><h4>Database Verbinden</h4></legend>
				<div class="form-group">
					<label for="name">Gebruikersnaam:</label>
					<input type="text" id="username" name="username" required value="<?=$username ?? '';?>">
				</div>
				<div class="form-group">
					<label for="password">Wachtwoord:</label>
					<input type="password" id="password" name="password" value="<?=$password ?? '';?>">
				</div>   
				<div class="form-group">
					<label for="host">Host:</label>
					<input type="text" id="host" name="host" required value="<?=$host ?? '';?>">
				</div>  
				<!--<div class="form-group">	
					<label>SQL-bestand:</label>
					<input type="file" name="file" id="file" class="inputfile" />
				</div>-->                        
				<div class="form-group">				
					<input type="submit" name="connect" value="Verbinden">
				</div>
			</fieldset>
		</form>
	</main>
</body>
</html>