<?php

namespace App\models;

class Compra {
    private $id;
    private $vendedor;
    private $id_produto;
    private $id_cliente;
    private $hora_compra;
    private $total;
    private $pagamento;
    private $situacao;
    private $created_at;
    private $updated_at;    
    private $cliente_name;
    private $produto_name;
    private $cliente_tel;

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setVendedor($vendedor)
    {
        $this->vendedor = $vendedor;
    }

    public function setIdProduto($id_produto)
    {
        $this->id_produto = $id_produto;
    }

    public function setIdCliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }

    public function setHoraCompra($hora_compra)
    {
        $this->hora_compra = $hora_compra;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function setPagamento($pagamento)
    {
        $this->pagamento = $pagamento;
    }

    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function setClienteName($cliente_name)
    {
        $this->cliente_name = $cliente_name;
    }

    public function setClienteTel($cliente_tel)
    {
        $this->cliente_tel = $cliente_tel;
    }

    public function setProdutoName($produto_name)
    {
        $this->produto_name = $produto_name;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getVendedor()
    {
        return $this->vendedor;
    }

    public function getIdProduto()
    {
        return $this->id_produto;
    }

    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function getHoraCompra()
    {
        return $this->hora_compra;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getPagamento()
    {
        return $this->pagamento;
    }

    public function getSituacao()
    {
        return $this->situacao;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function getClienteName()
    {
        return $this->cliente_name;
    }

    public function getClienteTel()
    {
        return $this->cliente_tel;
    }

    public function getProdutoName()
    {
        return $this->produto_name;
    }
}
