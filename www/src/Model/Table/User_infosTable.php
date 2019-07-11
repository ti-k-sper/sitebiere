<?php
namespace App\Model\Table;

use Core\Model\Table;

class User_infosTable extends Table
{
    public function getUserInfosByid($user_id) {
        return $this->query("SELECT * FROM $this->table
        WHERE id = ?", [$user_id], true);
    }
}