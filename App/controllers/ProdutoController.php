<?php

namespace App\controllers;

use App\core\Controller;
use App\services\AuthService;
use App\services\ProdutoService;
use Exception;

class ProdutoController extends Controller{

    private $userInfo;
    private $ProdutoService;

    public function __construct()
    {
        $AuthService = new AuthService;
        $this->userInfo = $AuthService->checkToken();
        
        $this->ProdutoService = new ProdutoService;
    }

    public function index(){

        $page = !empty(filter_input(INPUT_GET, "page")) ? filter_input(INPUT_GET, "page") : 1;

        $produtos = $this->ProdutoService->findAllPagination($page);

        if(!empty($produtos)){
            $totPages = (int) $produtos["pages"];
            unset($produtos["pages"]);
        } else{
            $produtos = "";
            $totPages = "";
        }

        $data = [
            'user' => $this->userInfo,
            'produtos' => $produtos,
            'pages' => $totPages
        ];

        define("NAME_USER", $this->userInfo->getName());
        define("CARGO_USER", $this->userInfo->getCargo());
        
        $this->loadTemplate("produtos", $data);
    }

    public function cadastro(){
        
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $quantidade = filter_input(INPUT_POST, "quantidade");
            $totalHora = filter_input(INPUT_POST, "total_hora");

            try{
                $this->ProdutoService->create($name, $quantidade, $totalHora);
                header("Location: ".BASE."/produtos");

            } catch(Exception $err){
                echo "Algo deu Errado: $err";
            }

        }
        
    }

    public function edit($id){

        $produto = $this->ProdutoService->findBy("id", $id);

        $data = [
            'user' => $this->userInfo,
            'produto' => $produto,
        ];
        
        $this->loadTemplate("produtoEdit", $data);
    }

    public function editAction(){
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $quantidade = filter_input(INPUT_POST, "quantidade");
            $totalHora = filter_input(INPUT_POST, "total_hora");
            $id = filter_input(INPUT_POST, "id");

            try{
                $this->ProdutoService->update($id, $name, $quantidade, $totalHora);
                header("Location: ".BASE."/produtos");

            } catch(Exception $err){
                echo "Algo deu Errado: $err";
            }

        }
    }

    public function delete($id){
        $this->ProdutoService->delete($id);
        header("Location: ".BASE.'/produtos');

    }

}

?>