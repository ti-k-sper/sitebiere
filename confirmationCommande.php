<?php 

include('ressource_fiche_biere.php');

var_dump($_GET);
//die;

if(isset($_GET['firstname'])) :
		$totalTTC = 0; ?>
		<h1 style='text-align: center'>Bonjour <?= $_GET['firstname'] ?> <?= $_GET['lastname'] ?> !</h1>
		<h3 style='text-align: center'>Voici donc ta confirmation de commande</h3>

		<table style="width: 80%;margin-left:10%; text-align:center;" class="">
			<thead>
				<tr>
					<th>Nom de la bière</th>
					<th>Prix HT</th>
					<th>Prix TTC</th>
					<th>Quantité</th>
					<th>Total TTC</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($beerArray as $key => $value) :
					if($_GET['quantity'][$key] > 0) : ?>
						<tr>
							<td><?= $value[0] ?></td>
							<td><?= number_format($value[3], 2, ',', '.')?>€</td>
							<td><?= number_format($value[3] * $TVA, 2, ',', '.') ?>€</td>
							<td><?= $_GET['quantity'][$key] ?></td>
							<td><?= number_format(($value[3] * $TVA)*$_GET['quantity'][$key], 2, ',', '.') ?>€</td>
						</tr>
						<?php
							$totalTTC += ($value[3] * $TVA)*$_GET['quantity'][$key];
					endif ;
				endforeach; ?>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><strong><?= number_format($totalTTC, 2, ',', '.') ?>€</strong></td>
				</tr>
			</tbody>
		</table>
		<p style="text-align: center;">Celle-ci vous sera livrée au <?= $_GET['address'] ?> <?= $_GET['zipcode'] ?> <?= $_GET['city'] ?> sous deux jours</p>
		<p style="text-align:center;">
			<small>Si vous ne réglez pas sous 10 jours, le prix de votre commande sera majorée.(25%/jours de retard)</small>
		</p>
		<p style="text-align:center;"><button><a href="purchase_order.php">J'en veux encore ! </a></button></p>
<?php endif; ?>