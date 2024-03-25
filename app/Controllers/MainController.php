<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\CoreModel;
use App\Models\Product;

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
        $prod = new Product();
        $products = $prod->findAllHomepage();

        $cat = new Category();
        $categories = $cat->findAllHomepage();
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue

        //$core = new CoreModel();
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/home', [
            'products'   => $products,
            'categories' => $categories
        ]);
    }
}