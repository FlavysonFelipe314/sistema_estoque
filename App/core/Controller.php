<?php

namespace App\core;

use \DantSu\PHPImageEditor\Image;

class Controller
{
    public function loadView($viewName, $viewData = [])
    {
        extract($viewData);
        require_once __DIR__ . "/../../views/".$viewName.".php";
    } 
                                                                                           
    public function loadTemplate($viewName, $viewData = [])
    {
        require_once __DIR__ . "/../../views/template.php";
    }

    public function loadViewTemplate($viewName, $viewData = [])
    {
        extract($viewData);
        require_once __DIR__ .  "/../../views/".$viewName.".php";
    }

    public function loadFlash($type, $message)
    {
        $_SESSION["flash"] = $type.": $message";
    } 

    public function getFlashMessage()
    {
        if(!empty($_SESSION["flash"]))
        {
            
            echo $_SESSION["flash"];
            $_SESSION["flash"] = "";
        }
    }

    public function saveImage($width, $height, $urlSend, $path)
    {
        $image = Image::fromPath($path)
        ->crop($width, $height, Image::ALIGN_CENTER, Image::ALIGN_MIDDLE)
        ->resize($width,$height)
        ->savePNG($urlSend);
    }

}
?>