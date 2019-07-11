<?php
//bdd -> yannick -> biere [](table)
/* Connexion à une base MySQL avec l'invocation de pilote */
require 'config.php';
$dsn = 'mysql:dbname='.$dbname.';host='.$dbhost.';charset=UTF8';//localhost car sur mon ordi//charset pour forcer
try {
    $pdo = new PDO($dsn, $dbuser, $dbpassword);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}
