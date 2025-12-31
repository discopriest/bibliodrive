<?php
// Bloc de droite : connexion ou infos membre
?>
<aside class="col-md-4">
    <div class="p-3 border rounded bg-light">
        <?php if (!est_connecte()) : ?>
            <h5 class="text-center">Se connecter</h5>
            <form action="connexion.php" method="post">
                <div class="mb-2">
                    <label for="mel" class="form-label">Identifiant</label>
                    <input type="email" id="mel" name="mel" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label for="motdepasse" class="form-label">Mot de passe</label>
                    <input type="password" id="motdepasse" name="motdepasse" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Connexion</button>
            </form>
        <?php else : ?>
            <h5 class="text-center">Membre connecté</h5>
            <p class="mb-1"><strong><?php echo htmlspecialchars($_SESSION['utilisateur']['prenom'] . ' ' . $_SESSION['utilisateur']['nom']); ?></strong></p>
            <p class="mb-1"><?php echo htmlspecialchars($_SESSION['utilisateur']['mel']); ?></p>
            <p class="mb-1"><?php echo htmlspecialchars($_SESSION['utilisateur']['adresse']); ?></p>
            <p class="mb-3"><?php echo htmlspecialchars($_SESSION['utilisateur']['codepostal'] . ' ' . $_SESSION['utilisateur']['ville']); ?></p>
            <a class="btn btn-secondary w-100" href="deconnexion.php">Se déconnecter</a>
        <?php endif; ?>
    </div>
</aside>
