<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Movie extends CoreModel
{

    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $synopsis;
    /**
     * @var string
     */
    private $poster;
    /**
     * @var string
     */
    private $duration;
    /**
     * @var string
     */
    private $date;
    /**
     * @var string
     */
    protected $id;



    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `movie`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Movie');

        return $results;
    }

    public static function findAllFiltered()
    {
        $genreId = $_POST['genre_id'];
        $year = $_POST['year'];
        $directorId = $_POST['director_id'];
        $actorId = $_POST['actor_id'];

        $pdo = Database::getPDO();

        $conditions = [];
        $parameters = [];

        $sql = "SELECT * FROM movie ";

        if(isset($_POST['genre_id']) && $_POST['genre_id'] !== "") {
            $conditions[] = "genre_id= " . $_POST['genre_id'];
        }

        if(isset($_POST['director_id']) && $_POST['director_id'] !== "") {
            $conditions[] = "director_id= " . $_POST['director_id'];
        }

        if(isset($_POST['year']) && $_POST['year'] !== "") {
            $conditions[] = "date= " . $_POST['year'];
        }

        $actorCondition = "";


        if(isset($_POST['actor_id']) && $_POST['actor_id'] !== "") {
            $actorCondition = "INNER JOIN actor_movie ON movie.id = actor_movie.movie_id";
            $conditions[] = "actor_id= " . $_POST['actor_id'];
        }

        if(!empty($conditions)) {
            $sql .= $actorCondition . " WHERE " . implode(" AND ", $conditions);
        }

        dump($sql);

        $pdoStatement = $pdo->query($sql);

        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Movie');

        return $results;
    }

    public static function find($movieId)
    {
        $pdo = Database::getPDO();

        $sql = '
            SELECT *
            FROM movie
            WHERE id = ' . $movieId;

        $pdoStatement = $pdo->query($sql);

        $result = $pdoStatement->fetchObject('App\Models\Movie');

        return $result;
    }


    

    /**
     * Get the value of title
     *
     * @return  string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param  string  $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * Get the value of synopsis
     *
     * @return  string
     */
    public function getSynopsis()
    {
        return $this->synopsis;
    }

    /**
     * Set the value of synopsis
     *
     * @param  string  $synopsis
     */
    public function setSynopsis(string $synopsis)
    {
        $this->synopsis = $synopsis;
    }

    /**
     * Get the value of poster
     *
     * @return  string
     */
    public function getPoster()
    {
        // return "https://image.tmdb.org/t/p/original" . $this->poster;
        return "https://media.themoviedb.org/t/p/w300_and_h450_bestv2/" . $this->poster;        
    }

    /**
     * Set the value of poster
     *
     * @param  string  $poster
     */
    public function setPoster(string $poster)
    {
        $this->poster = $poster;
    }

    /**
     * Get the value of duration
     *
     * @return  string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set the value of duration
     *
     * @param  string  $duration
     */
    public function setDuration(string $duration)
    {
        $this->duration = $duration;
    }

    /**
     * Get the value of date
     *
     * @return  string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @param  string  $date
     */
    public function setDate(string $date)
    {
        $this->date = $date;
    }
}
