<?php

namespace Routes;
use Routes\Routes;

class Router{

    private static $routes;

    public function __construct()
    {
        $Routes = new Routes;
        self::$routes = $Routes::getRoutes();
    }

    public static function getRoutes($url){
        
        foreach (self::$routes as $pt => $newUrl){
            
            $newUrl = explode("@", $newUrl);
            $newUrl[0] = str_replace("Controller", "", $newUrl[0]);
            $newUrl = "/".$newUrl[0]."/".$newUrl[1];

            if(str_replace("/", "", $url) == str_replace("/", "", $pt)){
                $url = $newUrl;
                break;
            }

            $pattern = preg_replace("(\{[a-z0-9]{1,}\})", "([a-z0-9]{1,})", $pt);
            // Faz o match da url
            if(preg_match("#^($pattern)*$#i", $url, $matches) === 1){
                array_shift($matches);
                array_shift($matches); 

                // monta a nova URl
                foreach($matches as $arg){
                    $newUrl .= "/".$arg;
                }

                $url = $newUrl;

                break;
            }
        }

        return $url;
    }
}
?>