<?php
// Traitement de la connexion
require_once __DIR__ . '/includes/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mel = isset($_POST['mel']) ? trim($_POST['mel']) : '';
    $motdepasse = isset($_POST['motdepasse']) ? $_POST['motdepasse'] : '';

    $sql = 'SELECT * FROM utilisateur WHERE mel = :mel';
    $requete = $pdo->prepare($sql);
    $requete->execute([':mel' => $mel]);
    $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);

    if ($utilisateur && password_verify($motdepasse, $utilisateur['motdepasse'])) {
        // On stocke quelques infos en session
        $_SESSION['utilisateur'] = [
            'mel' => $utilisateur['mel'],
            'nom' => $utilisateur['nom'],
            'prenom' => $utilisateur['prenom'],
            'adresse' => $utilisateur['adresse'],
            'ville' => $utilisateur['ville'],
            'codepostal' => $utilisateur['codepostal'],
            'profil' => $utilisateur['profil']
        ];
    }
}

// Retour à la page précédente
header('Location: index.php');
exit;
