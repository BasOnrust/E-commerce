<?php
namespace Products;
use \PDO;

class Products {
	use dbConnectionTrait;
	
	private $_products;
	private $_sort_names;
	private $_sort_name;
	private $_category_names;
	private $_category_id;
	private $_soorten_id;
	private $_naam_product;
	private $_limit;
	
	//Krijg alle producten:
	public function getAllProducts($order_name, $order_direction, $cid, $page) {
		try {
			$limit = $page*9-9;
			$query = "SELECT naam_product, prijs, hoeveelheid, afbeelding FROM producten ORDER BY $order_name $order_direction LIMIT $limit, 9;";
			$ps = $this->_db->prepare($query);
			$ps->execute();
			$ps->setFetchMode(PDO::FETCH_ASSOC);
			$this->_products = $ps->fetchAll();
			$this->_category_id = $cid;
			$this->_page = $page;
		} 
		catch(PDOException $e){
			echo $e->getMessage();
		}		
	}

	//Krijg alle producten bij een specifieke categorie:
	public function getCategoryProducts($category_id, $order_name, $order_direction, $page) {		
		try {
			$limit = $page*9-9;
			$query = "SELECT p.naam_product, p.prijs, p.hoeveelheid, p.afbeelding FROM producten p 
				LEFT JOIN soorten s ON p.category_id = s.id 
				WHERE p.category_id = :category_id
				ORDER BY $order_name $order_direction
				LIMIT $limit, 9;";
			$ps = $this->_db->prepare($query);
			$ps->execute([':category_id' => $category_id]);
			$ps->setFetchMode(PDO::FETCH_ASSOC);
			$this->_products = $ps->fetchAll();
			$this->_category_id = $category_id;
			$this->_page = $page;
		} 
		catch(PDOException $e) {
			echo $e->getMessage();
		}		
	}	

