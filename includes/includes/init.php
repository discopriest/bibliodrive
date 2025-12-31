<?php
// Démarrage de la session
session_start();

// Connexion à la base
require_once __DIR__ . '/../config.php';

// Fonctions simples pour l'authentification
function est_connecte()
{
    return isset($_SESSION['utilisateur']);
}

function est_admin()
{
    return est_connecte() && $_SESSION['utilisateur']['profil'] === 'Administrateur';
}
