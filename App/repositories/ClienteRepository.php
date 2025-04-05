<?php

namespace App\repositories;

use App\core\Repository;
use App\interfaces\ClienteInterface;
use App\models\Cliente;
use PDO;
use PDOException;

class ClienteRepository extends Repository implements ClienteInterface {

    public function create(Cliente $cliente)
    {
        try {
            $sql = $this->pdo->prepare("INSERT INTO clientes (name, tel) VALUES (:name, :tel)");
            $sql->bindValue(":name", $cliente->getName());
            $sql->bindValue(":tel", $cliente->getTel());
            $sql->execute();
        } catch (PDOException $err) {
            echo "Algo deu Errado: $err";
        }
    }

    public function update(Cliente $cliente)
    {
        try {
            $sql = $this->pdo->prepare("UPDATE clientes SET name = :name, tel = :tel WHERE id = :id");
            $sql->bindValue(":name", $cliente->getName());
            $sql->bindValue(":tel", $cliente->getTel());
            $sql->bindValue(":id", $cliente->getId());
            $sql->execute();
        } catch (PDOException $err) {
            echo "Algo deu Errado: $err";
        }
    }

    public function findAll()
    {
        try {
            $sql = $this->pdo->prepare("SELECT * FROM clientes ORDER BY created_at DESC");
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                $array = [];

                foreach ($data as $item) {
                    $cliente = $this->_generateCliente($item);
                    $array[] = $cliente;
                }
                return $array;
            } else {
                return false;
            }
        } catch (PDOException $err) {
            echo "Algo deu Errado: $err";
        }
    }

    public function findBy($key, $value)
    {
        try {
            $sql = $this->pdo->prepare("SELECT * FROM clientes WHERE $key = :$key");
            $sql->bindValue(":$key", "$value");
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $cliente = $this->_generateCliente($data);

                return $cliente;
            } else {
                return false;
            }
        } catch (PDOException $err) {
            echo "Algo deu Errado: $err";
        }
    }


    public function findAllPagination($page)
    {
        try {
            $limit = 5;
            $offset = ($page - 1) * $limit;

            $sql = $this->pdo->prepare("SELECT * FROM clientes ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
            $sql->bindValue(":limit", $limit, PDO::PARAM_INT);
            $sql->bindValue(":offset", $offset, PDO::PARAM_INT);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                $array = [];

                foreach ($data as $item) {
                    $cliente = $this->_generateCliente($item);
                    $array[] = $cliente;
                }

                $sqlTotal = $this->pdo->query("SELECT COUNT(*) as total FROM clientes");
                $totalRegistros = $sqlTotal->fetch(PDO::FETCH_ASSOC)['total'];

                $totalPaginas = ceil($totalRegistros / $limit);
                $array["pages"] = $totalPaginas;

                return $array;
            } else {
                return false;
            }
        } catch (PDOException $err) {
            echo "Algo deu Errado: $err";
        }
    }

    public function delete($id)
    {
        try {
            $sql = $this->pdo->prepare("DELETE FROM clientes WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
        } catch (PDOException $err) {
            echo "Algo deu Errado: $err";
        }
    }

    private function _generateCliente($data)
    {
        $cliente = new Cliente();
        $cliente->setId($data["id"]);
        $cliente->setName($data["name"]);
        $cliente->setTel($data["tel"]);
        $cliente->setCreatedAt($data["created_at"]);
        $cliente->setUpdatedAt($data["updated_at"]);

        return $cliente;
    }
}
