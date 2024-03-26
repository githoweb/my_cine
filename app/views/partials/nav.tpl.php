<nav>
  <ul>
    <li>
      <a href="<?= $router->generate('movies-list') ?>" title="Films">Films</a>
    </li>

    <li>
      <a href="<?= $router->generate('actors-list') ?>" title="Acteurs">Acteurs</a>
    </li>

    <li>
      <a href="<?= $router->generate('directors-list') ?>" title="Réalisateurs">Réalisateurs</a>
    </li>
  </ul>
</nav>