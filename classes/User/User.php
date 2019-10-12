<?php
namespace User;
use \PDO;

class User {
	use dbConnectionTrait;

	private $_username;

	//Controle of de auteur is ingelogd:
	public function isAuthor() { 
		try {
			if(!isset($_SESSION['id'])) {$_SESSION['id'] = 0;}
			
			$ps = $this->_db->prepare("SELECT is_author FROM gebruikers WHERE id=:id");
			$ps->execute([':id' => $_SESSION['id']]);
			$ps->setFetchMode(PDO::FETCH_ASSOC);	
			$row = $ps->fetch();
			
			if(!$row) { return false; }
			return $row['is_author'] == true;		
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	//Controle of er is ingelogd:
	public function isLogged() {
		return isset($_SESSION['logged']) && $_SESSION['logged'] == true;	
	}
	
	//Controle of het wachtwoord correct is:
	public function passwordCheck(string $email, string $password) { 
		try {
			$ps = $this->_db->prepare("SELECT password, id, is_author FROM gebruikers WHERE email=:email");
			$ps->bindParam(':email', $email);
			$ps->execute();			
			$users = $ps->fetchAll(PDO::FETCH_ASSOC);
			if (count($users) > 0) {
				foreach ($users as $user) {
					if (password_verify($password, $user['password'])) {
						$_SESSION['id'] = $user['id'];
						$_SESSION['email'] = $email;
						
						return true;
					}
				}	
			} else {
				return false;
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	//Controle of de gebruikersnaam al bestaat:
	public function doesUsernameExist($name) {
		try {
			$query = "SELECT g.name FROM gebruikers g WHERE g.name = :username;";
			$ps = $this->_db->prepare($query);
			$ps->execute([':username' => $name]);
			$ps->setFetchMode(PDO::FETCH_ASSOC);
			return $ps->fetchAll();
		} 
		catch(PDOException $e) {
			echo $e->getMessage();
		}		
	}

	//Voeg een gebruiker toe:
	public function addUser(string $name, string $password, string $email) {
		try {
			$ps = $this->_db->prepare("INSERT INTO gebruikers (name, password, email) VALUES (:name, :password, :email)");
			$ps->execute([':name' => $name, ':password' => password_hash($password, PASSWORD_DEFAULT), ':email' => $email]);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	//Krijg de gebruikersnaam:
	public function getUserName(string $email) {
		try {
			$query = "SELECT g.name FROM gebruikers g WHERE g.email = :email;";
			$ps = $this->_db->prepare($query);
			$ps->execute([':email' => $email]);
			$ps->setFetchMode(PDO::FETCH_ASSOC);
			return $ps->fetchAll()['0']['name'];
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	//Krijg de id van de gebruiker:
	public function getUserId($username) {
		try {
			$query = "SELECT g.id FROM gebruikers g WHERE g.name = :username;";
			$ps = $this->_db->prepare($query);
			$ps->execute([':username' => $username]);
			$ps->setFetchMode(PDO::FETCH_ASSOC);
			return $ps->fetchAll()['0']['id'];
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
}

?>