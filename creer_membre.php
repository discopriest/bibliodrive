<?php
// UC8 : Créer un membre (admin uniquement)
require_once __DIR__ . '/includes/init.php';

if (!est_admin()) {
    header('Location: index.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mel = trim($_POST['mel']);
    $motdepasse = $_POST['motdepasse'];
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $adresse = trim($_POST['adresse']);
    $ville = trim($_POST['ville']);
    $codepostal = (int) $_POST['codepostal'];
    $profil = trim($_POST['profil']);

    // Mot de passe chiffré (voir cours PHP)
    $motdepasseHash = password_hash($motdepasse, PASSWORD_DEFAULT);

    $sql = 'INSERT INTO utilisateur (mel, motdepasse, nom, prenom, adresse, ville, codepostal, profil)
            VALUES (:mel, :motdepasse, :nom, :prenom, :adresse, :ville, :codepostal, :profil)';
    $requete = $pdo->prepare($sql);
    $requete->execute([
        ':mel' => $mel,
        ':motdepasse' => $motdepasseHash,
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':adresse' => $adresse,
        ':ville' => $ville,
        ':codepostal' => $codepostal,
        ':profil' => $profil
    ]);

    $message = 'Membre créé avec succès.';
}

include __DIR__ . '/includes/header.php';
?>

<h2 class="titre-section">Créer un membre</h2>

<?php if ($message !== '') : ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<form method="post">
    <div class="mb-3">
        <label for="mel" class="form-label">Email</label>
        <input type="email" id="mel" name="mel" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="motdepasse" class="form-label">Mot de passe</label>
        <input type="password" id="motdepasse" name="motdepasse" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" id="nom" name="nom" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="prenom" class="form-label">Prénom</label>
        <input type="text" id="prenom" name="prenom" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="adresse" class="form-label">Adresse</label>
        <input type="text" id="adresse" name="adresse" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="ville" class="form-label">Ville</label>
        <input type="text" id="ville" name="ville" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="codepostal" class="form-label">Code postal</label>
        <input type="number" id="codepostal" name="codepostal" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="profil" class="form-label">Profil</label>
        <select id="profil" name="profil" class="form-select" required>
            <option value="Membre">Membre</option>
            <option value="Administrateur">Administrateur</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Créer</button>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
