<div>
    <a href="<?= $router->generate('genre-add') ?>" class="btn btn-success">Ajouter</a>
    <h2>Liste des Genres</h2>

    <ul>
        <?php foreach ($genres as $genre) : ?>

            <li>
                #<?= $genre->getId() ?> :
                <?= $genre->getName() ?> => <a href="<?= $router->generate('genre-delete', ['id' => $genre->getId()]) ?>?tokenCsrf=<?= $tokenCsrf ?>">supprimer</a>
            </li>

        <?php endforeach ?>

</div>