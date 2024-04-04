<div class="container my-4">
    <a href="<?= $router->generate('user-genres-list') ?>" class="btn btn-success float-end">Retour</a>

    <h2><?= $title ?></h2>

    <form action="" method="POST" class="mt-5">
        <input type="hidden" name="tokenCsrf" value="<?= $tokenCsrf ?>">
        <?php 
            // Affichage des erreurs
            include __DIR__ . '/../partials/errors.tpl.php'
        ?>

        <div class="mb-3">
            <label for="firstnamename" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" placeholder="Nom du genre"
                   name="name" value="<?= $genre->getName() ?>">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>

    </form>
</div>