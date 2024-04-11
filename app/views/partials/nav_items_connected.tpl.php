<ul>
  <li>
    <a href="<?= $router->generate('movies-list') ?>" title="Films">Affichage Front Office</a>
  </li>
  <li>
    <a href="<?= $router->generate('users-list') ?>">Liste de Users</a>
  </li>
  <li>
    <a href="<?= $router->generate('user-movies-list') ?>">Liste de Films</a>
  </li>
  <li>
    <a href="<?= $router->generate('user-actors-list') ?>">Liste de Acteurs</a>
  </li>
  <li>
    <a href="<?= $router->generate('user-directors-list') ?>">Liste de Réalisateurs</a>
  </li>
  <li>
    <a href="<?= $router->generate('user-genres-list') ?>">Liste de Genres</a>
  </li>
</ul>


<div class="logged">
  Salut ! Tu es bien connecté !
  >> <a href="<?= $router->generate('logout') ?>">Déconnexion</a> <<
</div>
