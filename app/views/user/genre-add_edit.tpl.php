<div>
    <a href="<?= $router->generate('user-genres-list') ?>" class="btn btn-success">Retour</a>

    <h2><?= $title ?></h2>

    <form action="" method="POST">
        <input type="hidden" name="tokenCsrf" value="<?= $tokenCsrf ?>">
        <?php 
            // Affichage des erreurs
            include __DIR__ . '/../partials/errors.tpl.php'
        ?>

        <div>
            <label for="firstnamename">Nom</label>
            <input type="text" class="form-control" id="name" placeholder="Nom du genre"
                   name="name" value="<?= $genre->getName() ?>">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>

    </form>
</div>