<?php
namespace App\Controller;

use \Core\Controller\Controller;

class ShopController extends Controller
{
    public function __construct() {
        $this->loadModel('beer');
        $this->loadModel('user');
        $this->loadModel('user_infos');
        $this->loadModel('config');
        $this->loadModel('orders');
        $this->loadModel('orders_line');
    }

    public function index()
    {
        return $this->render('shop/index');
    }

    public function all() {
        $beers = $this->beer->all();
        $id_config = $this->config->last();
        $info_config = $this->config->find($id_config);
        $tva = $info_config->getTva();
        
        return $this->render('shop/boutique', [
            'beers' => $beers,
            'tva' => $tva
        ]);
    }

    public function purchaseOrder() {
        $id_config = $this->config->last();
        $info_config = $this->config->find($id_config);
        $tva = $info_config->getTva();
        if(count($_POST) > 0) {
            foreach($_POST['qty'] as $key => $value) {
                if($value > 0) {
                    $ids[] = $key;
                    $qty[] = $value;
                }
            }
            $ids = implode($ids, ',');

            $beers = $this->beer->getAllInIds($ids);
            $orderTotal = 0;
            $token = substr(md5(uniqid()), 0, 10);
            $user_id = $_SESSION['user']->getId();    
            $priceTotalHT = 0;
            foreach($beers as $key => $value) {
                $orderTotal += $value->getPriceHT() * $tva * $qty[$key];
                $priceTotalHT += $value->getPriceHT() * $qty[$key];
                $beer_id = $value->getId();
                $beerPriceHT = $value->getPriceHT();
                $beerQty = $qty[$key];
                $beerOrderLine = [
                    "user_id" => $user_id,
                    "beer_id" => $beer_id,
                    "beerPriceHT" => $beerPriceHT,
                    "beerQty" => $beerQty,
                    "token" => $token
                ];
                $orderLine = $this->orders_line->create($beerOrderLine);
            }
            $user_infos = $this->user_infos->find($user_id, 'user_id');
            $userInfos_id = $user_infos->getUserId();
            $port = $info_config->getPort();
            $ordersTva = $tva;
            $status_id = 1;
            $orderArray = [
                "userInfos_id" => $userInfos_id,
                "priceHT" => $priceTotalHT,
                "port" => $port,
                "ordersTva" => $ordersTva,
                "status_id" => $status_id,
                "token" => $token
            ];
            $order = $this->orders->create($orderArray);

            return $this->render('shop/confirmationDeCommande', [
                'beers' => $beers,
                'data' => $_POST,
                'qty' => $qty,
                'order' => $orderTotal,
                'tva' => $tva,
                'user' => $user_infos
            ]);
        }

        $beers = $this->beer->all();
        $mail = $_SESSION['user']->getMail();
        $user_id = $_SESSION['user']->getId();
        $user_infos = $this->user_infos->find($user_id, 'user_id');

        return $this->render('shop/bondecommande', [
            'beers' => $beers,
            'user' => $user_infos,
            'mail' => $mail,
            'tva' => $tva
        ]);
    }

    public function showPanier() {
        
        return $this->render('shop/panier', [
            'beers' => $beers,
            'tva' => $tva
        ]);
    }

    public function addToPanier()
    {
        if (count($_POST) > 0) {
            foreach($_POST['qty'] as $key => $value) {
                if($value > 0) {
                    $id = $key;
                    $qty = $value;
                }
            }
            $beer = $this->beer->find($id);
            $token = 'visiteurtk';
            $user_id = '0';    
            $beer_id = $beer->getId();
            $beerPriceHT = $beer->getPriceHT();
            $beerQty = $qty;
            $beerOrderLine = [
                "user_id" => $user_id,
                "beer_id" => $beer_id,
                "beerPriceHT" => $beerPriceHT,
                "beerQty" => $beerQty,
                "token" => $token
            ];
            $orderLine = $this->orders_line->create($beerOrderLine);
        }
    }

    public function contact() {
        return $this->render('shop/contact', [
        ]);
    }

}
