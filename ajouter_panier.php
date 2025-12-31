<?php
// Ajout d'un livre dans le panier (stocké en session)
require_once __DIR__ . '/includes/init.php';

if (!est_connecte()) {
    header('Location: index.php');
    exit;
}

$nolivre = isset($_GET['nolivre']) ? (int) $_GET['nolivre'] : 0;

if ($nolivre > 0) {
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    // On évite les doublons
    if (!in_array($nolivre, $_SESSION['panier'], true)) {
        $_SESSION['panier'][] = $nolivre;
    }
}

header('Location: panier.php');
exit;
