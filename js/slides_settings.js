$(document).ready(function() {
	$('.slideshow').slidesjs({
		width: 470,
		height: 320,
		play: { 
			active: false, 
			auto: true, 
			interval: 3000 
		},
		navigation: { 
			active: false, 
			effect: 'fade' 
		},
		pagination: { 
			active: false, 
			effect: 'fade' 
		}
	});
});