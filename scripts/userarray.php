<?php
$menu1 = [
	'Mijn account' => [
    'text' => 'Mijn Account',
    'url' => '#',
    'target' => '_self'
  ]
];

if($user->isLogged()) { 
	$menu3['Logout'] = [ 
		'value' => 'Uitloggen',
		'name' => 'logout',
		'type' => 'submit'
  ];  
} else {	
  $menu1['Register'] = [
		'text' => 'Registreren',
		'url' => 'registreren.php',
		'target' => '_self'
	];	
	$menu1['Login'] = [ 
		'text' => 'Inloggen',
		'url' => 'login.php',
		'target' => '_self'
	];			
}

if($user->isAuthor() && $user->isLogged()) {
	$menu1['Add'] = [ 
		'text' => 'Toevoegen',
		'url' => 'toevoegen.php',
		'target' => '_self'
	];
}

$user = '<ul>';
  foreach ($menu1 as $item) {
    $user .= '<li><a href="' . $item['url'] . '" target="' . $item['target'] . '">' . $item['text'] . '</a></li>';
  }
  if(isset($menu3) && !empty($menu3)) {
    foreach ($menu3 as $item) {
      $user .= '<li><form method="POST"><input type="' . $item['type'] . '" name="' . $item['name'] . '" value="' . $item['value'] . '"  ></form></li>';
    }
  }
$user .= '</ul>';

?>