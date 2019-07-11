<?php
//inscription
	if(	isset($_POST["lastname"]) && !empty($_POST["lastname"]) &&
		isset($_POST["firstname"]) && !empty($_POST["firstname"]) &&
		isset($_POST["address"]) && !empty($_POST["address"]) &&
		isset($_POST["zipCode"]) && !empty($_POST["zipCode"]) &&
		isset($_POST["city"]) && !empty($_POST["city"]) &&
		isset($_POST["country"]) && !empty($_POST["country"]) &&
		isset($_POST["phone"]) && !empty($_POST["phone"]) &&
		isset($_POST["mail"]) && !empty($_POST["mail"]) &&
		isset($_POST["mailVerify"]) && !empty($_POST["mailVerify"]) &&
		isset($_POST["password"]) && !empty($_POST["password"]) &&
		isset($_POST["passwordVerify"]) && !empty($_POST["passwordVerify"])&&
		isset($_POST["robot"]) && empty($_POST["robot"])//protection robot
	){
		
		if(
			( 	filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL) && 
				$_POST["mail"] == $_POST["mailVerify"]
			) &&
			( $_POST["password"] == $_POST["passwordVerify"])
		){

			$sql = "SELECT * FROM users WHERE `mail`= ?";
			$pdo = getDB($dbuser, $dbpassword, $dbhost, $dbname);
			$statement = $pdo->prepare($sql);
			$statement->execute(
				[
					htmlspecialchars($_POST["mail"])
				]
			);
			$user = $statement->fetch();//retourne un tableau avec tte les donnée de l'utilisateur ou retourne false
		
			if(!$user){
				$password = password_hash(htmlspecialchars($_POST["password"]), PASSWORD_BCRYPT);
				//génération timestamp (createdAT) clé aleatoire (token)
				$createdAT = time();
				$token = md5($createdAT);
				$sql = "INSERT INTO `users` (`lastname`, `firstname`, `address`, `zipCode`, `city`, `country`, `phone`, `mail`, `password`, `token`) VALUES (
				 :lastname,				 
				 :firstname,
				 :address,
				 :zipCode, 
				 :city,
				 :country,
				 :phone,
				 :mail,
				 :password,
				 :token
				 )";
				$statement = $pdo->prepare($sql);
				$result = $statement->execute([
					":lastname"		=> htmlspecialchars($_POST["lastname"]),
					":firstname"	=> htmlspecialchars($_POST["firstname"]),
					":address"		=> htmlspecialchars($_POST["address"]),
					":zipCode"		=> htmlspecialchars($_POST["zipCode"]),
					":city"			=> htmlspecialchars($_POST["city"]),
					":country"		=> htmlspecialchars($_POST["country"]),
					":phone"		=> htmlspecialchars($_POST["phone"]),
					":mail"			=> htmlspecialchars($_POST["mail"]),
					":password"		=> $password,
					":token"		=> $token
					]);//retourne 1 ou false
				
				if($result){
					//userConnect($_POST["mail"], $_POST["password"]);
					$subject = "Activer votre compte";
					$sendmail = ["html" => '<h1>Bienvenue sur notre site</h1><p>Pour activer votre compte, veuillez cliquer sur le lien ci dessous ou copier/coller dans votre navigateur internet:</p><br /><a href="http://localhost/site_biere_modif_s9_s10/mailConfirm.php?log='.urlencode($_POST["mail"]).'&token='.urlencode($token).'">cliquez pour valider votre compte</a><hr><p>Ceci est un mail automatique, Merci de ne pas y répondre.</p>'];
					sendMail($subject, $_POST["mail"], $sendmail);
					header('location: index.php?p=login');
				}else{
					die("pas ok");
					//TODO : signaler erreur
				}
			}else{//fin verif user existe
				userConnect($_POST["mail"], $_POST["password"]);
			}
		}//fin verification mail et password
// connexion
	}else if(isset($_POST["mail"]) && !empty($_POST["mail"]) &&
		isset($_POST["password"]) && !empty($_POST["password"]) &&
		isset($_POST["robot"]) && empty($_POST["robot"])//protection robot
	){

		userConnect($_POST["mail"], $_POST["password"]);



	}else if(isset($_POST["mail"]) && !empty($_POST["mail"])){
		//verifier que user exite
		//die("envoyer mail reset");
	
	// si rien
	}else{
		die('bac à sable');
	}
