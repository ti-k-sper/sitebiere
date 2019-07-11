<?php
//verif connecter
require 'connect.php';
require 'db.php';
//$tabbeer = [.. , ..]
$sql = 'SELECT * FROM `biere`';//attention aux ``
$statement = $pdo->query($sql);
$tabbeer = $statement->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Les bières</title>
	<meta charset="utf-8">
</head>
<body>
	<section>
		<!-- boucle sur $tabbeer -->
		<?php foreach ($tabbeer as $row): ?>
			<article>
			<h2><?= $row["nom"] ?></h2>
				<form method="POST" action="deletebeer.php"><!-- pour suppr -->
					<input type="hidden" name="id" value="<?= $row['id'] ?>">
					<button type="submit">Supression</button>
				</form>
			<p><?= $row["description"] ?></p>
		</article>
		<?php endforeach; ?>
		<!-- fin boucle -->
	</section>
	<nav>
		<a href="beer.php">Site</a><br />
		<a href="purchase_order.php">Commande</a><br />
		<a href="profil.php">Mon profil</a><br />
		<a href="?deconnect=true">Déconnexion</a><br />
	</nav>
</body>
</html>
