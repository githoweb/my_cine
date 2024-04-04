<?php

namespace App\Controllers;

use App\Models\AppUser;
use App\Models\Movie;
use App\Models\Actor;
use App\Models\Director;
use App\Models\Genre;
use App\Utils\Database;

class UserController extends CoreController
{
    /**
     * Méthode s'occupant d'afficher le fomulaire de login
     *
     * @return void
     */
    public function login()
    {
        $this->show('user/login', [
            'userEmail' => ''
        ]);
    }

    /**
     * Méthode s'occupant de traiter les données POST recues
     * après soumission du formulire de login
     *
     * @return void
     */
    public function loginPost()
    {
        /*
            - Vérifier si le couple @mail, password est bien dans la base
            - Si Oui, alors je mémorise en session l'utilisateur qui est maintenant connecté
            - Si non, je réaffiche le formulaire de login avec une erreur

        */

        // Si la requette est 'GET' -> affichage du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            // Affichage du formulaire
            $this->show('user/login', [
                'userEmail' => ''
            ]);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Sinon c'est forcément un 'POST' -> traitement des données du form

            // Initialisation de mon tableau d'erreur (vide)
            $tabErreurs = [];

            // Récupération des données de formulaire (contenues dans $_POST)
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, 'password');

            // Vérification des données saisies -> email
            if ($email === null || $email === false) {
                $tabErreurs[] = "L'adresse email est incorrecte";
            }

            // Vérification des données saisies -> password
            if ($password === null || $password === false || $password === '') {
                $tabErreurs[] = "Le password ne doit pas être vide";
            }

            // On recherche cette @mail dans la base
            // false sera retourné si l'utilisateur n'existe pas
            $user = AppUser::findUserByEmail($email);

            if ($user === false) {
                // L'utilisateur n'existe pas dans la base
                $tabErreurs[] = "Cette adresse email n'existe pas";
            } else {
                // Utilisateur trouvé dans la base
                // On vérifie maintenant le password

                // * !true est egal à false
                // * !false est egal à true
                if (password_verify($password, $user->getPassword()) === false) {
                    // Le password n'est pas bon -> erreur
                    $tabErreurs[] = "Le mot de passe n'est pas le bon";
                }
            }

