<!DOCTYPE html>
<html>
	<head>
		<title>Site bière</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<header>
			<div id="bannière">
				<h1>La bière de Kevin et Julien</h1>
			</div>
		</header>

		<nav>
			<ul>
			<li><a href="../../index.html" target="_blank" >Présentation</a></li>
			<li><a href="../html/produit.html" target="_blank">Produits</a></li>
			<li><a href="bieres_diverses.php" target="_blank">Bières diverses</a></li>
			</ul>
		</nav>

		<?php
			include("lesbieres.php");
		?>

	</body>
</html>