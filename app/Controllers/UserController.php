<?php

namespace App\Controllers;

use App\Models\AppUser;
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
            'users' => AppUser::findAll()
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
    /**
     * Controlleur utilisé pour gérer les données POST soumises par le formulaire add user
     *
     * @return void
     */
    public function addPost()
    {

        $tabErreurs = [];
        // Récupération des données du formulaire (POST)
        $firstName = filter_input(INPUT_POST, 'firstname');
        $lastName  = filter_input(INPUT_POST, 'lastname');
        $email     = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);  // check mail fait par PHP directement
        $password  = filter_input(INPUT_POST, 'password');
        $role      = filter_input(INPUT_POST, 'role');
        $status    = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);   // Check int fait directement par PHP
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
        if ($status !== 1 && $status !== 2) {
            $tabErreurs[] = "Le status n'est pas correct";
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
        $user->setStatus($status);

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