<?php
require_once '../class/config.php';
class UserModel{

    public function GetUserConnect($username, $password){
        global $pdo;
        $database = $pdo->prepare("SELECT * FROM users
                          WHERE `username` = :username AND `password` = :password");
        $database->bindParam("username",$username);
        $database->bindParam("password",$password);
        $database->execute();
        return $database;
    }

    public function CreateUser($username, $password, $firstname, $lastname, $mail, $notation, $domain, $pictures, $adress){
        global $pdo;
        $database = $pdo->prepare("INSERT INTO `users`(`username`, `password`, `firstname`,
                          `lastname`, `mail`, `notation`, `domain`, `pictures`, `adress`)
                          VALUES (:username,:password,:firstname,:lastname,:mail,
                          :notation,:domain,:pictures,:adress)");
        $database->bindParam("username",$username);
        $database->bindParam("password",$password);
        $database->bindParam("firstname",$firstname);
        $database->bindParam("lastname",$lastname);
        $database->bindParam("mail",$mail);
        $database->bindParam("notation",$notation);
        $database->bindParam("domain",$domain);
        $database->bindParam("pictures",$pictures);
        $database->bindParam("adress",$adress);
        $database->execute();
    }

    public function GetUser($id){
        global $pdo;
        $database = $pdo->prepare("SELECT * FROM users
                          WHERE `id` = :id");
        $database->bindParam("id",$id);
        $database->execute();
        return $database->fetch();
    }

    public function UpdateUser($id, $username, $password, $firstname, $lastname, $mail, $domain, $adress ){
        global $pdo;
        $database = $pdo->prepare("UPDATE `users` SET `username`= :username,`password`= :password,`firstname`= :firstname,`lastname`= :lastname,
                                  `mail`= :mail,`domain`= :domain, `adress`= :adress
                                   WHERE `id` = :id");
        $database->bindParam("username",$username);
        $database->bindParam("password",$password);
        $database->bindParam("firstname",$firstname);
        $database->bindParam("lastname",$lastname);
        $database->bindParam("mail",$mail);
        $database->bindParam("domain",$domain);
        $database->bindParam("adress",$adress);
        $database->bindParam("id", $id);
        $database->execute();
    }

    public function DeleteUser($id){
        global $pdo;
        $database = $pdo->prepare("DELETE FROM users
                          WHERE `id` = :id");
        $database->bindParam("id",$id);
        $database->execute();
    }

    public function GetAllUsers(){
        global $pdo;
        $database = $pdo->query("SELECT * FROM `users`");
        return $database;
    }

}
