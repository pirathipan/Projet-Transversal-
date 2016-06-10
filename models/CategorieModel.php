<?php
require_once 'config.php';
class CategorieModel{

    public function CreateCategorie($name){
        global $pdo;
        $database = $pdo->prepare("INSERT INTO `categories`(`name`)
                          VALUES (:name)");
        $database->bindParam("name",$name);
        $database->execute();
    }

    public function GetCategorie($id){
        global $pdo;
        $database = $pdo->prepare("SELECT * FROM `categories`
                          WHERE `id` = :id");
        $database->bindParam("id",$id);
        $database->execute();
        return $database->fetch();
    }

    public function UpdateCategorie($id, $name){
        global $pdo;
        $database = $pdo->prepare("UPDATE `categories` SET `name`= :name
                                   WHERE `id` = :id");
        $database->bindParam("name",$name);
        $database->bindParam("id", $id);
        $database->execute();
    }

    public function DeleteCategorie($id){
        global $pdo;
        $database = $pdo->prepare("DELETE FROM `categories`
                          WHERE `id` = :id");
        $database->bindParam("id",$id);
        $database->execute();
    }

}
