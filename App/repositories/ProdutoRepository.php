<?php

namespace App\repositories;

use App\core\Repository;
use App\interfaces\ProdutoInterface;
use App\models\Produto;
use PDO;
use PDOException;

class ProdutoRepository extends Repository implements ProdutoInterface{

    public function create(Produto $produto)
    {
        try{
            $sql = $this->pdo->prepare("INSERT INTO produtos (name, quantidade, total_hora)
            VALUES (:name, :quantidade, :total_hora)");
            $sql->bindValue(":name", $produto->getName());
            $sql->bindValue(":quantidade", $produto->getQuantidade());
            $sql->bindValue(":total_hora", $produto->getTotalHora());
            $sql->execute();
        } catch(PDOException $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function update(Produto $produto)
    {
        try{
            $sql = $this->pdo->prepare("UPDATE produtos SET
            name = :name,
            quantidade = :quantidade,
            total_hora = :total_hora
            WHERE id = :id");

            $sql->bindValue(":name", $produto->getName());
            $sql->bindValue(":quantidade", $produto->getQuantidade());
            $sql->bindValue(":total_hora", $produto->getTotalHora());
            $sql->bindValue(":id", $produto->getId());
            $sql->execute();
        } catch(PDOException $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function findAll()
    {
        try{
            $sql = $this->pdo->prepare("SELECT * FROM produtos ORDER BY created_at DESC");
            $sql->execute();
    
            if($sql->rowCount() > 0){
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                $array = [];
    
                foreach($data as $item){
                    $produto = $this->_generateProduto($item);
    
                    $array[] = $produto;
                }

                return $array;
            }
            else{
                return false;
            }
        } catch(PDOException $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function findAllPagination($page)
    {
        try{
            $limit = 5;
            $offset = ($page - 1) * $limit;

            $sql = $this->pdo->prepare("SELECT * FROM produtos ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
            $sql->bindValue(":limit", $limit, PDO::PARAM_INT);
            $sql->bindValue(":offset", $offset, PDO::PARAM_INT);
            $sql->execute();
    
            if($sql->rowCount() > 0){
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                $array = [];
    
                foreach($data as $item){
                    $produto = $this->_generateProduto($item);
    
                    $array[] = $produto;
                }
    
                $sqlTotal = $this->pdo->query("SELECT COUNT(*) as total FROM produtos");
                $totalRegistros = $sqlTotal->fetch(PDO::FETCH_ASSOC)['total'];

                $totalPaginas = ceil($totalRegistros / $limit);

                $array["pages"] = $totalPaginas;                

                return $array;
            }
            else{
                return false;
            }
        } catch(PDOException $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function findBy($key, $value)
    {
        try {
            $sql = $this->pdo->prepare("SELECT * FROM produtos WHERE $key = :$key");
            $sql->bindValue(":$key", "$value");
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $produto = $this->_generateProduto($data);

                return $produto;
            } else {
                return false;
            }
        } catch (PDOException $err) {
            echo "Algo deu Errado: $err";
        }
    }
    public function findAllBy($query, $value)
    {}

    public function delete($id)
    {
        try{
            $sql = $this->pdo->prepare("DELETE FROM produtos WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
        } catch(PDOException $err){
            echo "Algo deu Errado: $err";
        }
    }


    private function _generateProduto($data)
    {
        $Produto = new Produto;
        $Produto->setId($data["id"]);
        $Produto->setName($data["name"]);
        $Produto->setQuantidade($data["quantidade"]);
        $Produto->setTotalHora($data["total_hora"]);
        $Produto->setCreatedAt($data["created_at"]);
        $Produto->setUpdatedAt($data["updated_at"]);

        return $Produto;
    }
}
