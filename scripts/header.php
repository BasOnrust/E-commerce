<script>
    $(document).ready(function() {   
		$("#topbar li:first-of-type").click(function() {
			alert('Deze pagina is onder constructie.');
        });  
	});
</script>
<header>
	<section id="topbar">
	<div class="container">
		<div id="branding">
		<h3>E-commerce Website</h3>
		</div>
		<?= $user; ?>
	</div>
	</section>
	<section id="navbar">
	<div class="container"> 
		<nav class="nav-primary">
		<?= $navmain; ?>
		</nav>      
		<div id="shopcart">
		<a href="winkelwagen.php">    
			<span>€ <?= isset($prijs) ? $prijs : '0.00'; ?></span>   
			<i class="fa fa-shopping-cart fa-xs"></i>           
		</a>
		</div>
		<div class="form-search" <?= preg_match('/(\/E-commerce\/$|\/E-commerce\/products\.php*)/', $_SERVER['REQUEST_URI']) ? '' : 'style="display: none;"'; ?>>
		<form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
			<input type="text" name="search" placeholder="Search">
			<button type="submit"><i class="fa fa-search fa-xs"></i></button>
		</form>
		</div>
	</div>
	</section>  
</header>