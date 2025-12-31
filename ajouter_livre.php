<?php
// UC7 : Ajouter un livre (admin uniquement)
require_once __DIR__ . '/includes/init.php';

if (!est_admin()) {
    header('Location: index.php');
    exit;
}

$message = '';

// Liste des auteurs pour le menu déroulant
$reqAuteurs = $pdo->prepare('SELECT noauteur, nom, prenom FROM auteur ORDER BY nom');
$reqAuteurs->execute();
$auteurs = $reqAuteurs->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $noauteur = (int) $_POST['noauteur'];
    $titre = trim($_POST['titre']);
    $isbn13 = trim($_POST['isbn13']);
    $anneeparution = (int) $_POST['anneeparution'];
    $resume = trim($_POST['resume']);
    $image = trim($_POST['image']);
    $dateajout = date('Y-m-d');

    $sql = 'INSERT INTO livre (noauteur, titre, isbn13, anneeparution, resume, dateajout, image)
            VALUES (:noauteur, :titre, :isbn13, :anneeparution, :resume, :dateajout, :image)';
    $requete = $pdo->prepare($sql);
    $requete->execute([
        ':noauteur' => $noauteur,
        ':titre' => $titre,
        ':isbn13' => $isbn13,
        ':anneeparution' => $anneeparution,
        ':resume' => $resume,
        ':dateajout' => $dateajout,
        ':image' => $image
    ]);

    $message = 'Livre ajouté avec succès.';
}

include __DIR__ . '/includes/header.php';
?>

<h2 class="titre-section">Ajouter un livre</h2>

<?php if ($message !== '') : ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<form method="post">
    <div class="mb-3">
        <label for="noauteur" class="form-label">Auteur</label>
        <select id="noauteur" name="noauteur" class="form-select" required>
            <?php foreach ($auteurs as $auteur) : ?>
                <option value="<?php echo $auteur['noauteur']; ?>">
                    <?php echo htmlspecialchars($auteur['prenom'] . ' ' . $auteur['nom']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="titre" class="form-label">Titre</label>
        <input type="text" id="titre" name="titre" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="isbn13" class="form-label">ISBN13</label>
        <input type="text" id="isbn13" name="isbn13" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="anneeparution" class="form-label">Année de parution</label>
        <input type="number" id="anneeparution" name="anneeparution" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="resume" class="form-label">Résumé</label>
        <textarea id="resume" name="resume" class="form-control" rows="4" required></textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">URL de l'image</label>
        <input type="text" id="image" name="image" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Ajouter</button>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
