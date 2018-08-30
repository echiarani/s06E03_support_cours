<?php

include __DIR__ . '/../app/inc/AltoRouter.php';
include __DIR__ . '/../app/inc/Database.php';
include __DIR__ . '/../app/controllers/MainController.php';

$configuration = parse_ini_file(
  __DIR__ . '/../app/config.ini',
  true
);

// Instancier la classe AltoRouter (dépendance de notre projet)
$router = new AltoRouter;

// On définit notre chemin de départ vu qu'on travail avec des sous-dossiers
$router->setBasePath($configuration['router']['base_path']);

// Page d'accueil
$router->map('GET', '/', 'MainController#home', 'home');
// Création de liste
$router->map('POST', '/list/create', 'ListController#create', 'list_create');
// Suppression de liste
$router->map('POST', '/list/[i:id]/delete', 'ListController#delete', 'list_delete');

$match = $router->match();

if($match === false) {
  // $controller = new MainController;
  // $controller->page404();
  echo 'erreur';
} else {
  //list() permet de mettre les éléments d'un tableau dans des variables
  list($controllerName, $methodName) = explode('#', $match['target']);

  //$controllerName contient le nom de notre controller (une classe)
  $controller = new $controllerName;

  $controller->$methodName();
}
