$(document).ready(function() {
	$(".nav-primary ul li a").hover(function() {
		$(this).css({"color": "#484848", "border-bottom": "3px solid #484848" });
		$(this).css({ transition: 'padding-bottom 0.3s ease-in-out', "padding-bottom": "17px" });
	}, function() {
		$(this).css({"color": "#777", "padding-bottom": "", "border-bottom": "" });
	});
});