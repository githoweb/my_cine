<?php

namespace App\Models;

use App\Utils\Database;
use Exception;
use PDO;

class AppUser extends CoreModel
{

  /**
   *
   * @var string
   */
  private $email;

  /**
   *
   * @var string
   */
  private $password;

  /**
   *
   * @var string
   */
  private $firstname;

  /**
   *
   * @var string
   */
  private $lastname;

  /**
   *
   * @var string
   */
  private $role;


      /**
     * Rechercher un enregistrement d'utilisateur dans la database
     *
     * @param integer $id
     * @return false|AppUser
     */
    public static function find(int $id)
    {
        // Ici on peut se passer de faire une protection injection SQL
        // Du fait que le param $id est forcéement un entier

        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = '
            SELECT *
            FROM app_user
            WHERE id = ' . $id;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        // AppUser::class renvoie le nom de classe avec le namespaec, ici 'App\Models\AppUser'
        $user = $pdoStatement->fetchObject(AppUser::class);

        // retourner le résultat
        return $user;        
    }
    
    /**
     * Permet de récuperer tous les enregistrements de la table app_user
     *
     * @param integer $limit
     * @return void
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();

        $sql = 'SELECT * FROM `app_user`';

        $pdoStatement = $pdo->query($sql);
        // AppUser::class renvoie le nom de classe avec le namespaec, ici 'App\Models\AppUser'
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, AppUser::class);

        return $results;
    }

    /**
     * Permet de retrouver un utilisateur avec son adresse email
     *
     * @param string $email
     * @return false|AppUser
     */
    public static function findUserByEmail(string $email)
    {
        $pdo = Database::getPDO();

        // Requette sql a executer
        $sql = 'SELECT * FROM `app_user` WHERE email = :email';

        // ¨Préparation de la requete
        $query = $pdo->prepare($sql);

        // Bind des variables et execute SQL
        $query->execute([
            ':email'     => $email
        ]);

        // récupération des données et stockage dans une instance de AppUser
        return $query->fetchObject(AppUser::class);
    }

  /**
   * Inserer nouvel enregistrement en database
   *
   * @return bool
   */
  public function insert()
  {
    // Récupération de l'objet PDO représentant la connexion à la DB
    $pdo = Database::getPDO();

    // Ecriture de la requête INSERT INTO
    // $sql = "
    //     INSERT INTO `app_user` (email, password, firstname, lastname, role)
    //     VALUES (
    //         :email,
    //         :password,
    //         :firstname,
    //         :lastname,
    //         :role,
    //     )";

    // ¨Préparation de la requete
    $query = $pdo->prepare("
      INSERT INTO `app_user` (email, password, firstname, lastname, role)
      VALUES (
          :email,
          :password,
          :firstname,
          :lastname,
          :role
      )");

    // Bind des variables et execute SQL
    $query->execute([
      ':email'     => $this->getEmail(),
      ':password'  => $this->getPassword(),
      ':firstname' => $this->getFirstName(),
      ':lastname'  => $this->getLastName(),
      ':role'      => $this->getRole(),
    ]);

    // Pour être exhaustif, je rensigne l'id de mon objet
    // avec le 'lastInsertId'
    if ($query->rowCount() > 0) {
        $this->id = $pdo->lastInsertId();
        return true;
    }
    // Signifie que l'insert n'à pas fonctionné pour une raison quelconque
    return false;
  }

  /**
   * Modifier un enregistrement en database
   *
   * @return bool
   */
  public function update()
  {
    // Récupération de l'objet PDO représentant la connexion à la DB
    $pdo = Database::getPDO();

    // Ecriture de la requête INSERT INTO
    $sql = "
    UPDATE `app_user` set 
        email = :email,
        password = :password,
        firstname = :firstname,
        lastname = :lastname,
        role = :role,
        updated_at = now()
    where id = :id";

    // ¨Préparation de la requete
    $query = $pdo->prepare($sql);

    // Bind des variables et execute SQL
    $query->execute([
      ':email'     => $this->getEmail(),
      ':password'  => $this->getPassword(),
      ':firstname' => $this->getFirstName(),
      ':lastname'  => $this->getLastName(),
      ':role'      => $this->getRole(),
      ':id'        => $this->getId()
    ]);

    return ($query->rowCount() > 0);
  }
  /**
   * Supprimer enregistrement en database
   *
   * @return bool
   */
  public function delete()
  {
    // Récupération de l'objet PDO représentant la connexion à la DB
    $pdo = Database::getPDO();

    // Ecriture de la requête UPDATE
    $sql = "delete from app_user where id = :id";

    // Execution de la requête de mise à jour (exec, pas query)
    $query = $pdo->prepare($sql);

    $updatedRows = $query->execute([
      ':id' => $this->getId()
    ]);

    // On retourne VRAI, si au moins une ligne supprimée
    return ($updatedRows > 0);
  }

  /**
   * Get the value of role
   *
   * @return  string
   */
  public function getRole()
  {
    return $this->role;
  }

  /**
   * Set the value of role
   *
   * @param  string  $role
   *
   * @return  self
   */
  public function setRole(string $role)
  {
    $this->role = $role;

    return $this;
  }

  /**
   * Get the value of email
   *
   * @return  string
   */
  public function getEmail()
  {
    return $this->email;
  }

  /**
   * Set the value of email
   *
   * @param  string  $email
   *
   * @return  self
   */
  public function setEmail(string $email)
  {
    $this->email = $email;

    return $this;
  }

  /**
   * Get the value of password
   *
   * @return  string
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * Set the value of password
   *
   * @param  string  $password
   *
   * @return  self
   */
  public function setPassword(string $password)
  {
    $this->password = $password;

    return $this;
  }

  /**
   * Get the value of lastName
   *
   * @return  string
   */
  public function getLastName()
  {
    return $this->lastname;
  }

  /**
   * Set the value of lastName
   *
   * @param  string  $lastName
   *
   * @return  self
   */
  public function setLastName(string $lastName)
  {
    $this->lastname = $lastName;

    return $this;
  }

  /**
   * Get the value of firstName
   *
   * @return  string
   */
  public function getFirstName()
  {
    return $this->firstname;
  }

  /**
   * Set the value of firstName
   *
   * @param  string  $firstName
   *
   * @return  self
   */
  public function setFirstName(string $firstName)
  {
    $this->firstname = $firstName;

    return $this;
  }
}