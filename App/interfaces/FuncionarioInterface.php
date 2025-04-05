<?php

namespace App\interfaces;

use App\models\Funcionario;

interface FuncionarioInterface {
    public function create(Funcionario $funcionario);
    public function update(Funcionario $funcionario);
    public function findAll();
    public function findAllPagination($page);
    public function delete($id);
}
