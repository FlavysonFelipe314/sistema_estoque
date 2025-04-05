<?php

namespace App\interfaces;

use App\models\Cliente;

interface ClienteInterface {
    public function create(Cliente $cliente);
    public function update(Cliente $cliente);
    public function findAll();
    public function findAllPagination($page);
    public function delete($id);
}
