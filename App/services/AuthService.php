<?php 

namespace App\services;

use App\models\User;
use App\repositories\UserRepository;

class AuthService{

    public function checkToken()
    {
        if(!empty($_SESSION["token"])){
            $token = $_SESSION["token"];
            $UserRepository = new UserRepository;
            $user = $UserRepository->findBy('token', $token);

            if($user){
                return $user;
                exit;
            }
        }

        header("Location: ".BASE."/login");
    }

    public function registerUser($name, $password, $email, $cargo)
    {
        $UserRepository = new UserRepository;
        $token = md5(time().rand(0, 9999));
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $User = new User;
        $User->setName($name);
        $User->setPassword($hash);
        $User->setEmail($email);
        $User->setCargo($cargo);
        $User->setToken($token);

        $UserRepository->create($User);

        $_SESSION["token"] = $token;
    }

    public function validateLogin($email, $password)
    {
        $UserRepository = new UserRepository;
        $user = $UserRepository->findBy("email", $email);
        
        if(!empty($user)){
            if(password_verify($password, $user->getPassword())){

                $token = md5(time().rand(0,9999));

                $_SESSION["token"] = $token;
                $_SESSION["name"] = $user->getName();
                $_SESSION["cargo"] = $user->getCargo();
                $user->setToken($token);

                $UserRepository->update($user);
                
                return true;
                exit;
            }
        }
        
        return false;
    }


    public function logout()
    {
        session_unset();
        unset($_SESSION["token"]);
        unset($_SESSION["name"]);
        unset($_SESSION["cargo"]);
        session_destroy();
        header("Location: ".BASE);
    }
}

?>
