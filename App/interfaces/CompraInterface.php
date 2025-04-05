<?php

namespace App\interfaces;

use App\models\Compra;

interface CompraInterface {
    public function create(Compra $compra);
    public function update(Compra $compra);
    public function findAll();
    public function findAllPagination($page);
    public function findBy($key, $value);
    public function delete($id);
}
