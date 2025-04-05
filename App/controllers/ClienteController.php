<?php

namespace App\controllers;

use App\core\Controller;
use App\services\AuthService;
use App\services\ClienteService;
use App\services\CompraService;
use Exception;

class ClienteController extends Controller{

    private $userInfo;
    private $ClienteService;
    private $CompraService;

    public function __construct()
    {
        $AuthService = new AuthService;
        $this->userInfo = $AuthService->checkToken();

        $this->ClienteService = new ClienteService;
        $this->CompraService = new CompraService;
        
    }

    public function index(){

        $page = !empty(filter_input(INPUT_GET, "page")) ? filter_input(INPUT_GET, "page") : 1;

        $clientes = $this->ClienteService->findAllPagination($page);
        
        if(!empty($clientes)){
            $totPages = (int) $clientes["pages"];
            unset($clientes["pages"]);
        } else{
            $clientes = "";
            $totPages = "";
        }    

        foreach ($clientes as $cliente) {
            $compras = $this->CompraService->findAllBy("id_cliente", $cliente->getId());
        
            // Se $compras for false, substituímos por um array vazio
            if (!is_array($compras)) {
                $compras = [];
            }
        
            $cliente->visitas = count($compras);
        }
        

        $data = [
            'user' => $this->userInfo,
            'clientes' => $clientes,
            'pages' => $totPages
        ];
        
        $this->loadTemplate("clientes", $data);
    }

    public function cadastro(){
        
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $tel = filter_input(INPUT_POST, "tel");

            try{
                $this->ClienteService->create($name, $tel);
                header("Location: ".BASE."/clientes");

            } catch(Exception $err){
                echo "Algo deu Errado: $err";
            }

        }
    }


    public function edit($id){

        $cliente = $this->ClienteService->findBy("id", $id);

        $data = [
            'user' => $this->userInfo,
            'cliente' => $cliente,
        ];
        
        $this->loadTemplate("clienteEdit", $data);
    }

    public function editAction(){
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $tel = filter_input(INPUT_POST, "tel");
            $id = filter_input(INPUT_POST, "id");

            try{
                $this->ClienteService->update($id, $name, $tel);
                header("Location: ".BASE."/clientes");

            } catch(Exception $err){
                echo "Algo deu Errado: $err";
            }

        }
    }



    public function delete($id){

        $this->ClienteService->delete($id);
        header("Location: ".BASE.'/clientes');

    }


}

?>