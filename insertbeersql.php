<?php 
include 'ressource_fiche_biere.php';
include 'db.php';

$sql = 'INSERT INTO biere (name, img, description, prix_ht) VALUES (:name, :img, :description, :prix_ht)';

foreach ($beerArray as $element) { 
$statement = $pdo->prepare($sql);
$result = $statement->execute([
	':name' 		=> $element[0],
	':img'			=> $element[1],
	':description' 	=> $element[2],
	':prix_ht' 		=> $element[3]
]);
}

?>