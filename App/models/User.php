<?php

namespace App\models;

class User
{
    private $id;
    private $name;
    private $password;
    private $email;
    private $cargo;
    private $token;
    private $created_at;
    private $updated_at;

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCargo()
    {
        return $this->cargo;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}

?>