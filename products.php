<?php
session_start();
require_once('scripts/autoload.php');
$products = new Products\Products();
$user = new User\User();
$products->getCategoryNames();

if(!isset($_GET["cid"]) || 3 == $_GET["cid"] && isset($_GET["o"])) {
  $order_name = ('p' == explode('%', $_GET["o"] ?? '')[0]) ? 'prijs' : 'naam_product';
  $order_direction = ('asc' == explode('%', $_GET["o"] ?? '')[!isset($_GET["o"]) ? 0 : 1]) ? 'ASC' :'DESC';
  $products->getAllProducts($order_name, $order_direction, isset($_GET["cid"]) ? $_GET["cid"] : '', isset($_GET["pg"]) ? $_GET["pg"] : 1);
  $url =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?cid='.(isset($_GET["cid"]) ? $_GET["cid"] : 3).'&o=';
} elseif(isset($_GET["cid"]) && isset($_GET["o"])) {
  $order_name = ('p' == explode('%', $_GET["o"])[0]) ? 'prijs' : 'naam_product';
  $order_direction = ('asc' == explode('%', $_GET["o"])[1]) ? 'ASC' :'DESC'; 
  $products->getCategoryProducts($_GET["cid"], $order_name, $order_direction, isset($_GET["pg"]) ? $_GET["pg"] : 1); 
  $url =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?cid='.$_GET["cid"].'&o=';
} 

if(isset($_GET["sid"]) && isset($_GET["o"])) {
  $order_name = ('p' == explode('%', $_GET["o"])[0]) ? 'prijs' : 'naam_product';
  $order_direction = ('asc' == explode('%', $_GET["o"])[1]) ? 'ASC' :'DESC'; 
  $products->getSortProducts($_GET["sid"], $order_name, $order_direction);
  $url =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?sid='.$_GET["sid"].'&o=';
  $cat_name = $products->getCategoryNameBySort(isset($_GET["sid"]) ? $_GET["sid"] : '');
} elseif(isset($_GET['search'])) {
  $products->getSearchedProduct(ucfirst(strtolower($_GET['search'])));
}   

if(isset($_GET["nm"])) {
  if(isset($_SESSION['user']) && $_SESSION['logged']) {
    $userid = $user->getUserId($_SESSION['user']);  
    $product = $products->getClickedProduct($_GET["nm"]);        
    $addshopcart = '<script>$(document).ready(function(){alert("'.$products->addShoppingCartProduct($userid, $product).'")});</script>';                  
  } else {
    $addshopcart = '<script>$(document).ready(function(){alert("Log in om een product aan uw winkelmand toe te voegen.")});</script>';     
  }
}

$catname = $products->getCategoryName(); 
switch($catname) {
  case "Groente producten":
    $catname = "Groente";
    break;
  case "Fruit producten":
    $catname = "Fruit";
    break;
  case "Alle producten":
    $catname = "Groente & Fruit";
    break;
  default:
    $catname = $cat_name;
}
$products->getSortNames(isset($_GET["cid"]) ? $_GET["cid"] : '', $catname);

switch($catname) {
  case "Groente":
    $catid = 1;
    break;
  case "Fruit":
    $catid = 2;
    break;
  default:
    $catid = 3;
}

if(isset($_GET["o"])) {
  switch($_GET["o"]) {
    case "p%dsc":
      $sort = "Prijs oplopend";
      $mr = "82px";
      $check2 = "check-";
      break;
    case "a%asc":
      $sort = "Product A-Z";
      $mr = "66px";
      $check3 = "check-";
      break;
    case "a%dsc":
      $sort = "Product Z-A";
      $mr = "66px";
      $check4 = "check-";
      break;
    default:
      $sort = "Prijs aflopend";
      $mr = "78px";
      $check1 = "check-";
  }
}

$strlen = $products->getCategoryName();
$wordcount = str_word_count($strlen);
switch($wordcount) {
  case 1 == $wordcount:
    $multiplier = 23;
    break;
  case 2 == $wordcount:
    $multiplier = 19;
    break;
  case 3 || 4 == $wordcount:
    $multiplier = 18;
    break;
  default:
    $multiplier = 17;
} 
$width = (strlen($strlen) - substr_count($strlen, ' ') - substr_count($strlen, ',')) * $multiplier; 

