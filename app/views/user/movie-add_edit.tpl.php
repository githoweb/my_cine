<div class="container my-4">
    <a href="<?= $router->generate('user-list') ?>" class="btn btn-success float-end">Retour</a>

    <h2><?= $title ?></h2>

    <form action="" method="POST" class="mt-5">
        <input type="hidden" name="tokenCsrf" value="<?= $tokenCsrf ?>">
        <?php 
            // Affichage des erreurs
            include __DIR__ . '/../partials/errors.tpl.php'
        ?>

        <div class="mb-3">
            <label for="firstname" class="form-label">Titre</label>
            <input type="text" class="form-control" id="firstname" placeholder="Prénom de l'utilisateur"
                   name="firstname" value="<?= $user->getTitle() ?>">
        </div>

        <div class="mb-3">
            <label for="lastname" class="form-label">Affiche</label>
            <input type="text" class="form-control" id="lastname" placeholder="Nom de l'utilisateur"
                   name="lastname" value="<?= $user->getPoster() ?>">
        </div>

        <div class="mb-3">
            <label for="duration" class="form-label">Durée</label>
            <input type="text" class="form-control" id="duration" placeholder="Nom de l'utilisateur"
                   name="duration" value="<?= $user->getDuration() ?>">
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Date</label>
            <input type="text" class="form-control" id="year" placeholder="year"
                   name="year" value="<?= $user->getDate() ?>">
        </div>

        <div class="mb-3">
            <label for="genre_id" class="form-label">Genre</label>
            <input type="text" class="form-control" id="genre_id" placeholder="Nom de l'utilisateur"
                   name="genre_id" value="<?= $user->getGenreId() ?>">
        </div>

        <div class="mb-3">
            <label for="director_id" class="form-label">Réalisateur</label>
            <input type="text" class="form-control" id="director_id" placeholder="Nom de l'utilisateur"
                   name="director_id" value="<?= $user->getDirectorId() ?>">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>

    </form>
</div>