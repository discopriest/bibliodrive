<?php
// En-tête commun à toutes les pages
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblio-Drive</title>
    <!-- Bootstrap (autorisé par la consigne) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="container mt-3">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="banniere">
                <p>La bibliothèque de Moulinsart est fermée au public jusqu’à nouvel ordre.
                    Mais il vous est possible de réserver et retirer vos livres via notre service Biblio Drive !</p>
            </div>
            <?php if (est_admin()) : ?>
                <div class="mt-2">
                    <a class="btn btn-outline-primary btn-sm" href="ajouter_livre.php">Ajouter un livre</a>
                    <a class="btn btn-outline-primary btn-sm" href="creer_membre.php">Créer un membre</a>
                </div>
            <?php endif; ?>
            <form class="d-flex mt-2" action="livres.php" method="get">
                <input class="form-control me-2" type="text" name="auteur" placeholder="Rechercher dans le catalogue (saisie du nom de l'auteur)">
                <button class="btn btn-primary" type="submit">🔍</button>
                <a class="btn btn-outline-secondary ms-2" href="panier.php">Panier</a>
            </form>
        </div>
        <div class="col-md-4 text-end">
            <img src="assets/moulinsart.svg" alt="Moulinsart" class="img-fluid banniere-image">
        </div>
    </div>
</header>
<main class="container mt-4">
    <div class="row">
        <div class="col-md-8">
