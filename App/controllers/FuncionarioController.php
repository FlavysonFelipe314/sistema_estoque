<?php

namespace App\controllers;

use App\core\Controller;
use App\services\AuthService;
use App\services\FuncionarioService;
use Exception;

class FuncionarioController extends Controller{

    private $userInfo;
    private $FuncionarioService;

    public function __construct()
    {
        $AuthService = new AuthService;
        $this->userInfo = $AuthService->checkToken();

        $this->FuncionarioService = new FuncionarioService;
        
    }

    public function index(){

        $page = !empty(filter_input(INPUT_GET, "page")) ? filter_input(INPUT_GET, "page") : 1;

        $funcionarios = $this->FuncionarioService->findAllPagination($page);

        if(!empty($funcionarios)){
            $totPages = (int) $funcionarios["pages"];
            unset($funcionarios["pages"]);
        } else{
            $funcionarios = "";
            $totPages = "";
        }

        $data = [
            'user' => $this->userInfo,
            'funcionarios' => $funcionarios,
            'pages' => $totPages
        ];

        define("NAME_USER", $this->userInfo->getName());
        define("CARGO_USER", $this->userInfo->getCargo());
        
        $this->loadTemplate("funcionarios", $data);
    }

    public function cadastro(){
        
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $cpf = filter_input(INPUT_POST, "cpf");

            try{
                $this->FuncionarioService->create($name, $cpf);
                header("Location: ".BASE."/funcionarios");

            } catch(Exception $err){
                echo "Algo deu Errado: $err";
            }

        }
        
    }

    public function delete($id){
        $this->FuncionarioService->delete($id);
        header("Location: ".BASE.'/funcionarios');

    }


}

?>