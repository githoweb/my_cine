<div class="container my-4">
    <a href="<?= $router->generate('user-movies-list') ?>" class="btn btn-success float-end">Retour</a>

    <h2><?= $title ?></h2>

    <form action="" method="POST" class="mt-5">
        <input type="hidden" name="tokenCsrf" value="<?= $tokenCsrf ?>">
        <?php
        // Affichage des erreurs
        include __DIR__ . '/../partials/errors.tpl.php'
        ?>

        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" placeholder="Titre" name="title" value="<?= $movie->getTitle() ?>">
        </div>

        <div class="mb-3">
            <label for="poster" class="form-label">Affiche</label>
            <input type="text" class="form-control" id="poster" placeholder="Affiche" name="poster" value="<?= $movie->getPoster() ?>">
        </div>

        <div class="mb-3">
            <label for="duration" class="form-label">Durée</label>
            <input type="text" class="form-control" id="duration" placeholder="Durée" name="duration" value="<?= $movie->getDuration() ?>">
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Date</label>
            <input type="text" class="form-control" id="year" placeholder="year" name="year" value="<?= $movie->getDate() ?>">
        </div>

        <div class="mb-3">
            <label for="genre_id" class="form-label">Genre</label>
            <input type="text" class="form-control" id="genre_id" placeholder="Genre" name="genre_id" value="<?= $movie->getGenreId() ?>">
        </div>

        <div class="mb-3">
            <label for="director_id" class="form-label">Réalisateur</label>
            <input type="text" class="form-control" id="director_id" placeholder="Réalisateur" name="director_id" value="<?= $movie->getDirectorId() ?>">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>

    </form>
</div>