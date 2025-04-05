<?php

namespace Config\Database;

use PDO;
use PDOException;

trait Connection{
    public function getConnection(){
        try{ 
            $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
            return $conn;
        }
        catch(PDOException $err){
            return $err;
        }
    }
}
?>