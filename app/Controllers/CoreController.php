<?php

namespace App\Controllers;

class CoreController
{
    /**
     * Le constructeur est utilisé pour faire des "pré-checks" avant d'appeler le controlleur
     */
    public function __construct()
    {
        global $match;

        // On récupère la variable match initialisée par altorouter
        // ou y trouve sous la clé ['target']['acl'] la liste des droits requis
        // pour l'accès à la page
        if (isset($match['target']['acl'])) {

            // On teste si l'utilisateur à les droits requis
            $this->checkAuthorization($match['target']['acl']);
        }

    }

    /**
     * Génère un token CSRF, le mémorise en session et le retourne a l'appelant
     *
     * @return string
     */
    public static function setCsrf()
    {
        $_SESSION['tokenCsrf'] = bin2hex(random_bytes(32));
        return $_SESSION['tokenCsrf'];        
    }

    /**
     * Permet de vérifier que le token recu en POST après soumission
     * est bien celui stocké en session
     *
     * @param [type] $tokenCsrf
     * @return void
     */
    public static function checkCsrf($tokenCsrf)
    {
        $test = $tokenCsrf === $_SESSION['tokenCsrf'];
        unset($_SESSION['tokenCsrf']);
        return $test;
    }

    /**
     * Cette fonction permet de vérifier que l'utilisateur connecté
     * Dispose bien d'un rôle requis pour l'accès a cette page
     * 
     * @param array $roles
     * @return bool
     */
    public function checkAuthorization($roles = [])
    {
        if (!isset($_SESSION['userId'])) {
            // Utilisateur non connécté -> erreur -> go vers la page de login
            header("Location: /login");
            exit;
        } else {
            $user = $_SESSION['userObject'];
            $userRole = $user->getRole();

            // Le role de l'utilisateur est il présent dans la liste
            // passée en parametre
            $hasRole = in_array($userRole, $roles);

            if ($hasRole === true) {
                // Ok, on retourne chez l'appelant
                return true;
            } else {
                // KO on va vers la page erreur 403 : forbidden access
                $this->show("error/err403");
                exit;
            }
        }
    }

    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewData Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewData = [])
    {
        // On globalise $router car on ne sait pas faire mieux pour l'instant
        global $router;

        // Comme $viewData est déclarée comme paramètre de la méthode show()
        // les vues y ont accès
        // ici une valeur dont on a besoin sur TOUTES les vues
        // donc on la définit dans show()
        $viewData['currentPage'] = $viewName;

        // définir l'url absolue pour nos assets
        $viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewData['baseUri'] = $_SERVER['BASE_URI'];



        // On veut désormais accéder aux données de $viewData, mais sans accéder au tableau
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewData);

        // => la variable $currentPage existe désormais, et sa valeur est $viewName
        // => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        // => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
        // => il en va de même pour chaque élément du tableau

        // $viewData est disponible dans chaque fichier de vue
        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }
}