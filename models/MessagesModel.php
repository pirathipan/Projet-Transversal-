<?php
require_once '../class/config.php';
class MessagesModel {

    public function AddMessage($content,$date, $author_id, $conv_id){
        global $pdo;
        $database = $pdo->prepare("INSERT INTO `messages` (`content`, `author_id`,`date`, `conv_id`) VALUES (:content, :author_id, :date, :conv_id)");
        $database->bindParam("content", $content);
        $database->bindParam("author_id", $author_id);
        $database->bindParam("date", $date);
        $database->bindParam("conv_id", $conv_id);
        $database->execute();
    }

    public function CreateConversation($author_id, $user_id){
        global $pdo;
        $database = $pdo->prepare("INSERT INTO `conversations` (`author_id`, `user_id`) VALUES (:author_id, :user_id)");
        $database->bindParam("author_id", $author_id);
        $database->bindParam("user_id", $user_id);
        $database->execute();
        return $pdo->lastInsertId();
    }

    public function GetUserConversations($id){
        global $pdo;
        $database = $pdo->query("SELECT * FROM `conversations` WHERE `author_id` = $id OR `user_id` = $id ");
        return $database;
    }

    public function GetUserMessages($id){
        global $pdo;
        $database = $pdo->query("SELECT * FROM `messages` WHERE `conv_id` = $id ORDER BY `id` DESC");
        return $database;
    }

    public function DeleteUser($id){
        global $pdo;
        $database = $pdo->prepare("DELETE FROM users
                          WHERE `id` = :id");
        $database->bindParam("id",$id);
        $database->execute();
    }

    public function DeleteConversations($id){
        global $pdo;
        $pdo->query("DELETE FROM `conversations` WHERE `id` = $id");
        $pdo->query("DELETE FROM `messages` WHERE `conv_id` = $id");
    }

    public function GetConversationsPermissions($id){
        global $pdo;
        $database = $pdo->query("SELECT `author_id`, `user_id` FROM `conversations` WHERE `id` = $id");
        return $database->fetch(PDO::FETCH_OBJ);

    }

}
