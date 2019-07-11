<?php 
require 'connect.php';
require 'db.php';

//include('ressource_fiche_biere.php');
$TVA = 1.2;
$sql = 'SELECT * FROM `biere`';
$statement = $pdo->query($sql);
$tabbeer = $statement->fetchAll();

//var_dump($tabbeer);
//die;

if(isset($_POST['firstname'])) :
		$totalTTC = 0; ?>
		<h1 style='text-align: center'>Bonjour <?= $_POST['firstname'] ?> <?= $_POST['lastname'] ?> !</h1>
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
				foreach ($tabbeer as $key => $value) :
					if($_POST['quantity'][$key] > 0) : ?>
						<tr>
							<td><?= $value[1] ?></td>
							<td><?= number_format($value[4], 2, ',', '.')?>€</td>
							<td><?= number_format($value[4] * $TVA, 2, ',', '.') ?>€</td>
							<td><?= $_POST['quantity'][$key] ?></td>
							<td><?= number_format(($value[4] * $TVA)*$_POST['quantity'][$key], 2, ',', '.') ?>€</td>
						</tr>
						<?php
							$totalTTC += ($value[3] * $TVA)*$_POST['quantity'][$key];
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
		<p style="text-align: center;">Celle-ci vous sera livrée au <?= $_POST['address'] ?>, <?= $_POST['zipcode'] ?> <?= $_POST['city'] ?>, sous deux jours</p>
		<p style="text-align:center;">
			<small>Si vous ne réglez pas sous 10 jours, le prix de votre commande sera majorée.(25%/jours de retard)</small>
		</p>
		<p style="text-align:center;"><button><a href="purchase_order.php">J'en veux encore ! </a></button></p>
<?php endif; ?>