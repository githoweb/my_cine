<h1>Liste d'acteurs</h1>

<?php foreach ($actors as $actor) : ?>

  <div class="card">
    <div class="card-title"><?= $actor->getFirstname() ?> <?= $actor->getLastname() ?></div>
    <div class="card-poster">
      <img src="<?= $actor->getPoster() ?>" alt="" />
    </div>
    <div class="card-data">      
      <div class="card-item">
        Naissance : <?= $actor->getBirth() ?>
      </div>
    </div>
  </div>

<?php endforeach ?>