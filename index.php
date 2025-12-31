<?php
// Page d'accueil (UC0)
require_once __DIR__ . '/includes/init.php';

// Récupération des 3 dernières acquisitions
$requete = $pdo->prepare('SELECT nolivre, titre, image FROM livre ORDER BY dateajout DESC LIMIT 3');
$requete->execute();
$dernieres = $requete->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/includes/header.php';
?>

<h2 class="titre-section">Dernières acquisitions</h2>

<?php if (count($dernieres) > 0) : ?>
    <div id="carouselDerniers" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach ($dernieres as $index => $livre) : ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <div class="d-flex justify-content-center">
                        <?php if (!empty($livre['image'])) : ?>
                            <img src="<?php echo htmlspecialchars($livre['image']); ?>" class="d-block" alt="<?php echo htmlspecialchars($livre['titre']); ?>" style="max-height: 300px;">
                        <?php else : ?>
                            <div class="border p-5">Image non disponible</div>
                        <?php endif; ?>
                    </div>
                    <p class="text-center mt-2">
                        <a href="livre_detail.php?nolivre=<?php echo $livre['nolivre']; ?>">
                            <?php echo htmlspecialchars($livre['titre']); ?>
                        </a>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselDerniers" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselDerniers" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    </div>
<?php else : ?>
    <p>Aucun livre pour le moment.</p>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
