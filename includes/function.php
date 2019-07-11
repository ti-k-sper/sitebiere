<?php
require_once 'config.php';
require_once 'vendor/autoload.php';
date_default_timezone_set('Europe/Paris');


/**
* retourne le nom du dossier
*
* @return string
*/
function uri($cible="")//:string
{
	global $racine; //Permet de récupérer une variable externe à la fonction
	$uri = "http://".$_SERVER['HTTP_HOST']; 
	$folder = "";
	if(!$racine) {
		$folder = basename(dirname(dirname(__FILE__))).'/'; //Dossier courant, direname = chemin courant, basename = dernier élément
	}
	return $uri.'/'.$folder.$cible;
}


/**
* crée une connexion à la base de données
*	@return \PDO
*/

function getDB(	$dbuser='root', 
				$dbpassword='', 
				$dbhost='localhost',
				$dbname='sitebeer') //:\PDO
{
	

	$dsn = 'mysql:dbname='.$dbname.';host='.$dbhost.';charset=UTF8';
	try {
    	$pdo = new PDO($dsn, $dbuser, $dbpassword);

    	//definit mode de recupération en mode tableau associatif
    	// $user["lastname"];
    	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    	//definit mode de recupération en mode Objet
    	//$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    	// $user->lastname;
    	return $pdo;

	} catch (PDOException $e) {
    	echo 'Connexion échouée : ' . $e->getMessage();
    	die();
	}
}


/**
*	génère un champ de formulaire de type input
*	@return String
*/

function input($name, $label, $value="", $type='text', $require=true)//:string
{
	$input = "<div class=\"form-group\"><label for=\"".
	$name."\">".$label.
	"</label><input id=\"".
	$name."\" type=\"".$type.
	"\" name=\"".$name."\" value=\"".$value."\" ";
	$input .= ($require)? "required": "";
	$input .= "></div>";

	return $input;
}

/**
* Connect le client
* @return boolean|void
*/
function userConnect($mail, $password, $verify=false){//:boolean|void
	require 'config.php';

	$sql = "SELECT * FROM users WHERE `mail`= ?";
	$pdo = getDB($dbuser, $dbpassword, $dbhost,$dbname);

		$statement = $pdo->prepare($sql);
		$statement->execute([htmlspecialchars($mail)]);
		$user = $statement->fetch();
		if(	$user && 
			password_verify(
			htmlspecialchars($password), $user['password']
			&& $user['verify'] == 1)){
				if($verify){
					return true;
					//exit();
				}

				if (session_status() != PHP_SESSION_ACTIVE){
					session_start();
				}
				unset($user['password']);
				$_SESSION['auth'] = $user;
				//connecté
				header('location: index.php?p=profil');
				exit();

		}else{

			if($verify){
				return false;
				//exit();
			}
			if (session_status() != PHP_SESSION_ACTIVE){
					session_start();
				}
			$_SESSION['auth'] = false;
			header('location: index.php?p=login');
			//TODO : err pas connecté
		}

}



/**
* verifie que l'utilisateur est connecté
* @return array|void|boolean
*/
function userOnly($verify=false){//:array|void|boolean
	if (session_status() != PHP_SESSION_ACTIVE){
		session_start();//démarre une session
	}
	// est pas defini et false
	if(!isset($_SESSION["auth"])){
		//si verify = true, retourne false
		if($verify){
			return false;
		//exit();
		}
		header('location: index.php?p=login');
		exit();
	}
	return $_SESSION["auth"];
}

/**
* fonction envoyer mail
* @return string
*/
function sendMail($subject, $pMailTo, $pMessage, $pMailToBcc = true){//:string
	require 'config.php';

// Create the Transport, tls = plus secure que ssl
	$transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
  	->setUsername($setUsername)
  	->setPassword($setPassword)
	;

// Create the Mailer using your created Transport
	$mailer = new Swift_Mailer($transport);

// Create a message
	if (!is_array($pMailTo)) {
		$pMailTo = [$pMailTo];
	}
	
	/*if ($pMailToBcc == true) {
		$message = (new Swift_Message($subject))
  		->setFrom([$setUsername => $pseudo])
  		->setBody($pMessage)
  		->setBcc($pMailTo);
  	}else{
  		$message = (new Swift_Message($subject))
  		->setFrom([$setUsername => $pseudo])
  		->setBody($pMessage)
  		->setTo($pMailTo);
  	}*/
  	//ma condition correspondant à
  	$message = (new Swift_Message($subject));
  	$message->setFrom([$setUsername => $pseudo]);

  	if ($pMailToBcc == true){
  		$message->setBcc($pMailTo);
  	}else{
  		$message->setTo($pMailTo);
  	}

  	if (is_array($pMessage) && array_key_exists("html", $pMessage) && array_key_exists("text", $pMessage)) {
		$message->setBody($pMessage["html"], 'text/html');
		//ou
		$message->addPart($pMessage["text"], 'text/plain');

	}elseif (is_array($pMessage) && array_key_exists("html", $pMessage)) {
		$message->setBody($pMessage["html"], 'text/html');
		$message->addPart($pMessage["html"], 'text/plain');

	}elseif (is_array($pMessage) && array_key_exists("text", $pMessage)) {
		$message->setBody($pMessage["text"], 'text/plain');

	}elseif (is_array($pMessage)) {
		die('erreur une clé n\'est pas bonne');

	}else{
		$message->setBody($pMessage, 'text/plain');
	}
  	
  	

// Send the message
	return $mailer->send($message);//donne le nb de message ou false

}



