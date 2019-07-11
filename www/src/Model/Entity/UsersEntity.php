<?php
namespace App\Model\Entity;

use Core\Model\Entity;

use Core\Controller\Helpers\TextController;

class UsersEntity extends Entity
{
    private $id;

    private $lastname;

    private $firstname;

    private $address;

    private $zipCode;

    private $city;

    private $country;

    private $phone;

    private $mail;

    private $password;

    private $token;

    private $createdAt;

    private $verify;

    public function getId()
    {
        return $this->id;
    }

    public function getlastname()
    {
        return $this->lastname;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getVerify()
    {
        return $this->verify;
    }
}