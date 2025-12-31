<?php
// Suppression d'un livre du panier
require_once __DIR__ . '/includes/init.php';

if (!est_connecte()) {
    header('Location: index.php');
    exit;
}

$nolivre = isset($_GET['nolivre']) ? (int) $_GET['nolivre'] : 0;

if (isset($_SESSION['panier']) && $nolivre > 0) {
    $_SESSION['panier'] = array_values(array_filter($_SESSION['panier'], function ($id) use ($nolivre) {
        return $id !== $nolivre;
    }));
}

header('Location: panier.php');
exit;
