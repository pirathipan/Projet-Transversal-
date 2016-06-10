<?php

class Core {

    public static function RegisterAutoload(){

        spl_autoload_register(function($class_name){
          if($class_name == 'Routes'){
              require($class_name . '.php');
          }
          else if(substr($class_name, -10) == "Controller"){
             require('../controllers/' . $class_name . '.php');
          }
          else if(substr($class_name, -5) == "Model"){
              require('../models/' . $class_name . '.php');
          }else{
              require('../class/' . $class_name . '.php');
          }
        });

    }

    public static function Render($controller, $view, $params)
    {
      $loader = new Twig_Loader_Filesystem('../views/' . $controller);
      $twig = new Twig_Environment($loader);
      echo $twig->render($view . '.twig', $params);
    }

    public static function PasswordHash($password){

        $secret = 'QDEE3EbzTYW7YeUa4IOlfC2WGQ6jktepoCmqUPdt';
        $HashedPassword = md5($secret . $password);
        return $HashedPassword;

    }

    public static function Route($controller, $function){

      $ControllerName = $controller . 'Controller';
      $Controller = new $ControllerName;
      $Action = $function . 'Action';
      $Controller->$Action();

    }

    public static function Response($content, $httpCode){
      header('Content-Type: application/json');
      http_response_code($httpCode);
      echo json_encode($content);

    }

}
