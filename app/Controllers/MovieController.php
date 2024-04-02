<?php

namespace App\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use App\Models\Director;
use App\Models\Actor;

class MovieController extends CoreController
{
    /**
     * Méthode s'occupant de la liste des movies
     *
     * @return void
     */
    public function list()
    {        
        // On accède a la méthode find déclarée en statique ce qui évite de créer une instance
        // qui ne servait qu'a pouvoir accéder a la méthode find
        $movies = Movie::findAll();
        $genres = Genre::findAll();
        $directors = Director::findAll();
        $actors = Actor::findAll();
        //$prod = new Product();
        //$products = $prod->findAll();

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/movies_list', [
            'movies' => $movies,
            'genres' => $genres,
            'directors' => $directors,
            'actors' => $actors
        ]);
    }

    public function listFiltered()
    {
        dump($_POST);
        $formData = $_POST;

        $genreId = $_POST['genre_id'];
        $year = $_POST['year'];
        $directorId = $_POST['director_id'];
        $actorId = $_POST['actor_id'];
        
        // On accède a la méthode find déclarée en statique ce qui évite de créer une instance
        // qui ne servait qu'a pouvoir accéder a la méthode find
        $movies = Movie::findAllFiltered();
        $genres = Genre::findAll();
        $directors = Director::findAll();
        $actors = Actor::findAll();
        $actor = Actor::find($actorId);

        //$prod = new Product();
        //$products = $prod->findAll();

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/movies_list', [
            'movies' => $movies,
            'genres' => $genres,
            'directors' => $directors,
            'actors' => $actors,
            'actor' => $actor
        ]);
    }

    public function findById($id)
    {
        dump($id);
        // Récupérer les paramètres de filtre actuels de la requête GET
        $queryParams = $_GET;
        dump($_GET);

        $movieModel = new Movie();
        $movie = $movieModel->find($id);

        dump($movie);

        $dataToSend = [];
        $dataToSend['movie'] = $movie;
        $dataToSend['queryParams'] = $queryParams;

        $this->show('main/movie_detail', $dataToSend);
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
        $this->show('main/movie_add', [
            'movie' => new Movie(),
            'title'   => 'Ajouter un movie',
        ]);
    }

    /**
     * Methode pour supprimer un movie
     *
     * @return void
     */
    public function delete($id)
    {
        $movie = Movie::find($id);

        if ($product == null || $movie === false) {
            header('HTTP/1.0 404 Not Found');
        } else {
            $movie->delete();
            header("Location: /movie_list");
        }
    }

}
