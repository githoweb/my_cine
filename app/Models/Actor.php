<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Une instance de Product = un produit dans la base de données
 * Product hérite de CoreModel
 */
class Actor extends CoreModel
{

    /**
     * @var string
     */
    private $firstname;
    /**
     * @var string
     */
    private $lastname;
    /**
     * @var string
     */
    private $birth;
    /**
     * @var string
     */
    private $poster;
    /**
     * @var string
     */
    private $biography;

    /**
     * Méthode permettant de récupérer un enregistrement de la table Actor en fonction d'un id donné
     *
     * @param int $actorId ID de l'acteur
     * @return Product
     */
    public static function find($actorId)
    {
        // récupérer un objet PDO = connexion à la BDD
        $pdo = Database::getPDO();

        // on écrit la requête SQL pour récupérer le produit
        // $sql = '
        //     SELECT *
        //     FROM actor
        //     WHERE `actor_id`= $actorId ';


        // $pdoStatement = $pdo->query($sql);

        // $result = $pdoStatement->fetchObject('App\Models\Actor');

        // dump($result);

        // return $result;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table product
     *
     * @return Actor[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `actor`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Actor');

        return $results;
    }
    

    /**
     * Get the value of firstname
     *
     * @return  string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @param  string  $title
     */
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get the value of lastname
     *
     * @return  string $lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @param  string  $lastname
     */
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get the value of birth
     *
     * @return  string $birth
     */
    public function getBirth()
    {
        return $this->birth;
    }

    /**
     * Set the value of birth
     *
     * @param  string  $birth
     */
    public function setBirth(string $birth)
    {
        $this->birth = $birth;
    }

    /**
     * Get the value of photo
     *
     * @return  string $photo
     */
    public function getPoster()
    {
        return "https://media.themoviedb.org/t/p/w300_and_h450_bestv2/" . $this->poster;        
    }

    /**
     * Set the value of photo
     *
     * @param  string  $photo
     */
    public function setPoster(string $poster)
    {
        $this->poster = $poster;
    }

    /**
     * Get the value of biography
     *
     * @return  string $biography
     */
    public function getBiography()
    {
        return $this->biography;        
    }

    /**
     * Set the value of biography
     *
     * @param  string  $biography
     */
    public function setBiography(string $biography)
    {
        $this->biography = $biography;
    }

}
