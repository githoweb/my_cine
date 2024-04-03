<nav>
  <ul>
    <li>
      <a href="<?= $router->generate('movies-list') ?>" title="Films">Films</a>
    </li>


    <li>
      <a href="<?= $router->generate('user-list') ?>">Liste de Users</a>
    </li>

    <li>
      <a href="<?= $router->generate('login') ?>" title="Administration">Administration</a>
    </li>
  </ul>
</nav>