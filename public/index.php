<?php
require_once '../vendor/autoload.php';
require_once '../core/Core.php';
session_start();
Core::RegisterAutoload();
$Routes = new Routes();
$request_url = $_SERVER['REQUEST_URI'];
$url_composants = explode("/",$request_url,4);
global $id;
if(isset($url_composants[3])){
    $id = $url_composants[3];
} else {
    $id = NULL;
}
if(!isset($url_composants[1]) && !isset($url_composants[2]))
{
  $Routes->GetController(NULL, NULL);
} elseif(isset($url_composants[1]) && !isset($url_composants[2]))
{
  $Routes->GetController($url_composants[1], NULL);
} elseif (isset($url_composants[1]) && isset($url_composants[2]))
{
  $Routes->GetController($url_composants[1], $url_composants[2]);
} elseif (!isset($url_composants[1]) && isset($url_composants[2]))
{
  $Routes->GetController(NULL, $url_composants[2]);
}