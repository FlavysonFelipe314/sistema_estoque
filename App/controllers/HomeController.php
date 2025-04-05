<?php

namespace App\controllers;

use App\core\Controller;
use App\services\AuthService;
use App\services\ClienteService;
use App\services\CompraService;
use App\services\ProdutoService;

class HomeController extends Controller{

    private $userInfo;
    private $ProdutoService;
    private $ClienteService;
    private $CompraService;

    public function __construct()
    {
        $AuthService = new AuthService;
        $this->userInfo = $AuthService->checkToken();

        $this->ProdutoService = new ProdutoService;
        $this->ClienteService = new ClienteService;
        $this->CompraService = new CompraService;

    }

    public function index(){

        $produtos = $this->ProdutoService->findAll();
        $countProdutos = (!empty($produtos)) ? count($produtos) : 0;

        $clientes = $this->ClienteService->findAll();
        $countClientes = (!empty($clientes)) ? count($clientes) : 0;

        $compras = $this->CompraService->findAllBy("situacao", 0);
        $entradas = $this->CompraService->findAllBy("situacao", 1);

        $init = date('Y-m-d');
        $final = date('Y-m-d');

        $total = $this->CompraService->total($init, $final);
        $total = (!empty($total['total_soma'])) ? $total['total_soma'] : 0;

        $data = [
            'user' => $this->userInfo,
            'produtos' => $produtos,
            'clientes' => $clientes,
            'countProdutos' => $countProdutos,
            'countClientes' => $countClientes,
            'compras' => $compras,
            'entradas' => $entradas,
            'total' => $total
        ];

        define("NAME_USER", $this->userInfo->getName());
        define("CARGO_USER", $this->userInfo->getCargo());
        
        $this->loadTemplate("home", $data);
    }
}
?>