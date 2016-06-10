<?php

class AnnonceController{

    public function indexAction(){

        $user = new UserModel();
        $annonces = new AnnonceModel();
        $annonce = $annonces->GetAllAnnonces();
        Core::Render('Annonce', 'index', [
            'title' => 'Todogether',
            'user' => $user,
            'annonces' => $annonce,
            'connected' => UserController::IsConnected()
        ]);

    }

    public function getAllAnnonces(){

        $annonce = new AnnonceModel();
        $annonces = $annonce->GetAllAnnoncesByCategorie();
        return $annonces;

    }

    public function readAction()
    {
        global $id;
        $annonces = new AnnonceModel();
        $annonce = $annonces->GetAnnonce($id);
        $user = new UserModel();
        $author = $user->GetUser($annonce['user_related_id']);
        Core::Render('Annonce', 'read', [
            'title' => 'Todogether',
            'annonce' => $annonce,
            'author' => $author,
            'connected' => UserController::IsConnected()
        ]);
    }

    public function newAction(){

        if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['place'])){
            header('Content-Type: application/json');
            $annonces = new AnnonceModel();
            $annonces->CreateAnnonce($_POST['title'], $_POST['description'], $_POST['place'], date('d/m/Y'), '', $_SESSION['user_id'], '');
            echo json_encode(['success' => true, 'message' => 'Nouvelle annonce créé']);
        } else {
            Core::Render('Annonce', 'new', []);
        }

    }

    public function editAction() {
        
        global $id;
        if(UserController::IsConnected()){
            
                $annonces = new AnnonceModel();
                $annonce = $annonces->GetAnnonce($id);

                if($_SESSION['user_id'] == $annonce['user_related_id']){
                    if(isset($_POST['title']) && isset($_POST['description']) && isset($_POST['adress'])){
                        header('Content-Type: application/json');
                        $annonces->UpdateAnnonce($annonce['id'], htmlentities($_POST['title']), $_POST['description'], $_POST['adress'], date('d/m/Y'), 1, '');
                        echo json_encode(['success' => 'Annonce modifiée', 'Nouvelle image' => true, 'article id' => $annonce['id']]);

                    } else {
                        Core::Render('annonce', 'edit', [
                            'title' => 'Todogether - Edition annonce : ',
                            'annonce' => $annonce
                        ]);
                    }

                    

                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['error' => 'This post belong to somebody else']);

                }


        } else {
                header('Content-Type: application/json');
             echo json_encode(['error' => 'Unauthorized']);

        }

    }
}
