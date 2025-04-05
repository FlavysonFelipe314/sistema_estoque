<?php

namespace App\services;

use App\models\User;
use App\repositories\UserRepository;
use Exception;

class UserService{

    private $UserRepository;

    public function __construct()
    {
        $this->UserRepository = new UserRepository;
    }


    public function findAll(){
        try{
            $produtos = $this->UserRepository->findAll();
        
            return $produtos;
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function findAllPagination($page){
        try{
            $produtos = $this->UserRepository->findAllPagination($page);
        
            return $produtos;
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }


    public function findAllBy($key, $value){
        try{
            $produtos = $this->UserRepository->findAllBy($key, $value);
        
            return $produtos;
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }


    public function delete($id){
        try{
            $this->UserRepository->delete($id);
        
            return true;
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function search($termo){
        try{
            $results = $this->UserRepository->search($termo);
        
            return $results;
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }
    

}

?>