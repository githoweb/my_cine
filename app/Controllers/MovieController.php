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
        // cette méthode va afficher la liste de films, filtrée ou pas.

        // d'abord, on regarde est-ce que des filtres ont été demandés (présence de données dans $_GET)
        if (isset($_GET['year'])) {
            $filter_year = $_GET['year'];
            // on le sauvegarde en session pour utilisation ultérieure
            $_SESSION['filter_year'] = $filter_year;
        } else {
            // on veut TOUTES les années / ne pas filtrer par année
            $filter_year = "all";

            // on met à jour les filtres enregistrés, c'est à dire on vire la valeur year
            unset($_SESSION['filter_year']);
        }

        if (isset($_GET['director_id'])) {
            $filter_director_id = $_GET['director_id'];
            $_SESSION['filter_director_id'] = $filter_director_id;
        } else {
            $filter_director_id = "all";
            unset($_SESSION['filter_director_id']);
        }

        if (isset($_GET['actor_id'])) {
            $filter_actor_id = $_GET['actor_id'];
            $_SESSION['filter_actor_id'] = $filter_actor_id;
        } else {
            $filter_actor_id = "all";
            unset($_SESSION['filter_actor_id']);
        }

        if (isset($_GET['genre_id'])) {
            $filter_genre_id = $_GET['genre_id'];
            $_SESSION['filter_genre_id'] = $filter_genre_id;
        } else {
            $filter_genre_id = "all";
            unset($_SESSION['filter_genre_id']);
        }

        $movies = Movie::findAllFiltered($filter_year, $filter_genre_id, $filter_director_id, $filter_actor_id);

        $genres = Genre::findAll();
        $directors = Director::findAll();
        $actors = Actor::findAll();
        $this->show('main/movies_list', [
            'movies' => $movies,
            'genres' => $genres,
            'directors' => $directors,
            'actors' => $actors
        ]);
    }


    public function movieDetail($id)
    {
        dump($id);
        $queryParams = $_GET;
        dump($_GET);

        $movieModel = new Movie();
        $movie = $movieModel->find($id);

        dump($movie);

        $dataToSend = [];
        $dataToSend['movie'] = $movie;

        if (isset($_SESSION['filter_year'])) {
            $filter_year = $_SESSION['filter_year'];
            $_SESSION['filter_year'] = $filter_year;
        } else {
            $filter_year = "all";
            unset($_SESSION['filter_year']);
        }

        if (isset($_SESSION['filter_director_id'])) {
            $filter_director_id = $_SESSION['filter_director_id'];
            $_SESSION['filter_director_id'] = $filter_director_id;
        } else {
            $filter_director_id = "all";
            unset($_SESSION['filter_director_id']);
        }

        if (isset($_SESSION['filter_actor_id'])) {
            $filter_actor_id = $_SESSION['filter_actor_id'];
            $_SESSION['filter_actor_id'] = $filter_actor_id;
        } else {
            $filter_actor_id = "all";
            unset($_SESSION['filter_actor_id']);
        }

        if (isset($_SESSION['filter_genre_id'])) {
            $filter_genre_id = $_SESSION['filter_genre_id'];
            $_SESSION['filter_genre_id'] = $filter_genre_id;
        } else {
            $filter_genre_id = "all";
            unset($_SESSION['filter_genre_id']);
        }

        $queryParams = [
            'genre_id' => $filter_genre_id,
            'year' => $filter_year,
            'director_id' => $filter_director_id,
            'actor_id' => $filter_actor_id,
        ];

        function buildQueryString($params) {
            $queryArray = [];
            foreach ($params as $key => $value) {
              $queryArray[] = urlencode($key) . '=' . urlencode($value);
            }
            return implode('&', $queryArray);
        }

        $queryString = buildQueryString($queryParams);

        $this->show('main/movie_detail', [
            'movie' => $movie,
            'queryString' => $queryString
        ]);
    }

    /**
     * Méthode s'occupant de l'ajout d'un movie
     *
     * @return void
     */
    public function add()
    {
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

        $tokenCsrf = filter_input(INPUT_GET, 'tokenCsrf');

        if ($movie === null || $movie === false || !self::checkCsrf($tokenCsrf)) {
            header('HTTP/1.0 404 Not Found');
        } else {
            $movie->delete();
            header("Location: /user/movies-list");
        }
    }
}
