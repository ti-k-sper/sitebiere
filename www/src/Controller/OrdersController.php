<?php
namespace App\Controller;

use \Core\Controller\Controller;

use \Core\Controller\Helpers\MailController;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->loadModel('orders');
        $this->loadModel('beer');
    }

    public function purchaseOrder()
    {
        $beerArray = $this->beer->all();
        $user = $_SESSION['auth'];        
        $tva = getenv('ENV_TVA');
        $title = 'Beer shop - Purchase order';

        if (empty($_POST)) {
            return $this->render(
                'orders/purchaseOrder',
                [
                    "title" => $title,
                    "beerArray" => $beerArray,
                    "user" => $user,
                    "tva" => $tva
                ]
            );
        }

        if(isset($_POST)  && !empty($_POST)) {
            $auth = $_SESSION['auth'];
            $beerArray = $this->beer->all();
            $quantity = $_POST['qty'];
            $id_user = $auth->getId();
            $this->orders->createOrder($beerArray, $quantity, $id_user);
            //dd($this->orders->lastInsertId());
            $id = $this->orders->lastInsertId();
            //dd($id);
            $url = $this->generateUrl('confirm_order', ['id' => $id, 'id_user' => $id_user]);
            header('location: '.$url);
        }
    }
    
    public function confirmOrder($id, $id_user)
    {
        $order = $this->orders->find($id);
        //dump($order);
        $lines = $order->getIds_product();
        //dump($lines);
        $auth = $_SESSION['auth'];
        $tva = getenv('ENV_TVA');

        $title = 'Beer shop - Confirm order';
        return $this->render(
            'orders/confirmOrder',
            [
                "title" => $title,
                "order" => $order,
                "lines" => $lines,
                "auth" => $auth,
                "tva" => $tva
            ]
        );
    }
}