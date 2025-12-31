<?php
// UC2 / UC4 : Détail d'un livre
require_once __DIR__ . '/includes/init.php';

$nolivre = isset($_GET['nolivre']) ? (int) $_GET['nolivre'] : 0;

$sql = 'SELECT livre.*, auteur.nom, auteur.prenom
        FROM livre
        INNER JOIN auteur ON livre.noauteur = auteur.noauteur
        WHERE livre.nolivre = :nolivre';
$requete = $pdo->prepare($sql);
$requete->execute([':nolivre' => $nolivre]);
$livre = $requete->fetch(PDO::FETCH_ASSOC);

// Vérifier la disponibilité (pas d'emprunt en cours)
$dispo = true;
if ($livre) {
    $reqEmprunt = $pdo->prepare('SELECT COUNT(*) FROM emprunter WHERE nolivre = :nolivre AND dateretour IS NULL');
    $reqEmprunt->execute([':nolivre' => $nolivre]);
    $emprunts = $reqEmprunt->fetchColumn();
    $dispo = ($emprunts == 0);
}

include __DIR__ . '/includes/header.php';
?>

<h2 class="titre-section">Détail du livre</h2>

<?php if (!$livre) : ?>
    <p>Livre introuvable.</p>
<?php else : ?>
    <p><strong>Auteur :</strong> <?php echo htmlspecialchars($livre['prenom'] . ' ' . $livre['nom']); ?></p>
    <p><strong>ISBN13 :</strong> <?php echo htmlspecialchars($livre['isbn13']); ?></p>
    <h4>Résumé du livre</h4>
    <p><?php echo nl2br(htmlspecialchars($livre['resume'])); ?></p>
    <p><strong>Date de parution :</strong> <?php echo htmlspecialchars($livre['anneeparution']); ?></p>

    <p class="<?php echo $dispo ? 'disponible' : 'indisponible'; ?>">
        <?php echo $dispo ? 'Disponible' : 'Indisponible'; ?>
    </p>

    <?php if (est_connecte()) : ?>
        <?php if ($dispo) : ?>
            <a class="btn btn-success" href="ajouter_panier.php?nolivre=<?php echo $livre['nolivre']; ?>">Emprunter (ajout au panier)</a>
        <?php else : ?>
            <p class="indisponible">Ce livre est déjà emprunté.</p>
        <?php endif; ?>
    <?php else : ?>
        <p class="indisponible">Pour pouvoir réserver vous devez posséder un compte et vous identifier.</p>
    <?php endif; ?>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
