<?php

class UserController{

    public function indexAction(){

        Core::Render('user', 'index', [
            'Connected' => self::isConnected()
        ]);

    }

    public function profileAction(){
        global $id;
        if(self::IsConnected() && !isset($id)){

            if(isset($_POST['username']) && isset($_POST['mail'])){

                if(strlen($_POST['password']) == 0){

                    $user = new UserModel();
                    $userinfos = $user->getUser($_SESSION['user_id']);
                    $password = $userinfos['password'];

                } else {

                    $password = Core::PasswordHash($_POST['password']);

                }

            }
            $user = new UserModel();
            $userinfos = $user->getUser($_SESSION['user_id']);
            $annonce = new AnnonceModel();
            $annonces = $annonce->GetUserAnnonces($_SESSION['user_id']);
            Core::render('User', 'profile', [
                'title' => 'Todogether',
                'user' => $userinfos,
                'annonces' => $annonces
            ]);

        } else if (isset($id)){

            $user = new UserModel();
            $userinfos = $user->getUser($_SESSION['user_id']);
            $annonce = new AnnonceModel();
            $annonces = $annonce->GetUserAnnonces($_SESSION['user_id']);
            Core::render('User', 'publicProfile', [
                'title' => 'Todogether',
                'user' => $userinfos,
                'annonces' => $annonces
            ]);

        } else {

            header('Location: /user');

        }

    }

    public function registerAction(){
        if(isset($_POST['username']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['adress'])
            && isset($_POST['password']) &&  isset($_POST['mail'])){

            $dataOk = true;

            if(strlen($_POST['username']) < 4){

                $error['username'] = 'Votre pseudo doit faire plus de 4 caractères';
                $dataOk = false;

            }

            if(strlen($_POST['firstname']) < 1){

                $error['firstname'] = 'Votre prénom doit faire plus de 1 caractère';
                $dataOk = false;

            }

            if(strlen($_POST['lastname']) < 1){

                $error['lastame'] = 'Votre nom doit faire plus de 1 caractère';
                $dataOk = false;

            }

            if(strlen($_POST['adress']) == 0){

                $error['adress'] = 'Veuillez rentrer votre addresse';
                $dataOk = false;

            }

            if(strlen($_POST['password']) < 5){

                $error['password'] = 'Votre mot de passe doit faire plus de 5 caractères';
                $dataOk = false;

            }

            if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {

                $error['mail'] = 'Votre mail n\'est pas valide';
                $dataOk = false;

            }

            if($dataOk){
                $password = Core::PasswordHash($_POST['password']);
                $user = new UserModel();
                $user->CreateUser(htmlentities($_POST['username']), $password, htmlentities($_POST['firstname']), htmlentities($_POST['lastname']), htmlentities($_POST['mail']), "",htmlentities($_POST['domain']), "",htmlentities($_POST['adress']));
                Core::Response(['success' => 'Enregistré !'], 200);
            } else {
               Core::Response($error, 400);
            }

        } else {

            Core::render('user', 'register', [
                'title' => 'Todogether'
            ]);

        }

    }

    public function connectAction(){

        header('Content-Type: application/json');

        $userLogin = $_POST['username'];
        $userPassword = $_POST['password'];
        $userPassword = Core::PasswordHash($userPassword);

        if(isset($userLogin) && isset($userPassword)) {

            $user = new UserModel();
            $connect = $user->GetUserConnect($userLogin, $userPassword);
            while($data = $connect->fetch()){
                $username = $data['username'];
                $password = $data['password'];
                $id = $data['id'];
            }
            if(!empty($username) && !empty($password) && $userLogin == $username && $userPassword == $password) {
                $_SESSION['user_id'] = $id;
                echo json_encode(['success' => true, 'code' => 200]);
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Incorrect user informations',  'code' => 400]);
            }

        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Empty form', 'code' => 400]);
        }

    }

    public function disconnectAction() {

        header('Content-Type: application/json');
        session_destroy();
        unset($_SESSION['user_id']);
        echo json_encode(['success' => 'User disconnected', 'code' => 200]);

    }

    public static function IsConnected(){

        if(isset($_SESSION['user_id'])) {

            return true;

        } else {

            return false;

        }

    }

    public function loginAction() {
        Core::Render('user', 'connect', [
            'title' => 'Todogether - Connect'
        ]);
    }

}
