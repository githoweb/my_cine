<div>
    <a href="<?= $router->generate('user-movies-list') ?>" class="btn btn-success">Retour</a>

    <h2><?= $title ?></h2>

    <form action="" method="POST">
        <input type="hidden" name="tokenCsrf" value="<?= $tokenCsrf ?>">
        <?php
        // Affichage des erreurs
        include __DIR__ . '/../partials/errors.tpl.php'
        ?>

        <div>
            <label for="title">Titre</label>
            <input type="text" class="form-control" id="title" placeholder="Titre" name="title" value="<?= $movie->getTitle() ?>">
        </div>

        <div>
            <label for="poster">Affiche</label>
            <input type="text" class="form-control" id="poster" placeholder="Affiche" name="poster" value="<?= $movie->getPoster() ?>">
        </div>

        <div>
            <label for="duration">Durée</label>
            <input type="text" class="form-control" id="duration" placeholder="Durée" name="duration" value="<?= $movie->getDuration() ?>">
        </div>

        <div>
            <label for="year">Date</label>
            <input type="text" class="form-control" id="year" placeholder="year" name="year" value="<?= $movie->getDate() ?>">
        </div>

        <div>
            <label for="genre_id">Genre</label>
            <input type="text" class="form-control" id="genre_id" placeholder="Genre" name="genre_id" value="<?= $movie->getGenreId() ?>">
        </div>

        <div>
            <label for="director_id">Réalisateur</label>
            <input type="text" class="form-control" id="director_id" placeholder="Réalisateur" name="director_id" value="<?= $movie->getDirectorId() ?>">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>

    </form>
</div>