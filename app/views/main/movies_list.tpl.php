<h1>Liste de Films</h1>
<?php echo('$_GET') ?>
<?php dump($_GET) ?>

<form method="get" action="<?= $router->generate('movies-listFiltered', $_GET) ?>">

  <select name="genre_id">
    <option selected=selected value="">Choisissez un genre</option>
    <?php $index = 1; ?>
    <?php foreach ($genres as $genre) : ?>
      <option value="<?= $index ?>"><?= $genre->getName(); ?></option>
      <?php $index++; ?>
    <?php endforeach; ?>
  </select>

  <select name="year">
    <option selected=selected value="">Choisissez une année</option>
    <?php for($i=1950; $i<2024; $i++) : ?>
      <option value="<?= $i ?>"><?= $i ?></option>
    <?php endfor; ?>
  </select>

  <select name="director_id">
    <option selected=selected value="">Choisissez un réalisateur</option>
    <?php $index = 1; ?>
    <?php foreach ($directors as $director) : ?>
      <option value="<?= $index ?>"><?= $director->getFirstname(); ?> <?= $director->getLastname(); ?></option>
      <?php $index++; ?>
    <?php endforeach; ?>
  </select>

  <select name="actor_id">
    <option selected=selected value="">Choisissez un acteur / une actrice</option>
    <?php $index = 1; ?>
    <?php foreach ($actors as $actor) : ?>
      <option value="<?= $index ?>"><?= $actor->getFirstname(); ?> <?= $actor->getLastname(); ?></option>
      <?php $index++; ?>
    <?php endforeach; ?>
  </select>

  

  <button type="submit">Valider</button>

</form>

<?php foreach ($movies as $movie) : ?>

  <?php  dump($movie);
  $genreId = isset($_GET['genre_id']) ? $_GET['genre_id'] : '';
  $year = isset($_GET['year']) ? $_GET['year'] : '';
  $directorId = isset($_GET['director_id']) ? $_GET['director_id'] : '';
  $actorId = isset($_GET['actor_id']) ? $_GET['actor_id'] : ''; 
  echo($genreId);

  ?>

  <div class="card">
    <div class="card-poster">
      <a href="<?= $router->generate('movie-detail', ['id' => $movie->getId()]) ?>" title=""><img src="<?= $movie->getPoster() ?>" alt="" /></a>
    </div>
    <div class="card-data">
      <h2 class="card-title"><?= $movie->getTitle() ?> (<?= $movie->getDate() ?>)</h2>
      <div class="card-item">
        <p><?= $movie->getSynopsis() ?></p>
      </div>
    </div>
  </div>

<?php endforeach ?>