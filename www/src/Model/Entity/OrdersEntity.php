<?php
namespace App\Model\Entity;

use Core\Model\Entity;

use Core\Controller\Helpers\TextController;

class OrdersEntity extends Entity
{
    private $id;

    private $id_user;

    private $ids_product;

    private $priceTTC;

    public function getId()
    {
        return $this->id;
    }

    public function getId_user()
    {
        return $this->id_user;
    }

    public function getIds_product()
    {
        return unserialize($this->ids_product);
    }

    public function getPriceTTC()
    {
        return $this->priceTTC;
    }
}