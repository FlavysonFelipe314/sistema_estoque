<?php

namespace App\repositories;

use App\core\Repository;
use App\interfaces\CompraInterface;
use App\models\Compra;
use PDO;
use PDOException;

class CompraRepository extends Repository implements CompraInterface {

    public function create(Compra $compra)
    {
        try {
            $sql = $this->pdo->prepare("INSERT INTO compras (vendedor, id_produto, id_cliente, tempo, total, pagamento) VALUES (:vendedor, :id_produto, :id_cliente, :tempo, :total, :pagamento)");
            $sql->bindValue(":vendedor", $compra->getVendedor());
            $sql->bindValue(":id_produto", $compra->getIdProduto());
            $sql->bindValue(":id_cliente", $compra->getIdCliente());
            $sql->bindValue(":tempo", $compra->getHoraCompra());
            $sql->bindValue(":total", $compra->getTotal());
            $sql->bindValue(":pagamento", $compra->getPagamento());
            $sql->execute();
        } catch (PDOException $err) {
            echo "Algo deu Errado: $err";
        }
    }

    public function update(Compra $compra)
    {
        try {
            $sql = $this->pdo->prepare("UPDATE compras SET id_produto = :id_produto, id_cliente = :id_cliente, tempo = :tempo, total = :total, pagamento = :pagamento, situacao = :situacao WHERE id = :id");
            $sql->bindValue(":id_produto", $compra->getIdProduto());
            $sql->bindValue(":id_cliente", $compra->getIdCliente());
            $sql->bindValue(":tempo", $compra->getHoraCompra());
            $sql->bindValue(":total", $compra->getTotal());
            $sql->bindValue(":pagamento", $compra->getPagamento());
            $sql->bindValue(":situacao", $compra->getSituacao());
            $sql->bindValue(":id", $compra->getId());
            $sql->execute();
        } catch (PDOException $err) {
            echo "Algo deu Errado: $err";
        }
    }

