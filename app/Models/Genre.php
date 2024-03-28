<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Une instance de Product = un produit dans la base de données
 * Product hérite de CoreModel
 */
class Genre extends CoreModel
{

    /**
     * @var string
     */
    private $name;



    /**
     * Méthode permettant de récupérer tous les enregistrements de la table product
     *
     * @return Genre[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `genre`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Genre');

        return $results;
    }

    /**
     * Get the value of title
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of title
     *
     * @param  string  $title
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }


}
