<?php 
require 'connect.php';
require 'db.php';

if (isset($_SESSION["connect"])) {
	$connect = $_SESSION["connect"];
}else{
	$connect = false;
}
if (!$connect) {
	header("Location: formconnexion.php");
	//fin traitement
}

$sql = 'SELECT * FROM `users` WHERE `mail`=?';
$statement = $pdo->prepare($sql);
$statement->execute([$_SESSION["mail"]]);
$users = $statement->fetch();

$TVA = 1.2;
$sql = 'SELECT * FROM `biere`';
$statement = $pdo->query($sql);
$tabbeer = $statement->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Site bière - Bon de commande</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"/>
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
	<div class="container">
		<h1 class="col-12 text-center">Commande</h1>
		<h2 class="col-12 text-center">Coordonnées</h2>

		<div class="row mt-5">
			<form class="col-10 offset-1 col-md-10 offset-md-1" method="POST" action="confirmationCommande.php">
				<div id="contact" class="col-12 no-gutters">
					<div class="row col-10 offset-1 col-md-12 offset-md-0">
						<div class="form-group  col-12 col-md-6">
							<label>Prénom</label>
							<input class="form-control" type="text" name="firstname" placeholder="Votre prénom" value="<?= $users['prenom'] ?>" required>
						</div>
						<div class="form-group col-12 col-md-6">
							<label>Nom</label>
							<input class="form-control" type="text" name="lastname" placeholder="Votre nom" value="<?= $users['nom'] ?>" required>
						</div>
					</div>
					<div class="row col-10 offset-1 col-md-12 offset-md-0">
						<div class="form-group col-12">
							<label>Adresse</label>
							<input class="form-control" type="text" name="address" placeholder="Votre adresse" value="<?= $users['numero']." ".$users['typeVoie']." ".$users['nomVoie'] ?>" required>
						</div>
					</div>
					<div class="row col-10 offset-1 col-md-12 offset-md-0">
						<div class="form-group  col-12 col-md-6">
							<label>Code postal</label>
							<input class="form-control" type="text" name="zipcode" placeholder="Votre code postal" value="<?= $users['codePostal'] ?>" required>
						</div>
						<div class="form-group col-12 col-md-6">
							<label>Ville</label>
							<input class="form-control" type="text" name="city" placeholder="Nom de la ville" value="<?= $users['ville'] ?>" required>
						</div>
					</div>
					<div class="row col-10 offset-1 col-md-12 offset-md-0">
						<div class="form-group col-12">
							<label>Pays</label>
							<input class="form-control" type="text" name="country" placeholder="Nom du pays" value="<?= $users['pays'] ?>" required>
						</div>
					</div>
					<div class="row col-10 offset-1 col-md-12 offset-md-0">
						<div class="form-group col-12">
							<label>Téléphone</label>
							<input class="form-control" type="text" name="tel" placeholder="Votre numéro de téléphone" value="<?= $users['telephone'] ?>" required>
						</div>
					</div>
					<div class="row col-10 offset-1 col-md-12 offset-md-0">
						<div class="form-group col-12">
							<label>Mail</label>
							<input class="form-control" type="text" name="mail" placeholder="Votre adresse mail" value="<?= $users['mail'] ?>" required>
						</div>
					</div>
				</div>
				<div id="BDC">
					<h2 class="col-12 text-center mt-3">Bon de commande</h2>
					<table class="col-12 table-striped">
						<thead class="col-12">
							<tr>
								<th>Nom de la bière</th>
								<th>Prix HT</th>
								<th>Prix TTC</th>
								<th>Quantité</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($tabbeer as $key => $row) : ?>
								<tr>
									<td><?= $row["name"] ?></td>
									<td id="pht_<?= $key ?>"><?= number_format($row["prix_ht"], 2, ',', '.') ?>€</td>
									<td id="pttc_<?= $key ?>"><?= number_format($row["prix_ht"] * $TVA, 2, ',', '.') ?>€</td>
									<!-- name="quantity[]", permet d'envoyer un tableau de quantités -->
									<!-- dans la méthode getNewPrice, on envoie l'id de l'objet, l'input complet avec tout ces attribut, le prix de base de la biere -->
									<td><input style="width: 50%;" type="number" name="quantity[]"  min="0" value="0" oninput="getNewPrice(<?= $key ?>, this, <?= $row["prix_ht"] ?>)" /></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
					<div class="col-12 text-center mt-4">
						<button type="submit">COMMANDER</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<script type="text/javascript" src="assets/js/script.js"></script>
	</section>
</body>
</html>