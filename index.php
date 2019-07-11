<?php

require 'db.php';
$TVA = 1.2;
$sql = 'SELECT * FROM `biere`';
$statement = $pdo->query($sql);
$tabbeer = $statement->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Site Bière</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
	<header>
		<nav>
			<a href="index.php">Site</a><br />
			<a href="purchase_order.php">Commande</a><br />
			<a href="profil.php">Mon profil</a><br />
			<a href="?deconnect=true">Déconnexion</a><br />
		</nav>
	</header>
	<section>
		<?php foreach ($tabbeer as $row): ?>
			<article class="col-md-4 col-sm-6" style="">
				<h2 class="text-center text-truncate border"><?= $row["name"] ?></h2>
				<img class="col-4 offset-4 col-md-4 offset-md-4 w-50" src="<?= $row["img"] ?>" alt="<?= $row["name"] ?>">	
				<p class="text-justify"><?= substr($row["description"],0,149) . "[...]" ?></p>
				<p class="text-center font-weight-bold"><?= number_format($row["prix_ht"]*$TVA,2,',', '.') ?>€</p>
				<!-- <form method="POST" action="deletebeer.php">
					<input type="hidden" name="id" value="<?= $row['id'] ?>">
					<button type="submit">Supression</button>
				</form> -->
			</article>
		<?php endforeach; ?>
	</section>
</body>
</html>
