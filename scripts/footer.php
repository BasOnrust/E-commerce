<script>
    $(document).ready(function() {   
		$(".second-row li:last-of-type a").click(function() {
			alert('Deze pagina is onder constructie.');
        });  
	});
</script>
<!DOCTYPE html>
<html lang="nl-NL">
<?php 
if(!isset($product_amount)) { $product_amount = NULL; }
$position = $product_amount < 2 ? 'absolute' : 'initial';
?>
<footer <?= preg_match('/(\/E-commerce\/$|\/E-commerce\/products|contact\.php*)/', $_SERVER['REQUEST_URI']) ? '' : 'style="position:'.$position.'"'; ?>>
	<section id="footer-top">
	<div class="first-row">
		<article>
		<h4>Pagina’s</h4>
		<?= $navmain; ?>
		</article>
		<article>
		<h4>Betalingsmogelijkheden</h4>
		<ul>
			<li><a><img src="https://dutchitchannel.nl/615831/eu-geeft-mastercard-een-boete-van-miljoen-euro.html?field=xBinary170026&width=712&maxheight=260" alt="Mastercard"></img></a></li>
			<li><a><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Visa_2014_logo_detail.svg/1280px-Visa_2014_logo_detail.svg.png" alt="Visa"></img></a></li>
		</ul> 
		</article>
		<article>
		<h4>Contact</h4>
		<?= preg_match('/(\/E-commerce\/$|\/E-commerce\/contact\.php)/', $_SERVER['REQUEST_URI']) ? 
			'<ul style="margin-top:15px;">
				<li>E-mailadres:</li>
				<li>onrust.bas@gmail.com</li><br>
				<li>Mobiele nummer:</li>
				<li>(+31) 6 30453051</li>
			</ul>' : 
			'<ul>
				<li>Maandag t/m vrijdag</li>
				<li>08:00 - 21:00</i>
				<li>Zaterdag en zondag</li>
				<li>10:00 - 18:00</li>
				<li class="not-available">Neem contact met ons op</li>
			</ul>' 
		; ?>
		</article>
		<article>
		<h4>App</h4>
		<ul>
			<li><img src="https://www.lidl-shop.nl/asset/nlCms/e77dcea4496b7f1bcca4e29efa6e14fb.png" alt="Apple-store"></img></i>
			<li><img src="https://www.lidl-shop.nl/asset/nlCms/2132e3e41ebaf13ac47a9394a239b21c.png" alt="Google-store"></img></i>
		</ul>
		</article>
	</div>
	<div class="second-row">
		<article>
		<ul>
			<li class="not-available">Algemen voorwaarden</i>
			<li class="not-available">Privacy & cookies</i>
			<li><a>Sitemap</a></i>
		</ul>
		</article>
	</div>
	</section>
	<section id="footer-bottom">
		<p>© Copyright 2019 All rights reserved</p>
		<p>Author: B. Onrust</p>
	</section>
</footer>
</html>