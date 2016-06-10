<?php
require_once '../class/config.php';
class AnnonceModel{

    public function CreateAnnonce($title, $description, $place, $date, $categorie_id, $user_related_id, $picture){
        global $pdo;
        $database = $pdo->prepare("INSERT INTO `annonces`(`title`, `description`, `place`, `date`,`categorie_id`, `user_related_id`, `picture`)
                          VALUES (:title, :description, :place, :date, :categorie_id, :user_related_id, :picture)");
        $database->bindParam("title",$title);
        $database->bindParam("description",$description);
        $database->bindParam("place",$place);
        $database->bindParam("date",$date);
        $database->bindParam("categorie_id",$categorie_id);
        $database->bindParam("user_related_id",$user_related_id);
        $database->bindParam("picture",$picture);
        $database->execute();
    }

    public function GetAnnonce($id){
        global $pdo;
        $database = $pdo->prepare("SELECT * FROM `annonces`
                          WHERE `id` = :id");
        $database->bindParam("id",$id);
        $database->execute();
        return $database->fetch();
    }

    public function GetAllAnnonces(){
        global $pdo;
        $database = $pdo->query("SELECT * FROM `annonces` ORDER BY id DESC");
        return $database;
    }

    public function GetAllAnnoncesByCategorie(){
        global $pdo;
        $database = $pdo->query("SELECT * FROM `annonces` ORDER BY categorie_id DESC");
        return $database;
    }

    public function GetUserAnnonces($id){
        global $pdo;
        $database = $pdo->query("SELECT * FROM `annonces` WHERE `user_related_id` = $id ORDER BY date DESC");
        return $database;
    }

    public function UpdateAnnonce($id, $title, $description, $place, $date, $categorie_id, $picture){
        global $pdo;
        $database = $pdo->prepare("UPDATE `annonces` SET `title`= :title, `description`= :description, `place`= :place,
                                  `date`= :date, `categorie_id`= :categorie_id, `picture`= :picture
                                   WHERE `id` = :id");
        $database->bindParam("title",$title);
        $database->bindParam("description",$description);
        $database->bindParam("place",$place);
        $database->bindParam("date",$date);
        $database->bindParam("categorie_id",$categorie_id);
        $database->bindParam("picture",$picture);
        $database->bindParam("id", $id);
        $database->execute();
    }

    public function DeleteAnnonce($id){
        global $pdo;
        $database = $pdo->prepare("DELETE FROM `annonces`
                          WHERE `id` = :id");
        $database->bindParam("id",$id);
        $database->execute();
    }

}
