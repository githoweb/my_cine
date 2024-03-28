<h1>Liste de réalisateurs</h1>

<?php foreach ($directors as $director) : ?>

  <div class="card">
    
    <div class="card-poster">
      <img src="<?= $director->getPoster() ?>" alt="" />
    </div>
    <div class="card-data">    
      <h2 class="card-title"><?= $director->getFirstname() ?> <?= $director->getLastname() ?></h2>  
      <div class="card-item">
        Naissance : <?= $director->getBirth() ?>
      </div>
      <p>
        <?= $director->getBiography() ?>
      </p>
    </div>
  </div>

<?php endforeach ?>