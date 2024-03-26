<?php

namespace App\Controllers;

use App\Models\Movie;

// Si j'ai besoin du Model Category
// use App\Models\Category;

class MainController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function home()
    {
        // On va chercher les produits et les categories de la home page
        $movieObj = new Movie();
        $movies = $movieObj->findAllHomepage();

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue

        //$core = new CoreModel();
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/home', [
            'movies'   => $movies,
        ]);
    }
}