<nav>
  <ul>
    <li>
      <a href="<?= $router->generate('movies-list') ?>" title="Films">Films</a>
    </li>


    <li>
      <a href="<?= $router->generate('user-list') ?>">Liste de Users</a>
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

    <li>
      <a href="<?= $router->generate('login') ?>" title="Administration">Administration</a>
    </li>
  </ul>
</nav>