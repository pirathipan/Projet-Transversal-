<?php

class CategorieController{

    public function getAllCategories($id){

        $categorie = new CategorieModel();
        $categories = $categorie->GetCategorie($id);

        return $categories;
    }

}
