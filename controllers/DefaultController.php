<?php

class DefaultController{

  public function IndexAction()
  {

    $array = [3422, 324, 6654, 43, 4355, 435435];
    Core::Render('Default', 'home', [
        'array' => $array,
        'title' => 'Todogether'
    ]);

  }

}
