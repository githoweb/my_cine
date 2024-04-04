<div class="container my-4">
    <a href="<?= $router->generate('user-movie-add') ?>" class="btn btn-success float-end">Ajouter</a>
    <h2>Liste des Films</h2>
    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Titre</th>
                <th scope="col">Affiche</th>
                <th scope="col">-</th>
            </tr>
        </thead>
        <tbody>

          <?php foreach($movies as $movie) : ?>

            <tr>
                <th scope="row"><?= $movie->getId() ?></th>
                <td><?= $movie->getTitle() ?></td>
                <td><img src="https://media.themoviedb.org/t/p/w300_and_h450_bestv2/<?= $movie->getPoster() ?>" width=100 /></td>
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
                            <a class="dropdown-item" href="<?= $router->generate('movie-delete', ['id' => $movie->getId()]) ?>?tokenCsrf=<?= $tokenCsrf ?>">supprimer</a>
                            <a class="dropdown-item" href="#" data-toggle="dropdown">Oups !</a>
                        </div>
                    </div>
                </td>
            </tr>

          <?php endforeach ?>

        </tbody>
    </table>
</div>