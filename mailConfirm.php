<?php
	require_once('includes/function.php');
	$user = userOnly();
	//récupération des variables nécessaires à l'activation
	$token = urldecode($_GET['token']);
	$mail = urldecode($_GET['log']);
	//récupération du token et le verify (actif) correspondant au mail dans la db
	$pdo = getDB($dbuser, $dbpassword, $dbhost,$dbname);
	$sql = "SELECT token, mail, verify FROM users WHERE mail = ?";
	$statement = $pdo->prepare($sql);
	$result = $statement->execute([$mail]);
	$row = $statement->fetch();
	if ($result && $row){
		$tokendb = $row['token'];//recupération du token
		$verify = $row['verify'];//verify est à 0 ou 1
	}
	// On teste la valeur de la variable $actif récupéré dans la BDD
	if($verify == '1') // Si le compte est déjà actif on prévient
  	{
    	echo "Votre compte est déjà actif !";
  	}
	else // Si ce n'est pas le cas on passe aux comparaisons
  	{
     	if($token == $tokendb) // On compare nos deux clés	
       	{
          // Si elles correspondent on active le compte !	
        	echo "Votre compte a bien été activé !";
 
          // La requête qui va passer notre champ verify de 0 à 1
       		$pdo = getDB($dbuser, $dbpassword, $dbhost,$dbname);
        	$sql = "UPDATE `users` SET `verify` = 1 WHERE `mail`= :mail";
			$statement = $pdo->prepare($sql);
			$statement->execute([':mail' => $mail]);
       	}
     	else // Si les deux clés sont différentes on provoque une erreur...
       	{
        	echo "Erreur ! Votre compte ne peut être activé...";
       	}
  }