$maxpages = ceil($products->getNumberOfProducts()/9);
$pagerurl = 'products.php?cid='.(isset($_GET["cid"]) ? $_GET["cid"] : 3).'&o='.(isset($_GET["o"]) ? $_GET["o"] : 'p%asc').'&pg=';
$marginleft = (298 - $maxpages * 20).'px';
$pages['first'] = ['text' => 'first page', 'url' => $pagerurl.'1', 'target' => '_self', 'margin-left' => $marginleft];
$x = 1;
while($x <= $maxpages) {
  $pages['page '.$x] = ['text' => $x, 'url' => $pagerurl.$x, 'target' => '_self'];
  $x++;
}
$pages['last'] = ['text' => 'last page', 'url' => $pagerurl.$maxpages, 'target' => '_self'];

$pager = '<div class="pager">';
$pager .= '<ul>';
  foreach ($pages as $page) {
    $fontweight = (isset($_GET["pg"]) ? $_GET["pg"] : '') == substr($page['url'], -1) ? 'bold' : 'normal';
    $marginleft = (isset($page['margin-left']) ? $page['margin-left'] : '');
    $pager .= '<li><a style="font-weight: ' . $fontweight . '; margin-left: ' . $marginleft . ';" href="' . $page['url'] . '" target="' . $page['target'] . '">' . $page['text'] . '</a></li>';
  }
$pager .= '</ul></div>';

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
    <title>E-commerce website: Products</title>
    <link rel="stylesheet" href="css/font-awesome-5.8.2.min.css">
    <link rel="stylesheet" href="css/stylesheet.css">
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/menu_animation.js"></script>
    <script>
      $(document).ready(function() {     
        $(".producten article i").hover(function() {
          $(this).css({ transition: 'background-color 0.2s ease-in-out', "background-color": "rgba(72, 72, 72, 0.73)" });
          $(this).css({ transition: 'border 0.1s ease-in-out', "border": "none" });
          $(this).css({ "color": "#ffffff", "padding": "8px" });
        }, function() {
          $(this).css({ transition: 'background-color 0.3s ease-in-out', "background-color": "rgb(238, 238, 238)" });
          $(this).css({ "border": "3px solid rgba(72, 72, 72, 0.73)" });
          $(this).css({ "color": "rgba(72, 72, 72, 0.92)", "padding": "5px" });
        });
        
        $(".container li a span").hover(function() {
          $(this).css({ transition: 'border-bottom 0.1s ease-in-out', "border-bottom": "1px solid #57a5cc" });
        }, function() {
          $(this).css({ transition: 'border-bottom 0.3s ease-in-out', "border-bottom": "#ffffff" });
        });   

        $('.producten article div:not(#notfound)').click(function() {
          let afb = $($(this).html()).attr("src");
          let alt = $($(this).html()).attr("alt");
          let naam = $("p:first", this).text();
          let hvl = $("p:last", this).text();
          let pr_int = $("span", this).text();
          let pr_dec = $("sup", this).text();
          let pr_full = 'pr='+pr_int+pr_dec;
          let art = "<article><h3>Handige informatie over dit product</h3><p>Kropsla is een uistekende basis voor een lekkere salade maar combineert ook heerlijk met gebakken aardappelen en een biefstukje.</p><p>Kropsla is één van de bekendste en populairste slasoorten in Nederland. Kropsla wordt door kenners en fijnproevers ook wel botersla genoemd. Die naam dankt deze sla aan zijn boterzachte smaak. Kropsla bestaat uit een dichte krop van grote, brede bladeren. De sappige, groene bladeren omsluiten een zacht hart.</p><h3>Kwaliteit</h3><p>Bij aankoop hoort kropsla frisgroene, verse bladeren te hebben. De krop moet compact zijn.</p><h3>Bewaaradvies</h3><p>Kropsla kunt u het beste in een open verpakking in de groentelade van de koelkast bewaren. Zo blijft de sla 2 tot 3 dagen goed.</p></article>";

          $(".popup-content").append("<img src="+afb+" alt="+alt+"><h2>"+naam+"</h2>"+art+"<p style='margin-left: 440px'>"+hvl+"</p><span>"+pr_int+"</span><sup>"+pr_dec+"</sup>"); 
          $(".popup-overlay, .popup-content").addClass("active");
          $(".backcolor").addClass("active");
        });
        
        $(".close, .backcolor").click(function() {
          $(".popup-content").children("h2").remove();
          $(".popup-content").children("article").remove();
          $(".popup-content").children("p").remove();
          $(".popup-content").children("img").remove();
          $(".popup-content").children("span").remove();
          $(".popup-content").children("sup").remove();
          $(".popup-overlay, .popup-content").removeClass("active");
          $(".backcolor").removeClass("active");
        });

        $(".producten article:nth-of-type(3)").css("padding", "24px 23px");
        $(".producten article:nth-of-type(6)").css("padding", "24px 23px");
      });
    </script>
