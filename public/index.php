<?php


// POINT D'ENTRÉE UNIQUE :
// FrontController

// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)

use App\Controllers\MainController;
use App\Controllers\MovieController;
use App\Controllers\ActorController;
use App\Controllers\DirectorController;
use App\Controllers\UserController;

require_once '../vendor/autoload.php';

// Mise en route des sessions au niveau de PHP
session_start();



/* ---- SCSS ---- */
use ScssPhp\ScssPhp\Compiler;

$compiler = new Compiler();

$source = file_get_contents('../app/scss/styles.scss');

try {
  $output = $compiler->compile($source);
  file_put_contents('assets/css/output.css', $output);
//   echo 'SCSS compiled successfully!';
} catch (\Exception $e) {
//   echo 'Error compiling SCSS: ' . $e->getMessage();
}




/* ------------
--- ROUTAGE ---
-------------*/


// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
} else { // sinon
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// On doit déclarer toutes les "routes" à AltoRouter,
// afin qu'il puisse nous donner LA "route" correspondante à l'URL courante
// On appelle cela "mapper" les routes
// 1. méthode HTTP : GET ou POST (pour résumer)
// 2. La route : la portion d'URL après le basePath
// 3. Target/Cible : informations contenant
//      - le nom de la méthode à utiliser pour répondre à cette route
//      - le nom du controller contenant la méthode
// 4. Le nom de la route : pour identifier la route, on va suivre une convention
//      - "NomDuController-NomDeLaMéthode"
//      - ainsi pour la route /, méthode "home" du MainController => "main-home"
$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => MainController::class,
        // 'acl' => ["admin"]
    ],
    'main-home'
);

$router->map(
    'GET',
    '/movie/list',
    [
        'method' => 'list',
        'controller' => MovieController::class,
        // 'acl' => ["admin"]
    ],
    'movies-list'
);

$router->map(
    'POST',
    '/movie/listFiltered',
    [
        'method' => 'listFiltered',
        'controller' => MovieController::class,
        // 'acl' => ["admin"]
    ],
    'movies-listFiltered'
);

$router->map(
    'GET',
    '/movie/[i:id]',
    [
        'method' => 'findById',
        'controller' => MovieController::class
    ],
    'movie-detail'
);

$router->map(
    'GET',
    '/actor/list',
    [
        'method' => 'list',
        'controller' => ActorController::class,
        // 'acl' => ["admin"]
    ],
    'actors-list'
);

$router->map(
    'GET',
    '/director/list',
    [
        'method' => 'list',
        'controller' => DirectorController::class,
        // 'acl' => ["admin"]
    ],
    'directors-list'
);


$router->map(
    'GET|POST',
    '/login',
    [
        'method' => 'loginPost',
        'controller' => UserController::class,
        // 'acl' => ["admin"]
    ],
    'login'
);

$router->map(
    'GET',
    '/logout',
    [
        'method' => 'logout',
        'controller' => UserController::class ,
        // 'acl' => ["admin"]
    ],
    'logout'
);

// Liste des utilisateurs
$router->map(
    'GET',
    '/user/list',
    [
        'method' => 'list',
        'controller' => UserController::class,
        // 'acl' => ["admin"] 
    ],
    'user-list'
);

// Ajout d'un utilisateur (route get)
$router->map(
    'GET',
    '/user/add',
    [
        'method' => 'add',
        'controller' => UserController::class,
        // 'acl' => ["admin"]
    ],
    'user-add'
);

// Ajout d'un utilisateur (route post)
$router->map(
    'POST',
    '/user/add',
    [
        'method' => 'addPost',
        'controller' => UserController::class,
        'acl' => ["admin"]
    ],
    'user-add-post'
);

// Ajout d'un utilisateur (route post)
$router->map(
    'POST',
    '/user/delete/[i:id]',
    [
        'method' => 'delete',
        'controller' => UserController::class,
        'acl' => ["admin"]
    ],
    'user-delete'
);

/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');
// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();
