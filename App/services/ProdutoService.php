<?php

namespace App\services;

use App\models\Produto;
use App\repositories\ProdutoRepository;
use Exception;

class ProdutoService{

    private $ProdutoRepository;

    public function __construct()
    {
        $this->ProdutoRepository = new ProdutoRepository;
    }

    public function create($name, $quantidade, $totalHora){
        try{
            $Produto = new Produto;
            $Produto->setName($name);
            $Produto->setQuantidade($quantidade);
            $Produto->setTotalHora($totalHora);
        
            $this->ProdutoRepository->create($Produto);
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function update($id, $name, $quantidade, $totalHora){
        try{
            $Produto = new Produto;
            $Produto->setId($id);
            $Produto->setName($name);
            $Produto->setQuantidade($quantidade);
            $Produto->setTotalHora($totalHora);
        
            $this->ProdutoRepository->update($Produto);
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function findBy($key, $value){
        try{
            $Produto = $this->ProdutoRepository->findBy($key, $value);
            return $Produto;

        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function findAll(){
        try{
            $produtos = $this->ProdutoRepository->findAll();
        
            return $produtos;
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function findAllPagination($page){
        try{
            $produtos = $this->ProdutoRepository->findAllPagination($page);
        
            return $produtos;
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }
    
    public function delete($id){
        try{
            $this->ProdutoRepository->delete($id);
        
            return true;
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }
}

?>