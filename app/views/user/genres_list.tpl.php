<div>
    <a href="<?= $router->generate('genre-add') ?>" class="btn btn-success">Ajouter</a>
    <h2>Liste des Genres</h2>
    <table>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th>-</th>
            </tr>
        </thead>
        <tbody>

          <?php foreach($genres as $genre) : ?>

            <tr>
                <th scope="row"><?= $genre->getId() ?></th>
                <td><?= $genre->getName() ?></td>
                <td>
                    <a href="<?= $router->generate('genre-delete', ['id' => $genre->getId()]) ?>?tokenCsrf=<?= $tokenCsrf ?>">supprimer</a>
                </td>
            </tr>

          <?php endforeach ?>

        </tbody>
    </table>
</div>