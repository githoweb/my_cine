<?php

namespace App\Controllers;



// Si j'ai besoin du Model Category
// use App\Models\Category;

class MovieController extends CoreController
{
    /**
     * Méthode s'occupant de la liste des produits
     *
     * @return void
     */
    public function list()
    {
        // On accède a la méthode find déclarée en statique ce qui évite de créer une instance
        // qui ne servait qu'a pouvoir accéder a la méthode find
        $products = Movie::findAll();

        //$prod = new Product();
        //$products = $prod->findAll();

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/product_list', [
            'movies' => $movies
        ]);
    }

}
