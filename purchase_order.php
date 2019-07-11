<?php
	include('ressource_fiche_biere.php')
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Site bère - bon de commande</title>
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
<body>
	<div class="container">
		<h2 class="col-12 text-center">Coordonnées</h2>

		<div class="row mt-5">
			<form class="col-10 offset-1 col-md-10 offset-md-1" method="GET" action="confirmationCommande.php">
				<div id="contact" class="col-12 no-gutters">
					<div class="row col-10 offset-1 col-md-12 offset-md-0">
						<div class="form-group  col-12 col-md-6">
							<label>Prénom</label>
							<input class="form-control" type="text" name="firstname" placeholder="Votre prénom" required>
						</div>
						<div class="form-group col-12 col-md-6">
							<label>Nom</label>
							<input class="form-control" type="text" name="lastname" placeholder="Votre nom" required>
						</div>
					</div>
					<div class="row col-10 offset-1 col-md-12 offset-md-0">
						<div class="form-group col-12">
							<label>Adresse</label>
							<input class="form-control" type="text" name="address" placeholder="Votre adresse" required>
						</div>
					</div>
					<div class="row col-10 offset-1 col-md-12 offset-md-0">
						<div class="form-group  col-12 col-md-6">
							<label>Code postal</label>
							<input class="form-control" type="text" name="zipcode" placeholder="Votre code postal" required>
						</div>
						<div class="form-group col-12 col-md-6">
							<label>Ville</label>
							<input class="form-control" type="text" name="city" placeholder="Nom de la ville" required>
						</div>
					</div>
					<div class="row col-10 offset-1 col-md-12 offset-md-0">
						<div class="form-group col-12">
							<label>Pays</label>
							<input class="form-control" type="text" name="country" placeholder="Nom du pays" required>
						</div>
					</div>
					<div class="row col-10 offset-1 col-md-12 offset-md-0">
						<div class="form-group col-12">
							<label>Téléphone</label>
							<input class="form-control" type="text" name="tel" placeholder="Votre numéro de téléphone" required>
						</div>
					</div>
					<div class="row col-10 offset-1 col-md-12 offset-md-0">
						<div class="form-group col-12">
							<label>Mail</label>
							<input class="form-control" type="text" name="mail" placeholder="Votre adresse mail" required>
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
							<?php foreach ($beerArray as $key => $value) : ?>
								<tr>
									<td><?= $value[0] ?></td>
									<td id="pht_<?= $key ?>"><?= number_format($value[3], 2, ',', '.') ?>€</td>
									<td id="pttc_<?= $key ?>"><?= number_format($value[3] * $TVA, 2, ',', '.') ?>€</td>
									<!-- name="quantity[]", permet d'envoyer un tableau de quantités -->
									<!-- dans la méthode getNewPrice, on envoie l'id de l'objet, l'input complet avec tout ces attribut, le prix de base de la biere -->
									<td><input style="width: 50%;" type="number" name="quantity[]"  min="0" value="0" oninput="getNewPrice(<?= $key ?>, this, <?= $value[3] ?>)" /></td>
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
</body>
</html>