<?php
session_start();
if (isset($_SESSION["connect"])) {
	$connect = $_SESSION["connect"];
	}else{
		$connect = false;
		}
if ($connect) {
	header("Location: purchase_order.php");
}

if(!empty($_POST)){
	//var_dump($_Post);die();
	$nom = strtoupper($_POST["nom"]);
	$prenom = $_POST["prenom"];
	$numero = $_POST["numero"];
	$typeVoie = $_POST["typeVoie"];
	$nomVoie = $_POST["nomVoie"];
	$codePostal = $_POST["codePostal"];
	$ville = strtoupper($_POST["ville"]);
	$pays = strtoupper($_POST["pays"]);
	$telephone = $_POST["telephone"];
	$mail = strtolower($_POST["mail"]);
	$password = $_POST["password"];
	$passwordVerif = $_POST["password_verif"];
	if (!empty($mail) && !empty($password)) {
		require_once 'db.php';
		$sql = 'SELECT * FROM `users` WHERE `mail`=?';
		$statement = $pdo->prepare($sql);
		$statement->execute([$mail]);
		$user = $statement->fetch();
		if (!$user){//si l'utilisateur n'existe pas
			//die("username est unique");
			if (strlen($password) <= 20 && strlen($password) >= 5) {//vérif longueur mdp
				//die("mdp format ok");
				if ($password === $passwordVerif) {//vérif mdp
					//die("mdp identiques");
					//password_hash ( string $password , int $algo [, array $options ] ) //cryptage password
					$password = password_hash($password, PASSWORD_BCRYPT);
					require_once 'db.php';
					$sql = 'INSERT INTO `users` (`mail`, `password`, `nom` , `prenom`,`numero`,`typeVoie`,`nomVoie`,`codePostal`,`ville`,`pays`,`telephone`) VALUES (:mail, :password, :nom, :prenom, :numero, :typeVoie, :nomVoie, :codePostal, :ville, :pays, :telephone)';// /!\ ne pas confondre value de input
					$statement = $pdo->prepare($sql);
					$result = $statement->execute([":mail" => $mail,
												   ":password" => $password,
												   ":nom" => $nom,
												   ":prenom" => $prenom,
												   ":numero" => $numero,
												   ":typeVoie" => $typeVoie,
												   ":nomVoie" => $nomVoie,
												   ":codePostal" => $codePostal,
												   ":ville" => $ville,
												   ":pays" => $pays,
												   ":telephone" => $telephone]);
					//TODO : signaler compte créer
					if ($result) {
						//die("enregistrement sur bdd");
						$_SESSION["connect"] = true;
						$_SESSION["mail"] = $mail;
						header("Location: purchase_order.php");
					}else{
						//die("erreur enregistrement sur bdd");
					}
				}else{
					//die("mdp différents");
					//TODO : signaler mdp différents
				}
			}else{
				//TODO : signaler mdp trop long ou trop court
				//die("mdp trop long ou trop court");
			}
		}else{
			//TODO : signaler username existe
			//die("username existe");
		}
	}else{
		//TODO : signaler champs vide
	}
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<!-- <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="assets/css/form.css">
	<title>Formulaire d'inscription</title>
</head>
<body>
	<div class="wrapper">
		<section class="login-container ins">
			<div>
				<header>
					<h2>Inscription</h2>
				</header>
				<form action="" method="POST">
					<input type="text" name="nom" placeholder="Nom" >
					<input type="text" name="prenom" placeholder="Prénom" >
					<input type="text" name="numero" placeholder="Numéro (rue)" >
					<input type="text" name="typeVoie" placeholder="Type de voie" >
					<input type="text" name="nomVoie" placeholder="Nom de la voie" >
					<input type="text" name="codePostal" placeholder="Code postal" >
					<input type="text" name="ville" placeholder="Ville" >
					<input type="text" name="pays" placeholder="Pays" >
					<input type="text" name="telephone" placeholder="Téléphone" >
					<input type="text" name="mail" placeholder="Adresse mail" >
					<input type="password" name="password" placeholder="Mot de passe" >
					<input type="password" name="password_verif" placeholder="Confirmez le mot de passe" >
					<button type="submit">S'enregistrer</button>
				</form>
			</div>
		</section>
	</div>
</body>
</html>
