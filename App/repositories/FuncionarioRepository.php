<?php

namespace App\repositories;

use App\core\Repository;
use App\interfaces\FuncionarioInterface;
use App\models\Funcionario;
use PDO;
use PDOException;

class FuncionarioRepository extends Repository implements FuncionarioInterface {

    public function create(Funcionario $funcionario)
    {
        try {
            $sql = $this->pdo->prepare("INSERT INTO funcionarios (name, cpf) VALUES (:name, :cpf)");
            $sql->bindValue(":name", $funcionario->getName());
            $sql->bindValue(":cpf", $funcionario->getCpf());
            $sql->execute();
        } catch (PDOException $err) {
            echo "Algo deu Errado: $err";
        }
    }

    public function update(Funcionario $funcionario)
    {
        try {
            $sql = $this->pdo->prepare("UPDATE funcionarios SET name = :name, cpf = :cpf WHERE id = :id");
            $sql->bindValue(":name", $funcionario->getName());
            $sql->bindValue(":cpf", $funcionario->getCpf());
            $sql->bindValue(":id", $funcionario->getId());
            $sql->execute();
        } catch (PDOException $err) {
            echo "Algo deu Errado: $err";
        }
    }

    public function findAll()
    {
        try {
            $sql = $this->pdo->prepare("SELECT * FROM funcionarios ORDER BY created_at DESC");
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                $array = [];

                foreach ($data as $item) {
                    $funcionario = $this->_generateFuncionario($item);
                    $array[] = $funcionario;
                }

                return $array;
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

            $sql = $this->pdo->prepare("SELECT * FROM funcionarios ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
            $sql->bindValue(":limit", $limit, PDO::PARAM_INT);
            $sql->bindValue(":offset", $offset, PDO::PARAM_INT);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                $array = [];

                foreach ($data as $item) {
                    $funcionario = $this->_generateFuncionario($item);
                    $array[] = $funcionario;
                }

                $sqlTotal = $this->pdo->query("SELECT COUNT(*) as total FROM funcionarios");
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
            $sql = $this->pdo->prepare("DELETE FROM funcionarios WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
        } catch (PDOException $err) {
            echo "Algo deu Errado: $err";
        }
    }

    private function _generateFuncionario($data)
    {
        $funcionario = new Funcionario();
        $funcionario->setId($data["id"]);
        $funcionario->setName($data["name"]);
        $funcionario->setCpf($data["cpf"]);
        $funcionario->setCreatedAt($data["created_at"]);
        $funcionario->setUpdatedAt($data["updated_at"]);

        return $funcionario;
    }
}
