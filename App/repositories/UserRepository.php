<?php

namespace App\repositories;

use App\core\Repository;
use App\interfaces\UserInterface;
use App\models\User;
use PDO;
use PDOException;

class UserRepository extends Repository implements UserInterface{

    public function create(User $user)
    {
        $sql = $this->pdo->prepare("INSERT INTO users 
        (name, email, password, cargo, token) VALUES (:name, :email, :password, :cargo, :token)");
        $sql->bindValue(":name", $user->getName());
        $sql->bindValue(":password", $user->getPassword());
        $sql->bindValue(":cargo", $user->getCargo());
        $sql->bindValue(":email", $user->getEmail());
        $sql->bindValue(":token", $user->getToken());
        $sql->execute();
    }
    
    public function update(User $user)
    {
        $sql = $this->pdo->prepare("UPDATE users SET
            name = :name,
            email = :email,
            password = :password,
            token = :token 
        WHERE id = :id");

        $sql->bindValue(":name", $user->getName());
        $sql->bindValue(":email", $user->getEmail());
        $sql->bindValue(":password", $user->getPassword());
        $sql->bindValue(":token", $user->getToken());
        $sql->bindValue(":id", $user->getId());
        $sql->execute();
    }

    public function findAll()
    {
        try {
            $sql = $this->pdo->prepare("SELECT * FROM users ORDER BY created_at DESC");
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                $array = [];

                foreach ($data as $item) {
                    $user = $this->_generateUser($item);
                    $array[] = $user;
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

            $sql = $this->pdo->prepare("SELECT * FROM users ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
            $sql->bindValue(":limit", $limit, PDO::PARAM_INT);
            $sql->bindValue(":offset", $offset, PDO::PARAM_INT);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                $array = [];

                foreach ($data as $item) {
                    $user = $this->_generateUser($item);
                    $array[] = $user;
                }

                $sqlTotal = $this->pdo->query("SELECT COUNT(*) as total FROM users");
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
    
    public function findBy($key, $value)
    {
        $sql = $this->pdo->prepare("SELECT * FROM users WHERE $key = :$key");
        $sql->bindValue(":$key", $value);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);
        
            $user = $this->_generateUser($data);

            return $user;
        }else{
            return false;
        }
    }

    public function findAllBy($key, $value)
    {
        $sql = $this->pdo->prepare("SELECT * FROM users WHERE $key = :$key");
        $sql->bindValue(":$key", $value);
        $sql->execute();

        if($sql->rowCount() > 0){
         
            if ($sql->rowCount() > 0) {
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                $array = [];

                foreach ($data as $item) {
                    $user = $this->_generateUser($item);
                    $array[] = $user;
                }
                return $array;
            } else {
                return false;
            }

        }else{
            return false;
        }
    }
    
    public function search($termo)
    {
        $sql = "
        (SELECT 'clientes' AS origem, id, name, tel AS resultado,
        NULL AS email, NULL AS cargo, NULL AS total_hora, NULL AS quantidade
        FROM clientes 
        WHERE name LIKE :termo)

        UNION
        (SELECT 'produtos' AS origem, id, name, total_hora, quantidade AS resultado,
        NULL AS email, NULL AS cargo, NULL AS tel 
        FROM produtos 
        WHERE name LIKE :termo)
        
        UNION
        (SELECT 'users' AS origem, id, name AS resultado, email, cargo, 
        NULL AS tel, NULL AS total_hora, NULL AS quantidade
        FROM users 
        WHERE name LIKE :termo)
        ORDER BY origem, resultado;
        ";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":termo", "%$termo%", PDO::PARAM_STR);
        $stmt->execute();
        $data =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $data;
    }

    public function delete($id)
    {
        $sql = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

    }

    private function _generateUser($data)
    {
        $User = new User;
        $User->setId($data["id"]);
        $User->setName($data["name"]);
        $User->setEmail($data["email"]);
        $User->setCargo($data["cargo"]);
        $User->setPassword($data["password"]);
        $User->setToken($data["token"]);

        return $User;
    }
}
