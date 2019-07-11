<?php
namespace App\Model\Table;

use Core\Model\Table;

class Orders_lineTable extends Table
{
    public function getLineWithProduct($token)
    {
        return $this->query("SELECT {$this->table}.*, beer.title FROM {$this->table}
                        JOIN beer ON {$this->table}.beer_id = beer.id 
                        WHERE token=?", [$token]);
    }
}