    public function findAll()
    {
        try {
            $sql = $this->pdo->prepare("SELECT compras.*, 
            clientes.name AS nome_cliente, 
            clientes.tel AS tel_cliente, 
            produtos.name AS nome_produto
            FROM compras
            JOIN clientes ON compras.id_cliente = clientes.id
            JOIN produtos ON compras.id_produto = produtos.id
            ORDER BY compras.created_at DESC");
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                $array = [];

                foreach ($data as $item) {
                    $compra = $this->_generateCompra($item);
                    $array[] = $compra;
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

            $sql = $this->pdo->prepare("SELECT * FROM compras ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
            $sql->bindValue(":limit", $limit, PDO::PARAM_INT);
            $sql->bindValue(":offset", $offset, PDO::PARAM_INT);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                $array = [];

                foreach ($data as $item) {
                    $compra = $this->_generateCompra($item);
                    $array[] = $compra;
                }

                $sqlTotal = $this->pdo->query("SELECT COUNT(*) as total FROM compras");
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
    
    public function findBy($key, $value){
        $sql = $this->pdo->prepare("SELECT compras.*, 
            clientes.name AS nome_cliente, 
            clientes.tel AS tel_cliente, 
            produtos.name AS nome_produto
            FROM compras
            JOIN clientes ON compras.id_cliente = clientes.id
            JOIN produtos ON compras.id_produto = produtos.id
            WHERE compras.$key = :$key
            ORDER BY compras.created_at DESC");
        $sql->bindValue(":$key", $value);
        $sql->execute();
    
        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);
        
            $user = $this->_generateCompra($data);
    
            return $user;
        }else{
            return false;
        }
    }    

    public function findAllBy($key, $value){
        $sql = $this->pdo->prepare("SELECT compras.*, 
            clientes.name AS nome_cliente, 
            clientes.tel AS tel_cliente, 
            produtos.name AS nome_produto
            FROM compras
            JOIN clientes ON compras.id_cliente = clientes.id
            JOIN produtos ON compras.id_produto = produtos.id
            WHERE compras.$key = :$key
            ORDER BY compras.created_at DESC");
        $sql->bindValue(":$key", $value);
        $sql->execute();
    
        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            $array = [];

            foreach ($data as $item) {
                $compra = $this->_generateCompra($item);
                $array[] = $compra;
            }
            return $array;
        } else {
            return false;
        }
    }    

    public function delete($id)
    {
        try {
            $sql = $this->pdo->prepare("DELETE FROM compras WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
        } catch (PDOException $err) {
            echo "Algo deu Errado: $err";
        }
    }

    public function total($init, $final){
        $sql = $this->pdo->prepare("SELECT SUM(total) as total_soma
        FROM compras WHERE situacao = :situacao AND created_at BETWEEN :init AND :final");
        $sql->bindValue(":situacao", 1);
        $sql->bindValue(":init", "$init 00:00:00");
        $sql->bindValue(":final", "$final 23:59:59");
        $sql->execute();

        $result = $sql->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


    public function relatorios($key, $value, $init, $final){
        try {
            if($value == "*"){
                $sql = $this->pdo->prepare("SELECT compras.*, 
                    clientes.name AS nome_cliente, 
                    clientes.tel AS tel_cliente, 
                    produtos.name AS nome_produto
                    FROM compras
                    JOIN clientes ON compras.id_cliente = clientes.id
                    JOIN produtos ON compras.id_produto = produtos.id
                    WHERE compras.created_at BETWEEN :init AND :final");
                $sql->bindValue(":init", "$init 00:00:00");
                $sql->bindValue(":final", "$final 23:59:59");
            }
            else{
                $sql = $this->pdo->prepare("SELECT compras.*, 
                    clientes.name AS nome_cliente, 
                    clientes.tel AS tel_cliente, 
                    produtos.name AS nome_produto
                    FROM compras
                    JOIN clientes ON compras.id_cliente = clientes.id
                    JOIN produtos ON compras.id_produto = produtos.id
                    WHERE compras.$key = :value AND compras.created_at BETWEEN :init AND :final");
                $sql->bindValue(":value", $value);
                $sql->bindValue(":init", "$init 00:00:00");
                $sql->bindValue(":final", "$final 23:59:59");
            }
    
            $sql->execute();
    
            if($sql->rowCount() > 0){
                $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                $array = [];
    
                foreach($data as $item){
                    $array[] = $this->_generateCompra($item);
                }
    
                return $array;
            }
        } catch (PDOException $err) {
            echo "Algo deu errado: $err";
        }
    }

    public function getWeeklyData($year, $week) {
        try {
            $startDate = new \DateTime();
            $startDate->setISODate($year, $week, 1); 
            $endDate = clone $startDate;
            $endDate->modify('+6 days'); 
            
            $start = $startDate->format('Y-m-d');
            $end = $endDate->format('Y-m-d');
            
            $sql = $this->pdo->prepare("SELECT 
                DATE(created_at) as date,
                COUNT(DISTINCT id_cliente) as client_count,
                SUM(total) as daily_total
                FROM compras 
                WHERE situacao = 1 AND created_at BETWEEN :start AND :end
                GROUP BY DATE(created_at)
                ORDER BY date ASC");
            $sql->bindValue(":start", "$start 00:00:00");
            $sql->bindValue(":end", "$end 23:59:59");
            $sql->execute();
            
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            echo "Algo deu Errado: $err";
            return [];
        }
    }
    
    public function getMonthlyData($year) {
        try {
            $sql = $this->pdo->prepare("SELECT 
                MONTH(created_at) as month,
                COUNT(DISTINCT id_cliente) as client_count,
                SUM(total) as monthly_total
                FROM compras 
                WHERE situacao = 1 AND YEAR(created_at) = :year
                GROUP BY MONTH(created_at)
                ORDER BY month ASC");
            $sql->bindValue(":year", $year);
            $sql->execute();
            
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            echo "Algo deu Errado: $err";
            return [];
        }
    }
    
    public function saveWeeklyGoals($year, $week, $clientGoal, $revenueGoal) {
        try {
            
            $checkSql = $this->pdo->prepare("SELECT id FROM weekly_goals WHERE year = :year AND week = :week");
            $checkSql->bindValue(":year", $year);
            $checkSql->bindValue(":week", $week);
            $checkSql->execute();
            
            if ($checkSql->rowCount() > 0) {
                
                $sql = $this->pdo->prepare("UPDATE weekly_goals SET client_goal = :client_goal, revenue_goal = :revenue_goal WHERE year = :year AND week = :week");
            } else {
                
                $sql = $this->pdo->prepare("INSERT INTO weekly_goals (year, week, client_goal, revenue_goal) VALUES (:year, :week, :client_goal, :revenue_goal)");
            }
            
            $sql->bindValue(":year", $year);
            $sql->bindValue(":week", $week);
            $sql->bindValue(":client_goal", $clientGoal);
            $sql->bindValue(":revenue_goal", $revenueGoal);
            $sql->execute();
            
            return true;
        } catch (PDOException $err) {
            echo "Algo deu Errado: $err";
            return false;
        }
    }
    
    public function getWeeklyGoals($year, $week) {
        try {
            $sql = $this->pdo->prepare("SELECT client_goal, revenue_goal FROM weekly_goals WHERE year = :year AND week = :week");
            $sql->bindValue(":year", $year);
            $sql->bindValue(":week", $week);
            $sql->execute();
            
            if ($sql->rowCount() > 0) {
                return $sql->fetch(PDO::FETCH_ASSOC);
            } else {
                return ['client_goal' => 0, 'revenue_goal' => 0];
            }
        } catch (PDOException $err) {
            echo "Algo deu Errado: $err";
            return ['client_goal' => 0, 'revenue_goal' => 0];
        }
    }
    
    

    private function _generateCompra($data)
    {
        $compra = new Compra();
        $compra->setId($data["id"]);
        $compra->setVendedor($data["vendedor"]);
        $compra->setIdProduto($data["id_produto"]);
        $compra->setIdCliente($data["id_cliente"]);
        $compra->setHoraCompra($data["tempo"]);
        $compra->setTotal($data["total"]);
        $compra->setPagamento($data["pagamento"]);
        $compra->setCreatedAt($data["created_at"]);
        $compra->setUpdatedAt($data["updated_at"]);
        $compra->setClienteName($data['nome_cliente']);
        $compra->setClienteTel($data['tel_cliente']);
        $compra->setProdutoName($data['nome_produto']);

        return $compra;
    }
}
