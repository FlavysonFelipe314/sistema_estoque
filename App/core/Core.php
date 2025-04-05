<?php
namespace App\core;

use Routes\Router;

class Core
{
    public function run()
    {
        $url = "/";

        if(isset($_GET["url"])){
            $url .= $_GET["url"];
        }

        $Router = new Router;
        $url = $Router::getRoutes($url);

        if(!empty($url) && $url != "/"){

            $params = [];
            $url = explode("/", $url);
            array_shift($url);
            
            $currentController = ucfirst($url[0])."Controller";
            array_shift($url);

            if(isset($url[0]) && !empty($url[0])){
                $currentAction = $url[0];
                array_shift($url);
            }
            else{
                $currentAction = "index";
            }

            if(count($url) > 0){
                $params = $url;
            }

            
        }
        else{
            $currentController = "HomeController";
            $currentAction = "index";
        }

        $currentController = "\\App\\controllers\\".$currentController;
        
        if(!class_exists($currentController)){

            $Controller = new Controller;

            $Controller->loadView("pages/404");
            exit;
        }

        $controller = new $currentController();

        if(!method_exists($controller, $currentAction)){
            die("Action not Found: ".$currentAction);
        }

        call_user_func_array(array($controller, $currentAction), $params ?? []);
    }
}
?>