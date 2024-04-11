<div>
    <a href="<?= $router->generate('user-genres-list') ?>" class="btn btn-success">Retour</a>

    <h2><?= $title ?></h2>

    <form action="" method="POST">
        <?php 
            include __DIR__ . '/../partials/csrf.tpl.php';
            // Affichage des erreurs
            include __DIR__ . '/../partials/errors.tpl.php'
        ?>

        <div class="formItem">
            <label for="firstnamename">Nom</label>
            <input type="text" id="name" placeholder="Nom du genre"
                   name="name" value="<?= $genre->getName() ?>">
        </div>

        <div class="action">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>

    </form>
</div>