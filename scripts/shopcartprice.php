<?php
if(isset($_SESSION['user']) && $_SESSION['logged']) {
$userid = $user->getUserId($_SESSION['user']);
$producten = $products->getUserProducts($userid);

$prijs = 0;
foreach ($producten as $product) {
  $prijs+= $product['prijs'];
}

if (preg_match('/[0-9]+\.[0-9]$/', $prijs)) {
		$prijs = $prijs.'0';
	} 

if($prijs === 0) { $prijs = '0.00'; }
}

?>