</head>
<body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <?php require_once('scripts/header.php'); ?>
  <main>
  <div class="backcolor"></div> 
    <section class="popup-overlay">
      <div class="popup-content">
        <div class="close"></div> 
      </div>
    </section>
    <section id="breadcrumbs">
      <div class="container">
        <ul>     
          <li><a href="products.php" class="<?= !isset($_GET["cid"]) && !isset($_GET["sid"]) ? 'current' : ''; ?>">Producten</a></li>
          <li><i class="<?= !isset($_GET["cid"]) && !isset($_GET["sid"]) ? '' : 'fas fa-angle-right'; ?>"></i> </i><a href="products.php?cid=<?=  $catid ?>&o=p%asc" class="<?= isset($_GET["cid"]) ? 'current' : ''; ?>"><?= isset($_GET["cid"]) || isset($_GET["sid"]) ? $catname : ''; ?></a></li>
          <li><i class="<?= isset($_GET["sid"]) ? 'fas fa-angle-right' : ''; ?>"></i> </i><a class="<?= isset($_GET["sid"]) ? 'current' : ''; ?>"><?= isset($_GET["sid"]) ? $products->getCategoryName() : ''; ?></a></li>
        </ul>       
      </div>
    </section> 
    <section id="nav-main">
      <?php 
      if (isset($addshopcart)) {
        echo $addshopcart;
      } else {
        echo '';
      }   
      ?>
      <div class="container">
        <nav class="nav-secundary categories">
          <div id="categoryname">
            <span>Categorieën</span>
          </div>
          <?= $products->showCategoryNames(); ?>
        </nav>
        <nav class="nav-secundary sorts">
          <div id="sortsname">
            <span><?= $catname; ?></span>
          </div>
          <?= $products->showSortNames(true); ?>     
        </nav>
      </div>
    </section> 
    <section id="productcontent">
      <header id="title-group" style="width: <?= $width; ?>px">
        <h2><?= $products->getCategoryName(); ?></h2>
      </header>
      <div class="filterbar"> 
        <div class="selecties">        
          <div class="dropdown">
            <button class="dropbtn"><span>Sorteer op: </span><b><?= $sort ?? 'Prijs aflopend' ?></b> <i class="fas fa-sort-down"></i></button>
            <ul class="dropdown-content">
              <li><a href="<?= $url ?? '' ?>p%asc&pg=1" style="margin-right: <?= $mr ?? "78px" ?>"><i class="far fa-<?= $check1 ?? '' ?>circle"></i><span>Prijs aflopend</span></a></li>
              <li><a href="<?= $url ?? '' ?>p%dsc&pg=1" style="margin-right: <?= $mr ?? "78px" ?>"><i class="far fa-<?= $check2 ?? '' ?>circle"></i><span>Prijs oplopend</span></a></li>
              <li><a href="<?= $url ?? '' ?>a%asc&pg=1" style="margin-right: <?= $mr ?? "78px" ?>"><i class="far fa-<?= $check3 ?? '' ?>circle"></i><span>Product A-Z</span></a></li>
              <li><a href="<?= $url ?? '' ?>a%dsc&pg=1" style="margin-right: <?= $mr ?? "78px" ?>"><i class="far fa-<?= $check4 ?? '' ?>circle"></i><span>Product Z-A</span></a></li>
            </ul>
          </div>
          <div id="resultaten">
            <span><?= $products->getNumberOfProducts(); ?> gevonden resultaten</span>
          </div>
        </div>
      </div> 
      <div class="producten">
        <?= $products->showRecievedProducts(); ?>
      </div>
      <?= $pager = (isset($_GET["sid"]) && isset($_GET["o"]) || isset($_GET['search'])) ? '' : $pager; ?>
    </section> 
  </main>
  <?php require_once('scripts/footer.php'); ?>
</body>
</html>