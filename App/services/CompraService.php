<?php

namespace App\services;

use App\models\Compra;
use App\repositories\CompraRepository;
use Exception;

class CompraService{

    private $CompraRepository;

    public function __construct()
    {
        $this->CompraRepository = new CompraRepository;
    }

    public function create($vendedor, $id_produto, $id_cliente, $tempo, $total, $pagamento){
        try{
            $compra = new Compra;
            $compra->setVendedor($vendedor);
            $compra->setIdProduto($id_produto);
            $compra->setIdCliente($id_cliente);
            $compra->setHoraCompra($tempo);
            $compra->setTotal($total);
            $compra->setPagamento($pagamento);
        
            $this->CompraRepository->create($compra);
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function update(Compra $compra){
        try{
            $this->CompraRepository->update($compra);
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function findAll(){
        try{
            return $this->CompraRepository->findAll();
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function findAllBy($key, $value){
        try{
            return $this->CompraRepository->findAllBy($key, $value);
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }
    
    public function findAllPagination($page){
        try{
            return $this->CompraRepository->findAllPagination($page);
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function findBy($key, $value){
        try{
            return $this->CompraRepository->findBy($key, $value);
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function delete($id){
        try{
            $this->CompraRepository->delete($id);
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function total($init, $final){
        try{
            return $this->CompraRepository->total($init, $final);
        } catch(Exception $err){
            echo "Algo deu Errado: $err";
        }
    }

    public function relatorios($key, $value, $init, $final){
        $data = $this->CompraRepository->relatorios($key, $value, $init, $final);
        return $data;
    }

    public function getWeeklyData($year, $week) {
        return $this->CompraRepository->getWeeklyData($year, $week);
    }
    
    public function getMonthlyData($year) {
        return $this->CompraRepository->getMonthlyData($year);
    }
    
    public function saveWeeklyGoals($year, $week, $clientGoal, $revenueGoal) {
        return $this->CompraRepository->saveWeeklyGoals($year, $week, $clientGoal, $revenueGoal);
    }
    
    public function getWeeklyGoals($year, $week) {
        return $this->CompraRepository->getWeeklyGoals($year, $week);
    }
    

}
