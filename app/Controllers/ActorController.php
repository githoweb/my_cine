<?php

namespace App\Controllers;

use App\Models\Actor;

class ActorController extends CoreController
{
    /**
     * Méthode s'occupant de la liste des actors
     *
     * @return void
     */
    public function list()
    {
        // On accède a la méthode find déclarée en statique ce qui évite de créer une instance
        // qui ne servait qu'a pouvoir accéder a la méthode find
        $actors = Actor::findAll();

        //$prod = new Product();
        //$products = $prod->findAll();

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/actors_list', [
            'actors' => $actors
        ]);
    }

    /**
     * Méthode s'occupant de l'ajout d'un movie
     *
     * @return void
     */
    public function add()
    {
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/actor_add', [
            'actor' => new Actor(),
            'title'   => 'Ajouter un actor',
        ]);
    }

    /**
     * Methode pour supprimer un actor
     *
     * @return void
     */
    public function delete($id)
    {
        $actor = Actor::find($id);

        if ($actor == null || $actor === false) {
            header('HTTP/1.0 404 Not Found');
        } else {
            $actor->delete();
            header("Location: /actor_list");
        }
    }

}
