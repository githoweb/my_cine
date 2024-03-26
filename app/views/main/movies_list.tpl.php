<h1>Liste de Films</h1>

<?php foreach ($movies as $movie) : ?>

  <div class="card">
    <div class="card-title"><?= $movie->getTitle() ?> (<?= $movie->getDate() ?>)</div>
    <div class="card-poster">
      <img src="<?= $movie->getPoster() ?>" alt="" />
    </div>
    <div class="card-data">      
      <div class="card-item">
        <p><?= $movie->getSynopsis() ?></p>
      </div>
    </div>
  </div>

<?php endforeach ?>