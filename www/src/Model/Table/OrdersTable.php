<?php
namespace App\Model\Table;

use Core\Model\Table;

class OrdersTable extends Table
{
    public function createOrder($beerArray, $quantity, $id_user)
    {
        $tva = getenv('ENV_TVA');
        $beerTotal = [];
        foreach ($beerArray as $key => $beer) {
            $beerTotal[$beer->getId()]= $beer;
        }
        //dd($beerTotal);
        $priceTTC = 0;
        foreach($quantity as $key => $valueQty) { //on boucle sur le tableau $_POST["qty"]
            if($valueQty > 0) {
                $price = $beerTotal[$key]->getPrice();
                //dd($price);
                $name = $beerTotal[$key]->getTitle();
                $qty[$key] = ['name' => $name, 'qty' => $valueQty, "price"=>$price];
                $priceTTC += $valueQty * $price * $tva;
            }
            
        }
        $serialCommande = serialize($qty); //On convertit le tableau $qty en String pour 												l'envoyer en bdd plus tard.
        $attributes = [":id_user"=>$id_user, ":ids_product"=>$serialCommande, ":priceTTC"=>$priceTTC];
        $statement = "INSERT INTO `orders` (`id_user`,`ids_product`,`priceTTC`) VALUES (:id_user, :ids_product, :priceTTC)";
        $this->query($statement, $attributes);
    }
}