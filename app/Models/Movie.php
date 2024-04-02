<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Une instance de Product = un produit dans la base de données
 * Product hérite de CoreModel
 */
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



    /**
     * Méthode permettant de récupérer tous les enregistrements de la table product
     *
     * @return Movie[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `movie`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Movie');

        return $results;
    }

    public static function findAllFiltered($formData)
    {
        $genreId = $formData['genre_id'];
        $year = $formData['year'];
        $directorId = $formData['director_id'];
        $actorId = $formData['actor_id'];
        dump($genreId);
        dump($year);
        dump($directorId);
        dump($actorId);

        $pdo = Database::getPDO();

        $conditions = [];
        $parameters = [];

        $sql = "SELECT * FROM `movie`";

        if($genreId !== "default") {
            $conditions[] = "`genre_id`= :genreId";
            $parameters[':genreId'] = $genreId;
        }

        if($year !== "default") {
            $conditions[] = "`date`= :year";
            $parameters[':year'] = $year;
        }

        if($directorId !== "default") {
            $conditions[] = "`director_id`= :directorId";
            $parameters[':directorId'] = $directorId;
        }

        $actorCondition = "";

        if($actorId !== "default") {
            $actorCondition = "INNER JOIN actor_movie ON movie.id = actor_movie.movie_id";
            $conditions[] = "`actor_id`= :actorId";
            $parameters[':actorId'] = $actorId;
        }

        if(!empty($conditions)) {
            $sql .= $actorCondition . " WHERE " . implode(" AND ", $conditions);
        }

        dump($sql);

        $pdoStatement = $pdo->prepare($sql);

        // Bind parameters if they exist
    
        foreach ($parameters as $param => $value) {
            $pdoStatement->bindValue($param, $value, PDO::PARAM_INT);
        }

        $pdoStatement->execute();

        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Movie');

        return $results;
    }

    /**
     * Méthode permettant de récupérer un enregistrement de la table Product en fonction d'un id donné
     *
     * @param int $productId ID du produit
     * @return Movie
     */
    public static function find($movieId)
    {
        // récupérer un objet PDO = connexion à la BDD
        $pdo = Database::getPDO();

        // on écrit la requête SQL pour récupérer le produit
        $sql = '
            SELECT *
            FROM movie
            WHERE id = ' . $movieId;

        // query ? exec ?
        // On fait de la LECTURE = une récupration => query()
        // si on avait fait une modification, suppression, ou un ajout => exec
        $pdoStatement = $pdo->query($sql);

        // fetchObject() pour récupérer un seul résultat
        // si j'en avais eu plusieurs => fetchAll
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