	//Krijg alle categorienamen:
	public function getCategoryNames() {
		try {
			$ps = $this->_db->query("SELECT c.naam_category, c.id FROM categories c;");
			$ps->setFetchMode(PDO::FETCH_ASSOC);
			$this->_category_names = $ps->fetchAll();
		} 
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	//Toon alle categorienamen:
	public function showCategoryNames() {
		$html = '<ul>';
			foreach ($this->_category_names as $name) {
				$check = $this->_category_id == $name["id"] ? 'check-' : '';
				$html .= '<li><a href="products.php?cid='.$name["id"].'&o=p%asc&pg=1"><i class="far fa-'.$check.'square"></i></a></li>
				<li><a href="products.php?cid='.$name["id"].'&o=p%asc&pg=1"><span>'.$name["naam_category"].'</span></a></li>';		
			}
		$html .= '</ul>';
		return $html;		
	}

	//Krijg alle producten bij een specifieke soort:
	public function getSortProducts($soorten_id, $order_name, $order_direction) {
		try {
			$query = "SELECT p.naam_product, p.prijs, p.hoeveelheid, p.afbeelding FROM producten p 
				LEFT JOIN soorten s ON p.soorten_id = s.id 
				WHERE p.soorten_id = :soorten_id
				ORDER BY $order_name $order_direction;";
			$ps = $this->_db->prepare($query);
			$ps->execute([':soorten_id' => $soorten_id]);
			$ps->setFetchMode(PDO::FETCH_ASSOC);
			$this->_products = $ps->fetchAll();
			$this->_soorten_id = $soorten_id;
		} 
		catch(PDOException $e) {
			echo $e->getMessage();
		}	
	}	

	//Sla de soorten_id op:
	public function setSortId($soorten_id) {
		$this->_soorten_id = $soorten_id;
	}
	
	//Sla de soort_name op:
	public function setSortName($cnm) {
		return $this->_sort_name = $cnm;
	}

	//Krijg categorienaam bij de bijbehorende soort:
	public function getCategoryNameBySort($sid) {	
		try {
			//$query = "SELECT DISTINCT c.naam_category, c.id FROM categories c LEFT JOIN producten p ON c.id = p.category_id WHERE c.id IN (SELECT category_id FROM producten p LEFT JOIN categories c ON p.soorten_id = c.id WHERE p.soorten_id = $sid);";
			$query = "SELECT c.naam_category, c.id FROM categories c LEFT JOIN soorten s ON c.id = s.category_id WHERE s.id = $sid";	
			$ps = $this->_db->query($query);
			$ps->setFetchMode(PDO::FETCH_ASSOC);
			return $ps->fetchAll()[0]['naam_category'];
		} 
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	//Krijg alle soortennamen:
	public function getSortNames($cid, $catname) {
		try {
			switch($catname) {
				case "Groente":
					//$query = "SELECT DISTINCT s.naam_soort, s.id FROM soorten s LEFT JOIN producten p ON s.id = p.soorten_id WHERE s.id IN (SELECT soorten_id FROM producten p LEFT JOIN soorten s ON p.category_id = s.id WHERE p.category_id = 1);";	
					$query = "SELECT s.naam_soort, s.id FROM soorten s LEFT JOIN categories c ON s.category_id = c.id WHERE s.category_id = 1";					
					break;
				case "Fruit":
					//$query = "SELECT DISTINCT s.naam_soort, s.id FROM soorten s LEFT JOIN producten p ON s.id = p.soorten_id WHERE s.id IN (SELECT soorten_id FROM producten p LEFT JOIN soorten s ON p.category_id = s.id WHERE p.category_id = 2);";	
					$query = "SELECT s.naam_soort, s.id FROM soorten s LEFT JOIN categories c ON s.category_id = c.id WHERE s.category_id = 2";
					break;
				default:
					$query = "SELECT s.naam_soort, s.id FROM soorten s;";
			}

			$ps = $this->_db->query($query);
			$ps->setFetchMode(PDO::FETCH_ASSOC);
			$fetchAll = $ps->fetchAll();
			$this->_sort_names = $fetchAll;	
		} 
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
	
	//Toon alle soortnamen:
	public function showSortNames($url) {
		$html = '<ul '.($url === true ? '' : 'class="dropdown-content"').'>';
			foreach ($this->_sort_names as $name) {
				$check = $this->_soorten_id == $name["id"] ? 'check-' : '';

				if($url === true) {
					$html .= '<li><a href="products.php?sid='.$name["id"].'&o=p%asc"><i class="far fa-'.$check.'square"></i></a></li>
					<li><a href="products.php?sid='.$name["id"].'&o=p%asc"><span>'.$name["naam_soort"].'</span></a></li>';
				} else {
					$html .= '<li><a href="toevoegen.php?cnm='.$this->_sort_name.'&sid='.$name["id"].'"><i class="far fa-'.$check.'circle"></i></a>
					<a href="toevoegen.php?cnm='.$this->_sort_name.'&sid='.$name["id"].'"><span>'.$name["naam_soort"].'</span></a></li>';
				}
			}
		$html .= '</ul>';
		return $html;	
	}
	
	//Voeg een product toe aan de database:
	public function addProduct($cid, $sid, $name, $price, $amount, $file) {
		try {	
			$query = "INSERT INTO producten (category_id, soorten_id, naam_product, prijs, hoeveelheid, afbeelding) VALUES (:category_id, :soorten_id, :naam_product, :prijs, :hoeveelheid, :afbeelding)";
			$ps = $this->_db->prepare($query);
			$ps->execute([':category_id' => $cid, ':soorten_id' => $sid, ':naam_product' => $name, ':prijs' => $price, ':hoeveelheid' => $amount, ':afbeelding' => $file]);

			$html = '<div class="form-group-fix"><label>Het product '.$name.' is succesvol toegevoegd.</label></div>';
			$html .= '<div class="form-group"><input type="submit" name="back" value="Terug"></div>';
			return $html;
		} 
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	//Voeg een product toe aan de winkelmand:
	public function addShoppingCartProduct($uid, $product) {
		try {	
			foreach ($product as $productvalue) {
				$query = "INSERT INTO winkelmanden (gebruiker_id, category_id, soorten_id, naam_product, prijs, hoeveelheid, afbeelding) VALUES (:gebruiker_id, :category_id, :soorten_id, :naam_product, :prijs, :hoeveelheid, :afbeelding);";
				$ps = $this->_db->prepare($query);
				$ps->execute([':gebruiker_id' => $uid, ':category_id' => $productvalue["category_id"], ':soorten_id' => $productvalue["soorten_id"], ':naam_product' => $productvalue["naam_product"], ':prijs' => $productvalue["prijs"], ':hoeveelheid' => $productvalue["hoeveelheid"], ':afbeelding' => $productvalue["afbeelding"]]);
			}

			return 'Het product '.$product["0"]["naam_product"].' is succesvol toegevoegd aan uw winkelmand.';
		} 
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	//Verwijder een product uit de winkelmand:
	public function removeShoppingCartProduct($product, $id) {
		try {	
			//$query = "DELETE FROM winkelmanden WHERE naam_product = :naam_product";
			$query = "DELETE FROM winkelmanden WHERE naam_product = :naam_product AND  id = :id";
			$ps = $this->_db->prepare($query);
			//$ps->execute([':naam_product' => $product]);
			$ps->execute([':naam_product' => $product, ':id' => $id]);
		} 
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	//Krijg de producten bij ingelogde gebruiker:
	public function getUserProducts($uid) {
		try {
			$query = "SELECT w.id, w.naam_product, w.prijs, w.hoeveelheid, w.afbeelding FROM winkelmanden w WHERE w.gebruiker_id = :gebruiker_id";
			$ps = $this->_db->prepare($query);
			$ps->execute([':gebruiker_id' => $uid]);
			$ps->setFetchMode(PDO::FETCH_ASSOC);
			return $ps->fetchAll();
		} 
		catch(PDOException $e) {
			echo $e->getMessage();
		}	
	}

	//Voeg een productsoort toe:
	public function addSortProduct($cid, $sortname) {
		try {	
			$query = "INSERT INTO soorten (category_id, naam_soort) VALUES (:category_id, :sortname)";
			$ps = $this->_db->prepare($query);
			$ps->execute([':category_id' => $cid, ':sortname' => $sortname]);

			$html = '<div class="form-group-fix"><label>De soort '.$sortname.' is succesvol toegevoegd.</label></div>';
			$html .= '<div class="form-group"><input type="submit" name="back" value="Terug"></div>';
			return $html;
		} 
		catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	//Krijg product met een specifieke naam:
	public function getSearchedProduct($naam_product) {
		try {
			$query = "SELECT p.naam_product, p.prijs, p.hoeveelheid, p.afbeelding FROM producten p WHERE p.naam_product = :naam_product;";
			$ps = $this->_db->prepare($query);
			$ps->execute([':naam_product' => $naam_product]);
			$ps->setFetchMode(PDO::FETCH_ASSOC);
			$this->_products = $ps->fetchAll();
			$this->_naam_product = $naam_product;
		} 
		catch(PDOException $e) {
			echo $e->getMessage();
		}	
	}

	//Krijg product met een specifieke naam:
	public function getClickedProduct($naam_product) {
		try {
			$query = "SELECT * FROM producten p WHERE p.naam_product = :naam_product;";
			$ps = $this->_db->prepare($query);
			$ps->execute([':naam_product' => $naam_product]);
			$ps->setFetchMode(PDO::FETCH_ASSOC);
			return $ps->fetchAll();
		} 
		catch(PDOException $e) {
			echo $e->getMessage();
		}	
	}

	//Controle of de product al bestaat:
	public function doesProductExist() {
		if(count($this->_products) == 1) { return true; } else { return false; }
	}

	//Controle of de soort al bestaat:
	public function doesSortExist($sortname) {
		try {
			$query = "SELECT s.naam_soort FROM soorten s WHERE s.naam_soort = :naam_soort;";
			$ps = $this->_db->prepare($query);
			$ps->execute([':naam_soort' => $sortname]);
			$ps->setFetchMode(PDO::FETCH_ASSOC);
			if(count($ps->fetchAll()) == 1) { return true; } else { return false; }
		} 
		catch(PDOException $e) {
			echo $e->getMessage();
		}		
	}

	//Toon alle verkregen producten:
	public function showRecievedProducts() {
		$html = '';
		$url =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		$fullurl = preg_replace("/((\&nm=[a-zA-Z]+)$)|((\?nm=[a-zA-Z]+)$)/", "", $_SERVER['REQUEST_URI']);	
		$token = preg_match('/(^\/E-commerce\/products.php$)|(^\/E-commerce\/products.php\?nm=[a-zA-Z]+$)/', $_SERVER['REQUEST_URI']) ? '?' : '&';

		if(count($this->_products) == 0) { $html .= '<article id="notfound"><p style="height: initial">Geen producten gevonden. Probeer het opnieuw: <a href="'.$url.'">Ga terug</a>.</p></article>'; }

		foreach ($this->_products as $product) {
			$html .= '<article>';
				$html .= '<div><img src=https://www.plus.nl/INTERSHOP/static/WFS/PLUS-Site/-/PLUS/nl_NL/product/L/'.$product["afbeelding"].' alt='.$product['naam_product'].'>';
				$html .= '<p>'.$product['naam_product'].'</p>';
				$html .= '<p>'.$product['hoeveelheid'].'</p>';			
				$cijfer = explode('.', $product['prijs'], 2)[0];
				$decimaal = explode('.', $product['prijs'], 2)[1];
				$html .= '<span>'.$cijfer.'.</span><sup>'.$decimaal.'</sup></div>';
				$html .= '<a href="'.$fullurl.$token.'nm='.$product['naam_product'].'"><i class="fas fa-plus"></i></a>';
			$html .= '</article>';
		}
		return $html;		
	}

	//Toon alle producten in de winkelmand:
	public function showShoppingCartProducts($products) {
		$this->_products = $products;
		$html = '';
		
		foreach ($products as $product) {
			$html .= '<article>';
				$html .= '<button type="submit" name="delete" value="'.$product['naam_product'].'_'.$product['id'].'"><i class="fas fa-times-circle"></i></button>';
				$html .= '<img src=https://www.plus.nl/INTERSHOP/static/WFS/PLUS-Site/-/PLUS/nl_NL/product/L/'.$product["afbeelding"].' alt='.$product['naam_product'].'>';
				$html .= '<p>'.$product['naam_product'].'</p>';
				$html .= '<p>'.$product['hoeveelheid'].'</p>';	
				$html .= '<span>&euro; '.$product['prijs'].'</span>';
			$html .= '</article>';
		}
		return $html;	
	}

	//Krijg het aantal producten in de winkelmand:
	public function getNumberOfShoppingCartProducts() {
		return count($this->_products);
	}
	
	//Krijg het aantal gevonden producten:
	public function getNumberOfProducts() {
		try {
			if(isset($this->_soorten_id) && !empty($this->_soorten_id)) {
				$query = "SELECT COUNT(p.soorten_id) AS NumberOfProducts FROM producten p LEFT JOIN soorten s ON p.soorten_id = s.id WHERE p.soorten_id = '.$this->_soorten_id.'";
			} elseif(isset($this->_category_id) && !empty($this->_category_id) && $this->_category_id != 3) {
				$query = "SELECT COUNT(p.category_id) AS NumberOfProducts FROM producten p LEFT JOIN soorten s ON p.category_id = s.id WHERE p.category_id = '.$this->_category_id.'";
			} elseif(isset($this->_naam_product)) {
				$query = "SELECT COUNT(id) AS NumberOfProducts FROM producten p WHERE p.naam_product = '".$this->_naam_product."'";
			} else {
				$query = "SELECT COUNT(id) AS NumberOfProducts FROM producten";
			}

			$ps = $this->_db->prepare($query);
			$ps->execute();
			$ps->setFetchMode(PDO::FETCH_ASSOC);
			return $ps->fetchAll()[0]["NumberOfProducts"];
		} 
		catch(PDOException $e){
			echo $e->getMessage();
		}		
	}
	
	//Krijg een naam bij een specifieke categorie of soort:
	public function getCategoryName() {
		try {	
			if(isset($this->_soorten_id)) {
				$query = "SELECT s.naam_soort AS Naam FROM soorten s WHERE s.id = $this->_soorten_id";
			} elseif(isset($this->_category_id) && !empty($this->_category_id)) {
				$query = "SELECT c.naam_category AS Naam FROM categories c WHERE c.id = $this->_category_id";
			} else {
				$query = "SELECT c.naam_category AS Naam FROM categories c WHERE c.id = 3";	
			}

			$ps = $this->_db->prepare($query);
			$ps->execute();
			$ps->setFetchMode(PDO::FETCH_ASSOC);
			$name = $ps->fetchAll()[0]["Naam"];
			switch($name) {
				case "Groente":
				$name = "Groente producten";
				break;
				case "Fruit":
				$name = "Fruit producten";
				break;
				case "Alles":
				$name = "Alle producten";
				break;
			}
			return $name;
		} 
		catch(PDOException $e){
			echo $e->getMessage();
		}		
	}
}

?>