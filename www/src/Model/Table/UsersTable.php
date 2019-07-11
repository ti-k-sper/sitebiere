<?php
namespace App\Model\Table;

use Core\Model\Table;

class UsersTable extends Table
{
    public function verifMail($mail)
    {
        return $this->query("SELECT * FROM users WHERE `mail`= :mail", [":mail"=>$mail], true);
    }

    public function userCreate($arrayUser)
    {
        return $this->query("INSERT INTO `users` (`lastname`, `firstname`, `address`, `zipCode`, `city`, `country`, `phone`, `mail`, `password`, `token`) VALUES (
            :lastname,				 
            :firstname,
            :address,
            :zipCode, 
            :city,
            :country,
            :phone,
            :mail,
            :password,
            :token
            )", $arrayUser);
    }

    public function confirmMail($mail)
    {
        return $this->query("SELECT token, mail, verify FROM users WHERE mail = :mail", [":mail"=>$mail], true);
    }

    public function updateVerifyMail($mail)
    {
        return $this->query("UPDATE users SET verify = 1 WHERE mail = :mail", [":mail"=>$mail]);
    }

    public function userConnect($mail)
    {
        return $this->query("SELECT * FROM users WHERE `mail`= :mail", [":mail"=>$mail], true);
    }
}