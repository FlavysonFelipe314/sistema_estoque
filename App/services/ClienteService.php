<?php

namespace App\services;

use App\models\Cliente;
use App\repositories\ClienteRepository;
use Exception;

class ClienteService{

    private $ClienteRepository;

    public function __construct()
    {
        $this->ClienteRepository = new ClienteRepository;
    }

    public function create($name, $tel){
        try{
            $Cliente = new Cliente;
            $Cliente->setName($name);
            $Cliente->setTel($tel);
        
            $this->ClienteRepository->create($Cliente);
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }
    
    public function update($id, $name, $tel){
        try{
            $Cliente = new Cliente;
            $Cliente->setId($id);
            $Cliente->setName($name);
            $Cliente->setTel($tel);
        
            $this->ClienteRepository->update($Cliente);
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }
    
    public function findAll(){
        try{
            $Clientes = $this->ClienteRepository->findAll();
        
            return $Clientes;
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function findBy($key, $value){
        try{
            $Cliente = $this->ClienteRepository->findBy($key, $value);
            return $Cliente;

        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }
    public function findAllPagination($page){
        try{
            $Clientes = $this->ClienteRepository->findAllPagination($page);
        
            return $Clientes;
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function delete($id){
        try{
            $this->ClienteRepository->delete($id);

            return true;
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }
    
    

}

?>