<?php 

namespace App\core;

use Config\Database\Connection;

class Repository{

    protected $pdo;

    use Connection;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

}

?>