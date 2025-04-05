<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
use App\core\Core;

require_once "./vendor/autoload.php";
require_once "./Config/Config.php";

$Core = new Core();
$Core->run();

?>