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

    public static function findAllFiltered($year = "all", $genre_id = "all", $director_id = "all",$actor_id = "all")
    {

        dump($actor_id);

        $pdo = Database::getPDO();

        $conditions = [];
        $parameters = [];

        $sql = "SELECT * FROM movie ";

        if ($genre_id != "all") {
            $conditions[] = "genre_id = " . $genre_id;
        }

        if($director_id !== "all") {
            $conditions[] = "director_id = " . $director_id;
        }

        if($year !== "all") {
            $conditions[] = "date = " . $year;
        }

        $actorCondition = "";


        if($actor_id !== "all") {
            $actorCondition = "INNER JOIN actor_movie ON movie.id = actor_movie.movie_id";
            $conditions[] = "actor_id = " . $actor_id;
        }

        dump($genre_id);
        dump($director_id);
        dump($year);
        dump($actor_id);

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
