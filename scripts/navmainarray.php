<?php
  $menu2 = [
  'Home' => array(
    'text' => 'Home',
    'url' => 'index.php',
    'target' => '_self'
  ),
  'Aanbiedingen' => array(
    'text' => 'Aanbiedingen',
    'url' => 'aanbiedingen.php',
    'target' => '_self'
  ),
  'Producten' => array(
    'text' => 'Producten',
    'url' => 'products.php',
    'target' => '_self'
  ),
  'Over Mij' => array(
    'text' => 'Over Mij',
    'url' => 'overmij.php',
    'target' => '_self'
  ),
  'Contact' => array(
    'text' => 'Contact',
    'url' => 'contact.php',
    'target' => '_self'
  )];

    $navmain = '<ul>';
      foreach ($menu2 as $item) {
        $navmain .= '<li><a href="' . $item['url'] . '" target="' . $item['target'] . '">' . $item['text'] . '</a></li>';
      }
    $navmain .= '</ul>';
?>