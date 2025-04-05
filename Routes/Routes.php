<?php
namespace Routes;

class Routes{

    public static function getRoutes(){

        return  [
            '/' => 'HomeController@index',
            '/home' => 'HomeController@index',
        
            '/produtos' => 'ProdutoController@index',
            '/produtos/delete/{id}' => 'ProdutoController@delete',
            '/produtos/edit/{id}' => 'ProdutoController@edit',
            '/produtos/edit' => 'ProdutoController@editAction',
            '/addProdutos' => 'ProdutoController@cadastro',

            '/funcionarios' => 'FuncionarioController@index',
            '/funcionarios/delete/{id}' => 'FuncionarioController@delete',
            '/addFuncionarios' => 'FuncionarioController@cadastro',

            '/clientes' => 'ClienteController@index',
            '/cliente/edit/{id}' => 'ClienteController@edit',
            '/cliente/edit' => 'ClienteController@editAction',
            '/cliente/delete/{id}' => 'ClienteController@delete',
            '/addClientes' => 'ClienteController@cadastro',

            '/compras/{id}' => 'CompraController@getCompra',

            '/search' => 'UserController@search',

            '/addCompras' => 'CompraController@cadastro',
            '/entregue/{id}' => 'CompraController@entregue',

            '/relatorio' => 'CompraController@relatorio',

            '/financeiro' => 'CompraController@financeiro',

            '/listar' => 'UserController@listar',
            '/delete/{id}' => 'UserController@delete',

            '/compra/saveWeeklyGoals' => 'CompraController@saveWeeklyGoals',

            '/login' => 'UserController@login',
            '/cadastro' => 'UserController@cadastro',
            '/logout' => 'UserController@logout',

        ];
    }

}

?>