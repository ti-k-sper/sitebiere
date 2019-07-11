<?php
require 'connect.php';
require 'db.php';

if(!empty($_POST)){
	//var_dump($_Post);die();
	$nom = $_POST["nom"];
	$prenom = strtolower($_POST["prenom"]);
	$numero = $_POST["numero"];
	$typeVoie = $_POST["typeVoie"];
	$nomVoie = $_POST["nomVoie"];
	$codePostal = $_POST["codePostal"];
	$ville = $_POST["ville"];
	$pays = $_POST["pays"];
	$telephone = $_POST["telephone"];
	$password = $_POST["password"];
	$id = $_POST["id"];
	if (!empty($id)) {
		if (!empty($nom)) {
			require_once 'db.php';
			$sql = 'SELECT * FROM `users` WHERE `mail`=?';
			$statement = $pdo->prepare($sql);
			$statement->execute([$_SESSION["mail"]]);
			$user = $statement->fetch();
			//var_dump($user);
			//die();
			if (!$user){
				//var_dump($user);
				//die();
				if (!empty($password)) {
					if (strlen($password) <= 10 && strlen($password) >= 5) {
					$password = password_hash($password, PASSWORD_BCRYPT);
					require_once 'db.php';
					$sql = 'UPDATE `users` SET `password` = :password , `nom` = :nom , `prenom` = :prenom , `numero` = :numero , `typeVoie` = :typeVoie , `nomVoie` = :nomVoie , `codePostal` = :codePostal , `ville` = :ville , `pays` = :pays , `telephone` = :telephone WHERE `users`.`id` = :id ';
					$statement = $pdo->prepare($sql);
					$result = $statement->execute([":password" => $password,
												   ":nom" => $nom,
												   ":prenom" => $prenom,
												   ":numero" => $numero,
												   ":typeVoie" => $typeVoie,
												   ":nomVoie" => $nomVoie,
												   ":codePostal" => $codePostal,
												   ":ville" => $ville,
												   ":pays" => $pays,
												   ":telephone" => $telephone,
												   ":id" => $id]);
					}else{
						die("mauvais format");
						//TODO : créer erreur
					}
				}else{
					//modification tout sauf mdp
					//var_dump($user);
					//die(); 
					require_once 'db.php';
					$sql = 'UPDATE `users` SET `nom` = :nom , `prenom` = :prenom , `numero` = :numero , `typeVoie` = :typeVoie , `nomVoie` = :nomVoie , `codePostal` = :codePostal , `ville` = :ville , `pays` = :pays , `telephone` = :telephone WHERE `users`.`id` = :id ';
					$statement = $pdo->prepare($sql);
					$result = $statement->execute([
						":nom" => $nom,
						":prenom" => $prenom,
						":numero" => $numero,
						":typeVoie" => $typeVoie,
						":nomVoie" => $nomVoie,
						":codePostal" => $codePostal,
						":ville" => $ville,
						":pays" => $pays,
						":telephone" => $telephone,
						":id" => $id
					]);
				}
			}else{
				require_once 'db.php';
				$sql = 'UPDATE `users` SET `nom` = :nom , `prenom` = :prenom ,`numero` = :numero ,`typeVoie` = :typeVoie ,`nomVoie` = :nomVoie ,`codePostal` = :codePostal ,`ville` = :ville , `pays` = :pays ,`telephone` = :telephone WHERE `users`.`id` = :id ';
				$statement = $pdo->prepare($sql);
				$result = $statement->execute([
					":nom" => $nom,
					":prenom" => $prenom,
					":numero" => $numero,
					":typeVoie" => $typeVoie,
					":nomVoie" => $nomVoie,
					":codePostal" => $codePostal,
					":ville" => $ville,
					":pays" => $pays,
					":telephone" => $telephone,
					":id" => $id
				]);	
			}
		}
	}
}

header("Location: profil.php");