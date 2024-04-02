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
            'actors' => $actors,

            'genre_id' => '',
            'year' => '',
            'director_id' => '',
            'actor_id' => '',
        ]);
    }

    public function listFiltered()
    {
        $actorId = $_GET['actor_id'];

        if (isset($_POST['submit'])) {
            // Traitement du formulaire de recherche
            $genreId = $_GET['genre_id'];
            $year = $_GET['year'];
            $directorId = $_GET['director_id'];
            $actorId = $_GET['actor_id'];



            // Construction de l'URL avec les paramètres GET
            $url = '/movie/list?genre_id=' . $genreId . '&year=' . $year . '&director_id=' . $directorId . '&actor_id=' . $actorId;

            // Suppression de l'en-tête "Content-Type"
            header_remove('Content-Type');
            // Redirection vers la page de liste
            header('Location: ' . $url);
        }

        $filterParams = [
            'genre_id' => $_GET['genre_id'],
            'year' => $_GET['year'],
            'director_id' => $_GET['director_id'],
            'actor_id' => $_GET['actor_id']
        ];

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
            'actor' => $actor,
            'filterParams' => $filterParams
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

        $dataToSend = [
            'movie' => $movie,
            'filters' => [ // Keep filters array for potential use in the view
                'genre_id' => isset($_GET['genre_id']) ? $_GET['genre_id'] : '',
                'year' => isset($_GET['year']) ? $_GET['year'] : '',
                'director_id' => isset($_GET['director_id']) ? $_GET['director_id'] : '',
                'actor_id' => isset($_GET['actor_id']) ? $_GET['actor_id'] : '',
            ],
        ];

        // If filters are present, append them to the "movies-listFiltered" route URL
    if (!empty($dataToSend['filters'])) {
        $queryString = http_build_query($dataToSend['filters']);
        $this->show('main/movie_detail', $dataToSend, "movies-listFiltered?$queryString");
    } else {
        $this->show('main/movie_detail', $dataToSend);
    }

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