            // Toutes les vérifications sont faites, on va maintenant:
            // - soit réafficher le formulaire s'il y a des erreurs
            // - soit mémoriser le user en session (mode connecté)
            if (count($tabErreurs) > 0) {

                // Il y a des erreurs, on réaffiche le formulaire
                // avec l'@mail saisie
                $this->show('user/login', [
                    'userEmail' => $email,
                    'errors' => $tabErreurs
                ]);
            } else {
                // Aucune erreur, cela signifie que l'utilisateur est
                // bien dans la base et que le mot de passe saisi
                // est le bon

                // Mise en session de l'user id et de l'user object

                $_SESSION['userId'] = $user->getId();
                $_SESSION['userObject'] = $user;

                $tabSuccess = [];
                $tabSuccess[] = "Vous êtes connecté";

                $this->show('user/login-logout-success', [
                    'user' => $user,
                    'success' => $tabSuccess
                ]);
            }
        }
    }

    /**
     * Controlleur utilisé pour se déconnecter
     *
     * @return void
     */
    public function logout()
    {
        $user = $_SESSION['userObject'];

        unset($_SESSION['userId']);
        unset($_SESSION['userObject']);

        $tabSuccess = [];
        $tabSuccess[] = "Vous êtes bien déconnecté";

        $this->show('user/login-logout-success', [
            'user' => $user,
            'success' => $tabSuccess
        ]);
    }

    /**
     * COntrolleur utilisé pour lister l'ensembles des utilisateurs enregistrés
     *
     * @return void
     */
    public function list()
    {
         $this->show('user/list', [
            'users' => AppUser::findAll(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }

    /**
     * Controlleur utilisé pour l'ajout d'un utilisateur (affichage form)
     *
     * @return void
     */
    public function add()
    {
        $this->show('user/add_edit', [
            'title' => "Ajouter un utilisateur",
            'user'  => new AppUser(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }

    public function addPost()
    {

        $tabErreurs = [];
        // Récupération des données du formulaire (POST)
        $firstName = filter_input(INPUT_POST, 'firstname');
        $lastName  = filter_input(INPUT_POST, 'lastname');
        $email     = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);  // check mail fait par PHP directement
        $password  = filter_input(INPUT_POST, 'password');
        $role      = filter_input(INPUT_POST, 'role');
        $tokenCsrf = filter_input(INPUT_POST, 'tokenCsrf');

        if (!self::checkCsrf($tokenCsrf)) {
            $tabErreurs[] = "Token inconnu/non recu";
        }
        // Contrôles sur les champs du form
        if ($firstName === null || strlen($firstName) === 0) {
            $tabErreurs[] = "Le prénom n'est pas correct";
        }
        if ($lastName === null || strlen($lastName) === 0) {
            $tabErreurs[] = "Le nom n'est pas correct";
        }
        if ($email === null || strlen($email) === 0) {
            $tabErreurs[] = "L'email n'est pas correct";
        }
        if ($password === null || strlen($password) < 4 || !$this->testPwd($password)) {
            $tabErreurs[] = "Le password n'est pas correct";
        }
        if ($role !== "admin" && $role !== "catalog-manager") {
            $tabErreurs[] = "Le role n'est pas correct";
        }

        // On a une contrainte d'unicité dans la base sur le chmp email
        // Donc on controle que cet email n'y est pas déjà
        if (AppUser::findUserByEmail($email) !== false) {
            $tabErreurs[] = "Cet email est déjà enregistré";
        }

        // Init de l'objet AppUser
        $user = new AppUser();
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);
        $user->setPassword($email);
        $user->setRole($role);

        // Traitement de fin
        if (count($tabErreurs) === 0) {
            // Il n'y a pas d'erreur -> hash password et sauvegard en database
            $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
            if ($user->save() === false) {
                $tabErreurs[] = "Echec de la sauvegarde";
            };
        }

        if (count($tabErreurs) === 0) {
            header("Location: /user/list");
        } else {
            // Il y a des erreurs -> affichage du form avec les données saisies
            $this->show('user/add_edit', [
                'title' => "Ajouter un utilisateur",
                'user'  => $user,
                'errors' => $tabErreurs,
                'tokenCsrf' => Self::setCsrf()
            ]);
        }
    }

    public function delete($id)
    {
        $user = AppUser::find($id);

        // On récupère le token Csrf passé directement dans la route sous la forme
        // /category/delete/id?tokenCsrf=230930239209302930293023902

        $tokenCsrf = filter_input(INPUT_GET, 'tokenCsrf');

        if ($user == null || $user === false || !self::checkCsrf($tokenCsrf)) {
            header('HTTP/1.0 404 Not Found');
        } else {
            $user->delete();
            header("Location: /user/list");
        }
    }


    /* --- MOVIES --- */
    public function moviesList()
    {
         $this->show('user/movies_list', [
            'movies' => Movie::findAll(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }

    public function addMovie()
    {
        $this->show('user/movie-add_edit', [
            'title' => "Ajouter un film",
            'movie'  => new Movie(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }

    public function addMoviePost()
    {

        $tabErreurs = [];
        $title = filter_input(INPUT_POST, 'title');
        $poster  = filter_input(INPUT_POST, 'poster');
        $duration  = filter_input(INPUT_POST, 'duration');
        $date      = filter_input(INPUT_POST, 'date');
        $synopsis      = filter_input(INPUT_POST, 'synopsis');
        $genre_id      = filter_input(INPUT_POST, 'genre_id');
        $director_id      = filter_input(INPUT_POST, 'director_id');
        $tokenCsrf = filter_input(INPUT_POST, 'tokenCsrf');

        if (!self::checkCsrf($tokenCsrf)) {
            $tabErreurs[] = "Token inconnu/non recu";
        }

        if ($title === null || strlen($title) === 0) {
            $tabErreurs[] = "Le prénom n'est pas correct";
        }
        if ($poster === null || strlen($poster) === 0) {
            $tabErreurs[] = "Le nom n'est pas correct";
        }
        if ($duration === null || strlen($duration) === 0) {
            $tabErreurs[] = "L'email n'est pas correct";
        }
        if ($date === null || strlen($date) === 0) {
            $tabErreurs[] = "L'email n'est pas correct";
        }
        if ($synopsis === null || strlen($synopsis) === 0) {
            $tabErreurs[] = "L'email n'est pas correct";
        }
        if ($genre_id === null || strlen($genre_id) === 0) {
            $tabErreurs[] = "L'email n'est pas correct";
        }
        if ($director_id === null || strlen($director_id) === 0) {
            $tabErreurs[] = "L'email n'est pas correct";
        }

        $movie = new Movie();
        $movie->setTitle($title);
        $movie->setPoster($poster);
        $movie->setDuration($duration);
        $movie->setDate($date);
        $movie->setSynopsis($synopsis);
        $movie->setGenreId($genre_id);
        $movie->setDirectorId($director_id);

        if (count($tabErreurs) === 0) {
            header("Location: /user/movies-list");
        } else {
            // Il y a des erreurs -> affichage du form avec les données saisies
            $this->show('user/add-movie_edit', [
                'title' => "Ajouter un film",
                'movie'  => $movie,
                'errors' => $tabErreurs,
                'tokenCsrf' => Self::setCsrf()
            ]);
        }
    }


    /* --- ACTORS --- */
    public function actorsList()
    {
         $this->show('user/actors_list', [
            'actors' => Actor::findAll(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }

    public function addActor()
    {
        $this->show('user/actor-add_edit', [
            'title' => "Ajouter un Acteur",
            'actor'  => new Actor(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }

    public function addActorPost()
    {

        $tabErreurs = [];
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname  = filter_input(INPUT_POST, 'lastname');
        $birth      = filter_input(INPUT_POST, 'birth');
        $poster      = filter_input(INPUT_POST, 'poster');
        $biography      = filter_input(INPUT_POST, 'biography');
        $tokenCsrf = filter_input(INPUT_POST, 'tokenCsrf');

        if (!self::checkCsrf($tokenCsrf)) {
            $tabErreurs[] = "Token inconnu/non recu";
        }

        if ($firstname === null || strlen($firstname) === 0) {
            $tabErreurs[] = "Le prénom n'est pas correct";
        }
        if ($lastname === null || strlen($lastname) === 0) {
            $tabErreurs[] = "Le nom n'est pas correct";
        }
        if ($birth === null || strlen($birth) === 0) {
            $tabErreurs[] = "La date de naissance n'est pas correcte";
        }
        if ($poster === null || strlen($poster) === 0) {
            $tabErreurs[] = "L'image n'est pas correct";
        }
        if ($biography === null || strlen($biography) === 0) {
            $tabErreurs[] = "La biographie n'est pas correcte";
        }

        $actor = new Actor();
        $actor->setFirstname($firstname);
        $actor->setLastname($lastname);
        $birth->setBirth($birth);
        $poster->setPassword($poster);
        $biography->setBiography($biography);

        if (count($tabErreurs) === 0) {
            if ($actor->save() === false) {
                $tabErreurs[] = "Echec de la sauvegarde";
            };
        }

        if (count($tabErreurs) === 0) {
            header("Location: /user/actors-list");
        } else {
            // Il y a des erreurs -> affichage du form avec les données saisies
            $this->show('user/actor-add_edit', [
                'title' => "Ajouter un acteur",
                'actor'  => $actor,
                'errors' => $tabErreurs,
                'tokenCsrf' => Self::setCsrf()
            ]);
        }
    }


    /* --- DIRECTORS --- */
    public function directorsList()
    {
         $this->show('user/directors_list', [
            'directors' => Director::findAll(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }

    public function addDirector()
    {
        $this->show('user/director-add_edit', [
            'title' => "Ajouter un Réalisateur",
            'director'  => new Director(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }

    public function addDirectorPost()
    {

        $tabErreurs = [];
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname  = filter_input(INPUT_POST, 'lastname');
        $birth      = filter_input(INPUT_POST, 'birth');
        $poster      = filter_input(INPUT_POST, 'poster');
        $biography      = filter_input(INPUT_POST, 'biography');
        $tokenCsrf = filter_input(INPUT_POST, 'tokenCsrf');

        if (!self::checkCsrf($tokenCsrf)) {
            $tabErreurs[] = "Token inconnu/non recu";
        }

        if ($firstname === null || strlen($firstname) === 0) {
            $tabErreurs[] = "Le prénom n'est pas correct";
        }
        if ($lastname === null || strlen($lastname) === 0) {
            $tabErreurs[] = "Le nom n'est pas correct";
        }
        if ($birth === null || strlen($birth) === 0) {
            $tabErreurs[] = "La date de naissance n'est pas correcte";
        }
        if ($poster === null || strlen($poster) === 0) {
            $tabErreurs[] = "L'image n'est pas correct";
        }
        if ($biography === null || strlen($biography) === 0) {
            $tabErreurs[] = "La biographie n'est pas correcte";
        }

        $director = new Director();
        $director->setFirstName($firstname);
        $director->setLastName($lastname);
        $director->setBirth($birth);
        $director->setPoster($poster);
        $director->setBiography($biography);

        if (count($tabErreurs) === 0) {
            header("Location: /user/directors-list");
        } else {
            // Il y a des erreurs -> affichage du form avec les données saisies
            $this->show('user/director-add_edit', [
                'title' => "Ajouter un utilisateur",
                'director'  => $director,
                'errors' => $tabErreurs,
                'tokenCsrf' => Self::setCsrf()
            ]);
        }
    }

        /* --- GENRES --- */
    public function genresList()
    {
         $this->show('user/genres_list', [
            'genres' => Genre::findAll(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }

    public function addGenre()
    {
        $this->show('user/genre-add_edit', [
            'title' => "Ajouter un genre",
            'genre'  => new Genre(),
            'tokenCsrf' => self::setCsrf()
        ]);
    }

    public function addGenrePost()
    {

        $tabErreurs = [];
        $name = filter_input(INPUT_POST, 'name');
        $tokenCsrf = filter_input(INPUT_POST, 'tokenCsrf');

        if (!self::checkCsrf($tokenCsrf)) {
            $tabErreurs[] = "Token inconnu/non recu";
        }

        if ($name === null || strlen($name) === 0) {
            $tabErreurs[] = "Le nom n'est pas correct";
        }

        $genre = new Genre();
        $genre->setName($name);

        if (count($tabErreurs) === 0) {
            if ($genre->save() === false) {
                $tabErreurs[] = "Echec de la sauvegarde";
            };
        }

        if (count($tabErreurs) === 0) {
            header("Location: /user/genres-list");
        } else {
            // Il y a des erreurs -> affichage du form avec les données saisies
            $this->show('user/genre-add_edit', [
                'title' => "Ajouter un genre",
                'genre'  => $genre,
                'errors' => $tabErreurs,
                'tokenCsrf' => Self::setCsrf()
            ]);
        }
    }





    /* --- --- */

    /**
     * Fonction de test password
     *
     * @param string $password  le password à tester
     * @param integer $minLength la longueur min du password (default = 8)
     * @param boolean $noMinus true si on ne doit pas tester les minuscules
     * @param boolean $noMajus true si on ne doit pas tester les majuscules
     * @param boolean $noSpecial true si on ne doit pas tester les cars spéciaux
     * @param boolean $noNum true si on ne doit pas tester les chiffres
     * @return void
     */
    function testPwd($password, $minLength = 8, $noMinus = false, $noMajus = false, $noSpecial = false, $noNum = false)
    {

        if (true) {     // Pour executer une seule des deux alternatives (true : regexp, false: algo php)
            return preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@_$!%*#?&])[A-Za-z\d@$!%_*#?&]{8,}$/", $password);
        } else {

            if (strlen($password) < $minLength) {
            // Longueur pas bonne -> erreur
                return false;
            }

            // On splite le password cractere par caractere dans un tableau
            // ou parcours le password caractere par caractere
            foreach (str_split($password) as $c) {
                // Test des minuscules
                // Le 1er test (!noMinus) permet de ne plus faire le strpos si on a deja trouvé
                // une minuscule
                if (!$noMinus   && strpos("abcdefghijklmnopqrstuvwxyz", $c) !== false) {
                    // Le flag $noMinus est mis a true signalant que c'est bon pour les minuscules
                    $noMinus = true;
                }
                // Le 1er test (!noMajus) permet de ne plus faire le strpos si on a deja trouvé
                // une majuscule
                if (!$noMajus   && strpos("ABCDEFGHIJKLMNOPQRSTUVWXYZ", $c) !== false) {
                    // Le flag $noMajus est mis a true signalant que c'est bon pour les majuscules
                    $noMajus = true;
                }
                if (!$noSpecial && strpos("_-|%&*=@$]", $c) !== false) {
                    $noSpecial = true;
                }
                if (!$noNum     && strpos("0123456789", $c) !== false) {
                    $noNum = true;
                }
            }
            // pour retourner 'true', il faut que les 4 flags soient egalement à true
            return $noMinus && $noMajus && $noSpecial && $noNum;
        }
    }
}