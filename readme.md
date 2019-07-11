# sitebiere

## Version 3 : ajout de fonctionnalités

### Bon de commande de bières contenant :

### - la première page de description des bières disponibles

Un bouton "J'en veux" lance la seconde page

### - la seconde page contient le bon de commande à envoyer :

#### - un formulaire contient le nom et les coordonnées de l'acheteur

#### - un tableau contient le nom de la bière, le prix HT et TTC et la quantité à saisir par ligne

Le changement de quantité calcule automatiquement les prix HT et TTC de la ligne

#### - un bouton "envoyer" lance la troisième page

### - la troisième page contient la confirmation de la commande

Bonjour !
Voici la confirmation de votre commande

Le tableau qui récapitule les bières commandées et le total à payer

Un bouton "J'en veux encore !" qui relance la seconde page du bon de commande

## Version 4 : nouvelle fonctionnalité

### Page Boutique + Form inscription + Form connexion + Prise de commande + accès espace client avec affichage des commandes liée à celui-ci.

Pour ce défi, vous allez devoir créer une “petite boutique” de bières en ligne. En partant du site bière actuel, il vous faudra séparer les bières du formulaire de manière à ce que le site ressemble à cela au final : 

Page Biere => Compte ? FormConnexion : FormInscription=>FormAdresse(Prérempli)=>Confirmation de commande.

### 1. Rendre le site bière responsive

Peu importe la technologie employée.

### 2. Mettre tableau bière en bdd puis récupérer les données pour les afficher

* Créer une table nommée "bières"
* Lui assigner autant de colonnes que nécessaire
* Y insérer les données du tableau bière (Interdiction de rentrer les données à la main dans phpmyadmin)

### 3. Création du formulaire d’inscription

Créez un formulaire contenant les champs suivants:
* Nom
* Prénom
* Adresse
* Code postale
* Ville
* Pays
* Téléphone
* Mail
* Mot de passe  

### 4. Mise en fonction du formulaire d’inscription

Créez un nouvel utilisateur en bdd à chaques inscriptions  

### 5. Création du formulaire de connexion

Créez un formulaire contenant les champs suivants:
* Adresse mail
* Mot de passe  

### 6. Mise en fonction du formulaire de connexion

Vérifiez les données reçues puis établir ou non la connexion  

### 7. Création espace client

Créer un espace client html5 qui présentera :
* Une possibilité de modifier ses données personnelles hors adresse mail.
* Un tableau affichant le contenu des commandes passées par l’utilisateur.  
    * Numéro de commande
    * Nombre de référence produit
    * Prix total de la commande

### 8. Petite aide

* La table commande disposera de 4 colonnes :
    * id(int)
    * id_client(int)
    * ids_product(text)
    * id_prix_TTC(float)

* Pour la colonne ids_product, il vous sera nécessaire de lui envoyer un tableau contenant les ids de tous les produits commandés. Pour ce faire vous aurez besoin d’utiliser la methode serialize :  [Serialize](https://www.php.net/manual/fr/function.serialize.php)
* Et bien sûr, il vous faudra également une méthode pour réutiliser ce tableau une fois récupéré de la bdd. Je vous laisse chercher !

### Installation  

Renommez config_sample.php en config.php  


## Version 6 : Fusion site bière et le blog MVC


### Cheminement de la fusion : 

#### Etape 1 :  

- Récupération des fichiers et dossiers de blog_MVC


#### Etape 2 :  

- Récupération du fichier "adminer.php" et le mettre dans www/public
- Modifier le fichier ".env", "start.sh", "created.sql" et "docker-compose.yml"


#### Etape 3 :  

- Récupération requète sql création des tables du site bière et les rajouter au fichier "createsql.php"
- Lancer les containers avec "start.sh"
- Vérifier les nouvelles tables dans "adminer"


### Etape 4 :  

- Création URL pour atteindre accueil de la boutique (et la mettre par défaut)
- Création des fichiers twig en lien à l'accueil, avec un fichier defaultBeerShop.twig (pour avoir par défaut un header et un footer), ainsi qu'un fichier home.twig (pour le content)
- Création class BeerController avec la méthode home()


#### Etape 5 :  

- Création URL pour atteindre la page de tous les articles de la boutique
- Création du fichier twig articles.twig (pour le content)
- Création dans class BeerController, la méthode all()


#### Etape 6 :  

- Création URL pour atteindre la page de connexion et d'inscription de la boutique
- Création du fichier twig signin.twig, signup.twig (pour le content)
- Création dans class UsersController, la méthode signin() et signup()
- Dans signup(), utilisation méthode verifMail() et userCreate() provenant UserTable
- Installation swiftmailer
- Création MailController et methode sendMail() pour utiliser swiftmailer
- Dans signup(), utilisation de sendmail()
- Dans signin(), utilisation de confirmMail() et updateVerifyMail
- Dans signin(), dans le render ajoue variable $message et ajoue dans le signin.twig, message sous condition pour le faire appaitre ou pas
- dans signin(), utilisation methode userConnect()
- Création URL pour deconnection, méthode disconnect()


#### Etape 7 :  

- Création URL pour atteindre la page bon de commande de la boutique
- Création du fichier twig purchaseOrder.twig
- Création dans class OrdersController, la méthode purchaseOder()
- Dans purchaseOrder(), utilisation methode createOrder() provenant de Orders Table
- Dans purchaseOrder(), utilisation methode lastInsertId() provenant de Table, elle-même provenant de DatabaseMysqlController
- Dans purchaseOrder.twig, action="/purchase_order
- Création URL pour confirm_order, méthode confirmOrder()
- Création du fichier twig confirmOrder.twig


## Version 7 : évolution fusion avec uml (récupération fusion formateur)

#### Etape 8 :

- Suite au cours sur l'UML (dans www/public/assets/source/biereblog_uml.png) et de la récupération des fichiers du formateur, faire les mêmes étapes que la version 6

#### Etape 9 :

- Créer un panier

#### WIP :

- Ajout au produit, d'un input et d'un button avec un formulaire pour ainsi créer un panier
- Utiliser AJAX pour remplire table "orders_line"

#### TODO :

- Page "Panier"  
- Page "Contact"
- Récupérer vérification mail/compte (fusion biereblog)
- Envoie mail avec facture
- Pages "CGV" et "Mentions légales"
- CSS en responsive "first mobil"
- Nettoyage du code (enlever les dd() et les dumps())