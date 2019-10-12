$(".dropdown ul li a").click(function() {
  let _sort = $(this).text();
  let _href = $(".dropdown ul li a").attr("href");
  let _page = $(location).attr('href').slice(-1); 

  if('Prijs aflopend' === _sort) {
	$(".dropdown ul li a").attr("href", _href + 'p%asc&pg=' + _page);
  } else if('Prijs oplopend' === _sort) {
	$(".dropdown ul li a").attr("href", _href + 'p%dsc&pg=' + _page);
  } else if('Product A-Z' === _sort) {
	$(".dropdown ul li a").attr("href", _href + 'a%asc&pg=' + _page);
  } else {
	$(".dropdown ul li a").attr("href", _href + 'a%dsc&pg=' + _page);
  }   
});

$path_info = pathinfo($_FILES['file']['name']);
$file = $path_info['basename'];

if(empty($file)) {
	echo 'voeg een bestand toe!';
} else {
	if ($path_info['extension'] != 'sql') {
		echo 'Uw bestand heeft geen toegestaan bestandstype!';
	} else {
		$user->importDatabase($file);	
	}		
}