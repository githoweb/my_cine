<?php

namespace App\Controllers;

use App\Models\Actor;

class ActorController extends CoreController
{
    /**
     * liste des acteurs
     *
     * @return void
     */
    public function list()
    {
        // On accède a la méthode find déclarée en statique ce qui évite de créer une instance
        // qui ne servait qu'a pouvoir accéder à la méthode find
        $actors = Actor::findAll();

        $this->show('main/actors_list', [
            'actors' => $actors
        ]);
    }

    /**
     * ajout d'un acteur
     *
     * @return void
     */
    public function add()
    {
        $this->show('main/actor_add', [
            'actor' => new Actor(),
            'title'   => 'Ajouter un acteur',
        ]);
    }

    /**
     * supprimer un acteur
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
