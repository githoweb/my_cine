<h1>Liste de Films</h1>
<?php dump($_GET) ?>

<form method="post" action="<?= $router->generate('movies-listFiltered') ?>">

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

  <!-- <select name="movie_id">
    <option selected=selected>Choisissez un réalisateur</option>
      <?php /*foreach ($directors as $director) : ?>
      <option value="<?= $director->getId() ?>"><?= $director->getTitle() ?></option>
    <?php endforeach*/ ?>
  </select> -->

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
<?php  dump($movie) ?>

  <div class="card">

    <div class="card-poster">
      <a href="<?= $router->generate('movie-detail', ['id' => $movie->getId()] + $_GET); ?>" title=""><img src="<?= $movie->getPoster() ?>" alt="" /></a>
    </div>
    <div class="card-data">
      <h2 class="card-title"><?= $movie->getTitle() ?> (<?= $movie->getDate() ?>)</h2>
      <div class="card-item">
        <p><?= $movie->getSynopsis() ?></p>
      </div>
    </div>
  </div>

<?php endforeach ?>