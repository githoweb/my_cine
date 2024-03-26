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
     * Méthode permettant de récupérer tous les enregistrements de la table product
     *
     * @return Product[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `movie`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Movie');

        return $results;
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
