<div>
    <a href="<?= $router->generate('director-add') ?>" class="btn btn-success">Ajouter</a>
    <h2>Liste des Réalisateurs</h2>
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

          <?php foreach($directors as $director) : ?>

            <tr>
                <th scope="row"><?= $director->getId() ?></th>
                <td><?= $director->getFirstName() ?></td>
                <td><?= $director->getLastName() ?></td>
                <td><img src="https://media.themoviedb.org/t/p/w300_and_h450_bestv2/<?= $director->getPoster() ?>" width=100 /></td>
                <td><?= $director->getBirth() ?></td>
                <td><?= $director->getBiography() ?></td>
                <td>
                    <a href="<?= $router->generate('director-delete', ['id' => $director->getId()]) ?>?tokenCsrf=<?= $tokenCsrf ?>">supprimer</a>
                </td>
            </tr>

          <?php endforeach ?>

        </tbody>
    </table>
</div>