<?php
namespace App\Controller;

use \Core\Controller\Controller;

class UsersController extends Controller
{
    public function __construct() {
        $this->loadModel('user');
        $this->loadModel('user_infos');
        $this->loadModel('orders');
        $this->loadModel('orders_line');
    }

    public function login(): void
    {
        $message = false;
        if(count($_POST) > 1) {
            $password = htmlspecialchars($_POST['password']);
            $user = $this->user->getUser(htmlspecialchars($_POST['mail']), $password);
            if($user) {
                $_SESSION['user'] = $user;
                header('location: /');
                exit();
            }
            else {
                $message = "Adresse mail ou mot de passe incorrect";
            }
        }
        $this->profile($message);
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        header('location: /');
        exit();
    }

    public function subscribe() {
        if(count($_POST) > 0) {
            //Création d'un tableau regroupant mes champs requis
            $requiredFields=['mail', 'password'];
            
            //On boucle sur le tableau requiredFields
            foreach($requiredFields as $key => $value) {
                //On verifie que $_POST["firstname"](si $value="firstname) existe.
                if(!$_POST[$value]) {
                    //Si n'existe pas redirection vers page d'inscription
                    header('location: /inscription');
                    exit();// PAS OUBLIERRRRRRRRRRR!!!!!!!!
                }
                //On Sécurise chaque donnée de $_POST et on les stocke dans $fields[]
                $fields[$value] = htmlspecialchars($_POST[$value]);
            }

            if($fields['mail'] == $_POST["mailVerify"]) {// Comparaison d'égalité
                if($fields['password'] == $_POST["passwordVerify"]) {// Comparaison d'égalité
                    //Hashage du password $fields["password]
                    $fields['password'] = password_hash($fields['password'], PASSWORD_BCRYPT);
                    //Création d'un token
                    $token = substr(md5(uniqid()), 0, 10);
        
                    $fields['token']= $token;//Stockage du token dans $fieds["token"]
                    //Appel de la methode create de la Table Parente (core/Table.php)
                    if($this->user->create($fields)) {
                        $_SESSION['success'] = "Votre inscription à bien été prise en compte";
                    }
                    else {
                        $_SESSION['error'] = 'une erreur s\'est produite';
                    }
                    header('location: /login');
                    exit();
                }
            }
        }
        return $this->render('user/subscribe');
    }

    public function profile($message = null) {
        if(null !== $_SESSION['user'] && $_SESSION['user']) {
            $file = 'profile';
            $page = 'Mon profil';
            $user_id = $_SESSION['user']->getId();
            $user_info = $this->user_infos->find($user_id, 'user_id');
            $orders = $this->orders->findAll($user_id, 'userInfos_id');
            $totalOrder = false;
            if (!empty($orders)) {
                $totalOrder = true;
            }
        }
        else {
            $file = 'login';
            $page = 'Connexion';
        }
        
        return $this->render('user/'.$file, [
            'page' => $page,
            'message' => $message,
            'totalOrder' => $totalOrder,
            'orders' => $orders,
            'userInfo' => $user_info
        ]);
        unset($_SESSION['success']);
    }

    public function updateUser() {
        //dump($_SESSION);
        if(count($_POST) > 0) {
            //dump($_POST);
            $user_id = (int) array_pop($_POST);//Stockage de la dernière case de $_POST dans $id
            //Mise à jours bdd grace à methode update de /core/Table.php
            //dd($user_id);
            $arrayUserInfos = $_POST;
            //dump($arrayUserInfos);
            $arrayUserInfos["user_id"] = $user_id;
            //dd($arrayUserInfos);
            $verifUserId = $this->user_infos->find($user_id, "user_id");
            //dd($verifUserId);
            if (empty($verifUserId)) {
                $this->user_infos->create($arrayUserInfos);
                //dd('table rempli');
            }
            $updateUserInfo = $this->user_infos->update($user_id, 'user_id', $_POST);
            //dd($updateUserInfo, 'table modifiée');
            //Mise à jours de la SESSION['user']
            //dump($_SESSION);
            //dump($_POST);
            $user = $this->user->getUserByid($user_id);
            //dump($user);
            //dd($_SESSION);
            $_SESSION['user'] = $user;
            //dd($_SESSION['user']);

            $this->profile('Votre profil a bien été mis à jour');//Appel de la methode profile de ce controller pour redirection
            exit();
        }
    }

    public function changePassword() {
        if(count($_POST) > 0) {
            $user = $this->user->getUserById(htmlspecialchars($_POST['id']));
            //Vérification de l'ancien mot de passe mots de passes
            if(password_verify(htmlspecialchars($_POST['old_password']), $user->getPassword())) {
                //Vérification correspondance des mots de passe
                if(htmlspecialchars($_POST['password']) == htmlspecialchars($_POST['veriftyPassword'])) {
                    //Hashage du password
                    $password = password_hash(htmlspecialchars(htmlspecialchars($_POST['password'])), PASSWORD_BCRYPT);

                    //Mise à jour de la bdd grace à methode update de /core/Table.php
                    if($this->user->update($_POST['id'], 'id', ['password' => $password])) {
                        $message = 'Votre mot de passe a bien été modifié';
                    }
                    else {
                        $message = 'Une erreur s\'est produite';
                    }
                }
                else {
                    $message = 'Les mots de passes ne correspondent pas';
                }
            }
            else {
                $message = 'Mot de passe erroné';
            }
            return $this->profile($message);//Appel de la methode profile de ce controller pour redirection
            exit();
        }
    }

    public function showDetail(string $token, int $id)
    {
        $order = $this->orders->find($token, 'token');
        $ordertva = $order->getOrdersTva();
        $orderpriceHT = $order->getPriceHT();
        $userinfosid = $order->getUserInfosId();
        $user_infos = $this->user_infos->find($userinfosid, 'user_id');
        $orderslines = $this->orders_line->getLineWithProduct($token);
        if (!$orderslines) {
            throw new \Exception('Aucune commande ne correspond à ce token');
        }
        $this->render(
            "user/detail",
            [
                "orderslines" => $orderslines,
                "ordertva" => $ordertva,
                "orderpriceHT" => $orderpriceHT,
                'user' => $user_infos
            ]
        );
    }
}
