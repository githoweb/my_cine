<div>
    <a href="<?= $router->generate('actor-add') ?>" class="btn btn-success">Ajouter</a>
    <h2>Liste des Acteurs</h2>
    <table>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Prénom</th>
                <th scope="col">Nom</th>
                <th scope="col">Photo</th>
                <th scope="col">Naissance</th>
                <th scope="col">Biographie</th>
                <th>-</th>
            </tr>
        </thead>
        <tbody>

          <?php foreach($actors as $actor) : ?>

            <tr>
                <th scope="row"><?= $actor->getId() ?></th>
                <td><?= $actor->getFirstName() ?></td>
                <td><?= $actor->getLastName() ?></td>
                <td><img src="https://media.themoviedb.org/t/p/w300_and_h450_bestv2/<?= $actor->getPoster() ?>" width=100 /></td>
                <td><?= $actor->getBirth() ?></td>
                <td><?= $actor->getBiography() ?></td>
                <td>
                    <a href="<?= $router->generate('actor-delete', ['id' => $actor->getId()]) ?>?tokenCsrf=<?= $tokenCsrf ?>">supprimer</a>
                </td>
            </tr>

          <?php endforeach ?>

        </tbody>
    </table>
</div>