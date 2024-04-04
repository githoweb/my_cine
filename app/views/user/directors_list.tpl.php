<div class="container my-4">
    <a href="<?= $router->generate('user-add') ?>" class="btn btn-success float-end">Ajouter</a>
    <h2>Liste des Réalisateurs</h2>
    <table class="table table-hover mt-4">
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
                <td class="text-end">
                    <a href="" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    <div class="btn-group">
                        <button type="button"
                                class="btn btn-sm btn-danger dropdown-toggle"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= $router->generate('director-delete', ['id' => $director->getId()]) ?>?tokenCsrf=<?= $tokenCsrf ?>">supprimer</a>
                            <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                        </div>
                    </div>
                </td>
            </tr>

          <?php endforeach ?>

        </tbody>
    </table>
</div>