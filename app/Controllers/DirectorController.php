<?php

namespace App\Controllers;

use App\Models\Director;

class DirectorController extends CoreController
{
    /**
     * liste des réalisateurs
     *
     * @return void
     */
    public function list()
    {
        // méthode find déclarée en statique : évite de créer une instance
        // qui ne servait qu'a accéder à la méthode find
        $directors = Director::findAll();

        $this->show('main/directors_list', [
            'directors' => $directors
        ]);
    }

    /**
     * ajout d'un réalisateur
     *
     * @return void
     */
    public function add()
    {
        $this->show('main/actor_add', [
            'director' => new Director(),
            'title'   => 'Ajouter un director',
        ]);
    }

    /**
     * Methode pour supprimer un réalisateur
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
