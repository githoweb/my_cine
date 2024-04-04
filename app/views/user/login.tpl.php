<div class="container my-4">

    <h2>Formulaire de connexion</h2>

    <form action="" method="POST" class="mt-5">

        <?php
        // Pour afficher les messages d'erreurs éventuels.
        include __DIR__ . '/../partials/errors.tpl.php';
        ?>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input name="email" value="<?= $userEmail ?>" type="text" class="form-control" id="email" placeholder="Entrez ici votre adresse mail" aria-describedby="emailHelpBlock">
            <small id="emailHelpBlock" class="form-text text-muted">
                mettez ici une adresse mail valide
            </small>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input name="password" type="password" class="form-control" id="password" placeholder="Entrez ici votre password" aria-describedby="passwordHelpBlock">
            <small id="passwordHelpBlock" class="form-text text-muted">
                Entrez votre password
            </small>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary mt-5">Se connecter</button>
        </div>

    </form>
</div>