<?php
// UC5 : Voir panier
require_once __DIR__ . '/includes/init.php';

if (!est_connecte()) {
    header('Location: index.php');
    exit;
}

$panier = isset($_SESSION['panier']) ? $_SESSION['panier'] : [];
$livres = [];

if (count($panier) > 0) {
    // Création des paramètres pour la requête IN
    $placeholders = implode(',', array_fill(0, count($panier), '?'));
    $sql = 'SELECT livre.nolivre, livre.titre, auteur.nom, auteur.prenom, livre.anneeparution
            FROM livre
            INNER JOIN auteur ON livre.noauteur = auteur.noauteur
            WHERE livre.nolivre IN (' . $placeholders . ')';
    $requete = $pdo->prepare($sql);
    $requete->execute($panier);
    $livres = $requete->fetchAll(PDO::FETCH_ASSOC);
}

// Nombre d'emprunts en cours pour ce membre
$reqCount = $pdo->prepare('SELECT COUNT(*) FROM emprunter WHERE mel = :mel AND dateretour IS NULL');
$reqCount->execute([':mel' => $_SESSION['utilisateur']['mel']]);
$empruntsEnCours = (int) $reqCount->fetchColumn();

$restePossible = 5 - ($empruntsEnCours + count($panier));

include __DIR__ . '/includes/header.php';
?>

<h2 class="titre-section">Votre panier</h2>
<p class="text-center">(encore <?php echo $restePossible; ?> réservation(s) possible(s), <?php echo $empruntsEnCours; ?> emprunt(s) en cours)</p>

<?php if (count($livres) === 0) : ?>
    <p>Votre panier est vide.</p>
<?php else : ?>
    <ul class="list-unstyled">
        <?php foreach ($livres as $livre) : ?>
            <li class="mb-2">
                <?php echo htmlspecialchars($livre['prenom'] . ' ' . $livre['nom']); ?> -
                <?php echo htmlspecialchars($livre['titre']); ?> (<?php echo htmlspecialchars($livre['anneeparution']); ?>)
                <a class="btn btn-outline-danger btn-sm ms-2" href="retirer_panier.php?nolivre=<?php echo $livre['nolivre']; ?>">Annuler</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php if ($restePossible >= 0) : ?>
        <a class="btn btn-success" href="valider_panier.php">Valider le panier</a>
    <?php else : ?>
        <p class="indisponible">Limite de 5 emprunts atteinte. Retirez un livre du panier.</p>
    <?php endif; ?>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
