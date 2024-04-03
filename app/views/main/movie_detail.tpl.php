<h1><?= $movie->getTitle() ?></h1>

<?php

$baseUrl = $router->generate('movies-list');
$url = $baseUrl . '?' . $queryString;
?>


<a href="<?= $url ?>" title="">Retour à la liste des films</a>

<br>
<a href="javascript:history.back()">Back to previous page</a>

<div class="card">

  <div class="card-poster">
    <img src="<?= $movie->getPoster() ?>" alt="" />
  </div>
  <div class="card-data">
    <h2 class="card-title"><?= $movie->getTitle() ?> (<?= $movie->getDate() ?>)</h2>
    <div class="card-item">
      <p><?= $movie->getSynopsis() ?></p>
    </div>
  </div>
</div>