<?php
// Validation du panier : insertion dans la table emprunter
require_once __DIR__ . '/includes/init.php';

if (!est_connecte()) {
    header('Location: index.php');
    exit;
}

$panier = isset($_SESSION['panier']) ? $_SESSION['panier'] : [];

if (count($panier) > 0) {
    $date = date('Y-m-d');
    $sql = 'INSERT INTO emprunter (mel, nolivre, dateemprunt, dateretour)
            VALUES (:mel, :nolivre, :dateemprunt, NULL)';
    $requete = $pdo->prepare($sql);

    foreach ($panier as $nolivre) {
        $requete->execute([
            ':mel' => $_SESSION['utilisateur']['mel'],
            ':nolivre' => $nolivre,
            ':dateemprunt' => $date
        ]);
    }

    // On vide le panier après validation
    $_SESSION['panier'] = [];
}

header('Location: panier.php');
exit;
