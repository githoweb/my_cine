<div>
    <a href="<?= $router->generate('director-add') ?>" class="btn btn-success">Ajouter</a>
    <h2>Liste des Réalisateurs</h2>

    <div class="personsList">

        <?php foreach($directors as $director) : ?>

        <figure>
            <img src="https://media.themoviedb.org/t/p/w300_and_h450_bestv2/<?= $director->getPoster() ?>" alt="" />
            <p><?= $director->getFirstname() ?> <?= $director->getLastname() ?></p>
            #<?= $director->getId() ?>
            <a href="<?= $router->generate('director-delete', ['id' => $director->getId()]) ?>?tokenCsrf=<?= $tokenCsrf ?>">supprimer</a>
        </figure>

        <?php endforeach ?>

    </div>
</div>