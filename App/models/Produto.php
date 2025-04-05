<?php

namespace App\models;

class Produto{

    private $id;
    private $name;
    private $quantidade;
    private $totalHora;
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

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }

    public function setTotalHora($totalHora)
    {
        $this->totalHora = $totalHora;
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

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function getTotalHora()
    {
        return $this->totalHora;
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