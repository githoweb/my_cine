<div class="container my-4">
    <a href="<?= $router->generate('director-add') ?>" class="btn btn-success float-end">Retour</a>

    <h2><?= $title ?></h2>

    <form action="" method="POST" class="mt-5">
        <input type="hidden" name="tokenCsrf" value="<?= $tokenCsrf ?>">
        <?php 
            // Affichage des erreurs
            include __DIR__ . '/../partials/errors.tpl.php'
        ?>

        <?= $director->getDirectorId() ?>">

        <div class="mb-3">
            <label for="firstname" class="form-label">Titre</label>
            <input type="text" class="form-control" id="firstname" placeholder="Prénom de l'utilisateur"
                   name="firstname" value="<?= $director->getFirstname() ?>">
        </div>

        <div class="mb-3">
            <label for="lastname" class="form-label">Affiche</label>
            <input type="text" class="form-control" id="lastname" placeholder="Nom de l'utilisateur"
                   name="lastname" value="<?= $director->getLastname() ?>">
        </div>

        <div class="mb-3">
            <label for="poster" class="form-label">Photo du réalisateur</label>
            <input type="text" class="form-control" id="poster" placeholder="Photo du réalisateur"
                   name="poster" value="<?= $director->getPoster() ?>">
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Naissance</label>
            <input type="text" class="form-control" id="year" placeholder="year"
                   name="year" value="<?= $director->getBirth() ?>">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>

    </form>
</div>