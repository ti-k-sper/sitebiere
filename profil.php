<?php
require 'connect.php';
require 'db.php';

$sql = 'SELECT * FROM `users` WHERE `mail`=?';
$statement = $pdo->prepare($sql);
$statement->execute([$_SESSION["mail"]]);
$users = $statement->fetch();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Site Bière - Profil</title>
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
		<h2>Mon Profil</h2>
		<h3>Mes coordonnées</h3>
		<ul style="list-style-type: none;">
			<li>
				<form method="POST" action="update.php"><!-- pour modif -->
					<input type="texte" name="nom" value="<?= $users['nom'] ?>"><br />
					<input type="texte" name="prenom" value="<?= $users['prenom'] ?>"><br />
					<input type="texte" name="numero" value="<?= $users['numero'] ?>"><br />
					<input type="texte" name="typeVoie" value="<?= $users['typeVoie'] ?>"><br />
					<input type="texte" name="nomVoie" value="<?= $users['nomVoie'] ?>"><br />
					<input type="texte" name="codePostal" value="<?= $users['codePostal'] ?>"><br />
					<input type="texte" name="ville" value="<?= $users['ville'] ?>"><br />
					<input type="texte" name="pays" value="<?= $users['pays'] ?>"><br />
					<input type="texte" name="telephone" value="<?= $users['telephone'] ?>"><br />
					<input type="texte" name="password" placeholder="modification mdp"><br />
					<input type="hidden" name="id" value="<?= $users['id'] ?>"><br />
					<button type="submit">Modifier</button>
				</form><hr />
				<form method="POST" action="deleteprofil.php"><!-- pour suppr -->
					<input type="hidden" name="id" value="<?= $users['id'] ?>">
					<button type="submit">Supression</button>
				</form>
			</li>
		</ul>
	</section>
</body>
</html>
