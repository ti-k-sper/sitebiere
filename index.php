<?php
	include('ressource_fiche_biere.php')
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Site bière</title>
</head>
<header>
	<div id="bannière">
		<h1>La bière de Kevin et Julien</h1>
	</div>
</header>
<nav>
	<ul>
		<li><a href="index.php" target="_blank">Produits</a></li>
		<li><a href="purchase_order.php" target="_blank">Commande</a></li>
	</ul>
</nav>
<body class="container">
	<section class="row">
		<?php foreach ($beerArray as $value) : ?>
			<article class="col-md-4 col-sm-6" style="">
			<h2 class="text-center text-truncate border"><?= $value[0] ?></h2>
			<img class="col-4 offset-4 col-md-4 offset-md-4 w-50" src="<?= $value[1] ?>" alt="<?= $value[0] ?>">
			<!-- <p class="text-justify text-truncate border" style="height: 100px;"><?= $value[2] ?></p> -->
			<p class="text-justify"><?= substr($value[2],0,149) . "[...]" ?></p>
			<p class="text-center font-weight-bold"><?= number_format($value[3]*$TVA,2,',', '.') ?>€</p>
			</article>
		<?php endforeach ?>
	</section>
</body>
</html>