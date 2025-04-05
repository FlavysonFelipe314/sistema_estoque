<?php

namespace App\interfaces;

use App\models\Produto;

interface ProdutoInterface {
    public function create(Produto $produto);
    public function update(Produto $produto);
    public function findAll();
    public function findAllPagination($page);
    public function findBy($query, $value);
    public function findAllBy($query, $value);
    public function delete($id);
}
