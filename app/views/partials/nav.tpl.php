<nav>
  <ul>
    <li>
      <a href="<?= $router->generate('movies-list')/*, ['filters' =>[]]*/ ?>" title="Films">Films</a>
    </li>

    <li>
      <a href="<?= $router->generate('actors-list') ?>" title="Acteurs">Acteurs</a>
    </li>

    <li>
      <a href="<?= $router->generate('directors-list') ?>" title="Réalisateurs">Réalisateurs</a>
    </li>
    <li>
      <a href="<?= $router->generate('login') ?>" title="Administration">Administration</a>
    </li>
  </ul>
</nav>