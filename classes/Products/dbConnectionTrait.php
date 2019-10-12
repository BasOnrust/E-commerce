<?php
namespace Products;
use \PDO;

trait dbConnectionTrait {
	static private $dbInstance = false;
	
	static public function makeConnection() {
		if (!self::$dbInstance) {
			$username = $_SESSION['username'];
			$password = $_SESSION['password'];
			$host = $_SESSION['host'];
			$dbname = 'supermarkt';
			
			try {
				self::$dbInstance = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
				self::$dbInstance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}			
		}
		return self::$dbInstance;
	}
	
	public function __construct() {	
		$this->_db = self::makeConnection();
	}
}	

?>