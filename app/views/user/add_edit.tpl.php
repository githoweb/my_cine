<div>
    <a href="<?= $router->generate('user-list') ?>" class="btn btn-success">Retour</a>

    <h2><?= $title ?></h2>

    <form action="" method="POST">
        <input type="hidden" name="tokenCsrf" value="<?= $tokenCsrf ?>">
        <?php 
            // Affichage des erreurs
            include __DIR__ . '/../partials/errors.tpl.php'
        ?>

        <div>
            <label for="firstname">Prénom</label>
            <input type="text" class="form-control" id="firstname" placeholder="Prénom de l'utilisateur"
                   name="firstname" value="<?= $user->getFirstName() ?>">
        </div>

        <div>
            <label for="lastname">Nom</label>
            <input type="text" class="form-control" id="lastname" placeholder="Nom de l'utilisateur"
                   name="lastname" value="<?= $user->getLastName() ?>">
        </div>

        <div>
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" placeholder="Adresse mail de l'utilisateur"
                   name="email" value="<?= $user->getEmail() ?>">
        </div>

        <div>
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" id="password" placeholder="Mot de passe de l'utilisateur"
                   name="password" value="">
        </div>

        <div>
            <label for="category">Role de l'utilisateur</label>
            <select name="role"
                class="form-control" id="role" aria-describedby="roleHelpBlock">
                <option value="admin"<?= $user->getRole() === "admin" ? " selected" : "" ?>>Admin</option>
                <option value="catalog-manager"<?= $user->getRole() == "catalog-manager" ? " selected" : "" ?>>Gestionnaire de catalogue</option>
            </select>
            <small id="categoryHelpBlock" class="form-text text-muted">
                Le role de l'utilisateur
            </small>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Valider</button>
        </div>

    </form>
</div>