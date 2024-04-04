<?php

namespace App\Controllers;

use App\Models\Director;

class DirectorController extends CoreController
{
    /**
     * Méthode s'occupant de la liste des directors
     *
     * @return void
     */
    public function list()
    {
        // On accède a la méthode find déclarée en statique ce qui évite de créer une instance
        // qui ne servait qu'a pouvoir accéder a la méthode find
        $directors = Director::findAll();

        //$prod = new Product();
        //$products = $prod->findAll();

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/directors_list', [
            'directors' => $directors
        ]);
    }

    /**
     * Méthode s'occupant de l'ajout d'un director
     *
     * @return void
     */
    public function add()
    {
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/actor_add', [
            'director' => new Director(),
            'title'   => 'Ajouter un director',
        ]);
    }

    /**
     * Methode pour supprimer un director
     *
     * @return void
     */
    public function delete($id)
    {
        $director = Director::find($id);

        if ($director == null || $director === false) {
            header('HTTP/1.0 404 Not Found');
        } else {
            $director->delete();
            header("Location: /directors_list");
        }
    }

}
