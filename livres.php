<?php
// UC1 : Liste des livres d'un auteur
require_once __DIR__ . '/includes/init.php';

$auteur = isset($_GET['auteur']) ? trim($_GET['auteur']) : '';
$livres = [];

if ($auteur !== '') {
    $sql = 'SELECT livre.nolivre, livre.titre, livre.anneeparution, auteur.nom, auteur.prenom
            FROM livre
            INNER JOIN auteur ON livre.noauteur = auteur.noauteur
            WHERE auteur.nom LIKE :auteur
            ORDER BY livre.titre';
    $requete = $pdo->prepare($sql);
    $requete->execute([':auteur' => '%' . $auteur . '%']);
    $livres = $requete->fetchAll(PDO::FETCH_ASSOC);
}

include __DIR__ . '/includes/header.php';
?>

<h2 class="titre-section">Liste des livres d'un auteur</h2>

<?php if ($auteur === '') : ?>
    <p>Veuillez saisir un nom d'auteur dans la barre de recherche.</p>
<?php elseif (count($livres) === 0) : ?>
    <p>Aucun livre trouvé pour cet auteur.</p>
<?php else : ?>
    <ul class="liste-livres">
        <?php foreach ($livres as $livre) : ?>
            <li>
                <a href="livre_detail.php?nolivre=<?php echo $livre['nolivre']; ?>">
                    <?php echo htmlspecialchars($livre['titre']); ?> (<?php echo htmlspecialchars($livre['anneeparution']); ?>)
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
