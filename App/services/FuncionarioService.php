<?php

namespace App\services;

use App\models\Funcionario;
use App\repositories\FuncionarioRepository;
use Exception;

class FuncionarioService{

    private $FuncionarioRepository;

    public function __construct()
    {
        $this->FuncionarioRepository = new FuncionarioRepository;
    }

    public function create($name, $cpf){
        try{
            $Funcionario = new Funcionario;
            $Funcionario->setName($name);
            $Funcionario->setCpf($cpf);
        
            $this->FuncionarioRepository->create($Funcionario);
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function findAll(){
        try{
            $Funcionarios = $this->FuncionarioRepository->findAll();

            return $Funcionarios;
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function findAllPagination($page){
        try{
            $Funcionarios = $this->FuncionarioRepository->findAllPagination($page);
        
            return $Funcionarios;
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function delete($id){
        try{
            $this->FuncionarioRepository->delete($id);
        
            return true;
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }
    
    

}

?>