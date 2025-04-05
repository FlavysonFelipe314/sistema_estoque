<?php

namespace App\controllers;

use App\core\Controller;
use App\services\AuthService;
use App\services\UserService;
use Exception;

class UserController extends Controller{

    private $userInfo;
    private $UserService;

    public function __construct()
    {
        $this->UserService = new UserService;
    }

    public function login(){

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            $AuthService = new AuthService;
            
            try{
                
                if($AuthService->validateLogin($email, $password)){
                    header("Location: ".BASE);
                }

            }catch(Exception $err){
                echo "Algo deu errado: ". $err;
            }

        }

        $this->loadView("login");
    }

    public function cadastro(){

        $AuthService = new AuthService;
        $this->userInfo = $AuthService->checkToken();

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $cargo = filter_input(INPUT_POST, "cargo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  
            $AuthService = new AuthService;
            
            try{
                $AuthService->registerUser($name, $password, $email, $cargo);
            }catch(Exception $err){
                echo "Algo deu errado: ". $err;
            }
            
        }

        $data = [
            'user' => $this->userInfo,
        ];

        $this->loadTemplate("cadastro", $data);
    }

    public function listar(){

        $AuthService = new AuthService;
        $this->userInfo = $AuthService->checkToken();

        $page = !empty(filter_input(INPUT_GET, "page")) ? filter_input(INPUT_GET, "page") : 1;

        $usuarios = $this->UserService->findAllPagination($page);

        if(!empty($usuarios)){
            $totPages = (int) $usuarios["pages"];
            unset($usuarios["pages"]);
        } else{
            $usuarios = "";
            $totPages = "";
        }

        $data = [
            'user' => $this->userInfo,
            'usuarios' => $usuarios,
            'pages' => $totPages
        ];
        
        $this->loadTemplate("usuarios", $data);
    }

    public function search(){

        $AuthService = new AuthService;
        $this->userInfo = $AuthService->checkToken();

        if($_SERVER["REQUEST_METHOD"] === "GET"){
            $search = filter_input(INPUT_GET, "search", FILTER_SANITIZE_FULL_SPECIAL_CHARS);    
            try{
                $results = $this->UserService->search($search);
            }catch(Exception $err){
                echo "Algo deu errado: ". $err;
                exit;
            }
            
        }
        
        $data = [
            'user' => $this->userInfo,
            'results' => $results,
        ];

        $this->loadTemplate("search", $data);
        
    }

    public function delete($id){

        $AuthService = new AuthService;
        $this->userInfo = $AuthService->checkToken();

        $this->UserService->delete($id);
        header("Location: ".BASE.'/listar');

    }


    public function logout(){

        $AuthService = new AuthService;
        
        try{
            $AuthService->logout();
        }catch(Exception $err){
            echo "Algo deu errado: ". $err;
        }
            
    }
}

?>