<div>
    <a href="<?= $router->generate('movie-add') ?>" class="btn btn-success">Ajouter</a>
    <h2>Liste des Films</h2>
    
    <div class="personsList">

        <?php foreach($movies as $movie) : ?>

        <figure>
            <img src="https://media.themoviedb.org/t/p/w300_and_h450_bestv2/<?= $movie->getPoster() ?>" alt="" />
            <p><?= $movie->getTitle() ?></p>
            #<?= $movie->getId() ?>
            <a href="<?= $router->generate('movie-delete', ['id' => $movie->getId()]) ?>?tokenCsrf=<?= $tokenCsrf ?>">supprimer</a>
        </figure>

        <?php endforeach ?>

    </div>

    <table>
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
                <td>
                    <a href="<?= $router->generate('movie-delete', ['id' => $movie->getId()]) ?>?tokenCsrf=<?= $tokenCsrf ?>">supprimer</a>
                </td>
            </tr>

          <?php endforeach ?>

        </tbody>
    </table>
</div>