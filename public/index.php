<?php
// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)

use App\Controllers\MainController;
use App\Controllers\MovieController;
use App\Controllers\ActorController;
use App\Controllers\DirectorController;
use App\Controllers\GenreController;
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


$router = new AltoRouter();

// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
} else {
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

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
    'GET',
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
        'method' => 'movieDetail',
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


$router->map(
    'GET',
    '/user/movies-list',
    [
        'method' => 'moviesList',
        'controller' => UserController::class,
        // 'acl' => ["admin"] 
    ],
    'user-movies-list'
);

$router->map(
    'GET',
    '/user/movie-add',
    [
        'method' => 'addMovie',
        'controller' => UserController::class,
        // 'acl' => ["admin"]
    ],
    'movie-add'
);

$router->map(
    'POST',
    '/user/movie-add',
    [
        'method' => 'addMoviePost',
        'controller' => UserController::class,
        'acl' => ["admin"]
    ],
    'movie-add-post'
);

$router->map(
    'GET',
    '/movie/delete/[i:id]',
    [
        'method' => 'delete',
        'controller' => MovieController::class,
        'acl' => ["admin"]
    ],
    'movie-delete'
);

$router->map(
    'GET',
    '/user/actors-list',
    [
        'method' => 'actorsList',
        'controller' => UserController::class,
        // 'acl' => ["admin"] 
    ],
    'user-actors-list'
);

$router->map(
    'GET',
    '/user/actor-add',
    [
        'method' => 'addActor',
        'controller' => UserController::class,
        // 'acl' => ["admin"]
    ],
    'actor-add'
);

$router->map(
    'POST',
    '/user/movie-add',
    [
        'method' => 'addActorPost',
        'controller' => UserController::class,
        'acl' => ["admin"]
    ],
    'add-post'
);

$router->map(
    'GET',
    '/actor/delete/[i:id]',
    [
        'method' => 'delete',
        'controller' => ActorController::class,
        'acl' => ["admin"]
    ],
    'actor-delete'
);

$router->map(
    'GET',
    '/user/directors-list',
    [
        'method' => 'directorsList',
        'controller' => UserController::class,
        // 'acl' => ["admin"] 
    ],
    'user-directors-list'
);

$router->map(
    'GET',
    '/user/director-add',
    [
        'method' => 'addDirector',
        'controller' => UserController::class,
        // 'acl' => ["admin"]
    ],
    'director-add'
);

$router->map(
    'POST',
    '/user/director-add',
    [
        'method' => 'addDirectorPost',
        'controller' => UserController::class,
        'acl' => ["admin"]
    ],
    'director-add-post'
);

$router->map(
    'GET',
    '/director/delete/[i:id]',
    [
        'method' => 'delete',
        'controller' => DirectorController::class,
        'acl' => ["admin"]
    ],
    'director-delete'
);

$router->map(
    'GET',
    '/user/genres-list',
    [
        'method' => 'genresList',
        'controller' => UserController::class,
        // 'acl' => ["admin"] 
    ],
    'user-genres-list'
);

$router->map(
    'GET',
    '/user/genre-add',
    [
        'method' => 'addGenre',
        'controller' => UserController::class,
        // 'acl' => ["admin"]
    ],
    'genre-add'
);

$router->map(
    'POST',
    '/user/genre-add',
    [
        'method' => 'addGenrePost',
        'controller' => UserController::class,
        'acl' => ["admin"]
    ],
    'genre-add-post'
);

$router->map(
    'GET',
    '/genre/delete/[i:id]',
    [
        'method' => 'delete',
        'controller' => GenreController::class,
        'acl' => ["admin"]
    ],
    'genre-delete'
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
