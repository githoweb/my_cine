<div class="container my-4">
    <a href="<?= $router->generate('user-add') ?>" class="btn btn-success float-end">Ajouter</a>
    <h2>Liste des utilisateurs</h2>
    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Prénom</th>
                <th scope="col">Nom</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>

          <?php foreach($users as $user) : ?>

            <tr>
                <th scope="row"><?= $user->getId() ?></th>
                <td><?= $user->getFirstName() ?></td>
                <td><?= $user->getLastName() ?></td>
                <td><?= $user->getEmail() ?></td>
                <td><span class="badge bg-danger"><?= $user->getRole() ?></span></td>
                <td><span class="badge bg-success"><?= $user->getStatus() === '1' ? "Actif" : "Désactivé" ?></span></td>
                <td class="text-end">
                    <a href="" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    </a>
                    <!-- Example single danger button -->
                    <div class="btn-group">
                        <button type="button"
                                class="btn btn-sm btn-danger dropdown-toggle"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Oui, je veux supprimer</a>
                            <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                        </div>
                    </div>
                </td>
            </tr>

          <?php endforeach ?>

        </tbody>
    </table>
</div>