<h1>Liste de réalisateurs</h1>

<?php foreach ($directors as $director) : ?>

  <div class="card">
    <div class="card-title"><?= $director->getFirstname() ?> <?= $director->getLastname() ?></div>
    <div class="card-poster">
      <img src="<?= $director->getPoster() ?>" alt="" />
    </div>
    <div class="card-data">      
      <div class="card-item">
        Naissance : <?= $director->getBirth() ?>
      </div>
    </div>
  </div>

<?php endforeach ?>