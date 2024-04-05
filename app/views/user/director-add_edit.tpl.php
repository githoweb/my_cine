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

        <div class="formItem">
            <label for="firstname">Prénom</label>
            <input type="text" id="firstname" placeholder="Prénom"
                   name="firstname" value="<?= $director->getFirstname() ?>">
        </div>

        <div class="formItem">
            <label for="lastname">Nom</label>
            <input type="text" id="lastname" placeholder="Nom"
                   name="lastname" value="<?= $director->getLastname() ?>">
        </div>

        <div class="formItem">
            <label for="poster">Photo</label>
            <input type="text" id="poster" placeholder="Photo"
                   name="poster" value="<?= $director->getPoster() ?>">
        </div>

        <div class="formItem">
            <label for="year">Naissance</label>
            <input type="text" id="year" placeholder="Année de naissance"
                   name="year" value="<?= $director->getBirth() ?>">
        </div>

        <div class="formItem">
            <label for="biography">Biographie</label>
            <input type="text" id="biography" placeholder="Biographie"
                   name="biography" value="<?= $director->getBiography() ?>">
        </div>

        <div class="action">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>

    </form>
</div>