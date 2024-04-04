<div>
    <a href="<?= $router->generate('user-directors-list') ?>" class="btn btn-success">Retour</a>

    <h2><?= $title ?></h2>

    <form action="" method="POST">
        <input type="hidden" name="tokenCsrf" value="<?= $tokenCsrf ?>">
        <?php 
            // Affichage des erreurs
            include __DIR__ . '/../partials/errors.tpl.php'
        ?>

        <?= $director->getId() ?>

        <div>
            <label for="firstname">Prénom</label>
            <input type="text" class="form-control" id="firstname" placeholder="Prénom"
                   name="firstname" value="<?= $director->getFirstname() ?>">
        </div>

        <div>
            <label for="lastname">Nom</label>
            <input type="text" class="form-control" id="lastname" placeholder="Nom"
                   name="lastname" value="<?= $director->getLastname() ?>">
        </div>

        <div>
            <label for="poster">Photo</label>
            <input type="text" class="form-control" id="poster" placeholder="Photo"
                   name="poster" value="<?= $director->getPoster() ?>">
        </div>

        <div>
            <label for="year">Naissance</label>
            <input type="text" class="form-control" id="year" placeholder="Année de naissance"
                   name="year" value="<?= $director->getBirth() ?>">
        </div>

        <div>
            <label for="biography">Biographie</label>
            <input type="text" class="form-control" id="biography" placeholder="Biographie"
                   name="biography" value="<?= $director->getBiography() ?>">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>

    </form>
</div>