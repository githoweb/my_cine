<div class="container my-4">
    <a href="<?= $router->generate('user-actors-list') ?>" class="btn btn-success float-end">Retour</a>

    <h2><?= $title ?></h2>

    <form action="" method="POST" class="mt-5">
        <input type="hidden" name="tokenCsrf" value="<?= $tokenCsrf ?>">
        <?php 
            // Affichage des erreurs
            include __DIR__ . '/../partials/errors.tpl.php'
        ?>

        <?= $actor->getId() ?>">

        <div class="mb-3">
            <label for="firstname" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="firstname" placeholder="Prénom"
                   name="firstname" value="<?= $actor->getFirstname() ?>">
        </div>

        <div class="mb-3">
            <label for="lastname" class="form-label">Nom</label>
            <input type="text" class="form-control" id="lastname" placeholder="Nom"
                   name="lastname" value="<?= $actor->getLastname() ?>">
        </div>

        <div class="mb-3">
            <label for="poster" class="form-label">Photo</label>
            <input type="text" class="form-control" id="poster" placeholder="Photo"
                   name="poster" value="<?= $actor->getPoster() ?>">
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Naissance</label>
            <input type="text" class="form-control" id="year" placeholder="Année de naissance"
                   name="year" value="<?= $actor->getBirth() ?>">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>

    </form>
</div>