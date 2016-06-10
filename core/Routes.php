<?php

class Routes {

  public function GetController($controller, $function)
  {

    if($controller == NULL){

        $controller = 'Default';

    }
    if($function == NULL){

        $function = 'Index';

    }
    if($controller == 'messages' && is_numeric($function)){

      $Controller = new MessagesController();
      $Controller->conversationAction($function);

    } else {
      Core::Route($controller, $function);
    }
    

  }

}