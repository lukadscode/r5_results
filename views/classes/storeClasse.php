<?php

// Connexion à la base de données
$pdo = \App\Connection::getPDO();

// Vérification des données reçues du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $data = [
        'etablissement_id' => $_POST['etablissement_id'] ?? null,
        'user_id' => $_POST['user_id'] ?? null,
        'nom_classe' => $_POST['nom_classe'] ?? null,
        'representant_nom' => $_POST['representant_nom'] ?? null,
        'representant_mail' => $_POST['representant_mail'] ?? null,
        'representant_tel' => $_POST['representant_tel'] ?? null,
        'club_id' => $_POST['club_id'] ?? null,
    ];

    // Validation des données (vous pouvez ajouter des vérifications supplémentaires ici)

    // Création de l'instance du modèle Classe
    $classeModel = new \App\Models\Classe($pdo);

    // Appel à la méthode pour créer une classe
    $success = $classeModel->createClass($data);

    if ($success) {
        // Récupération du token généré (si votre modèle Classe retourne le token)
        $token = $classeModel->getLastInsertedToken(); // À implémenter dans votre modèle

        // Redirection vers /classe/token
        header("Location: /classe/{$token}");
        exit;
    } else {
        // Gestion des erreurs si l'ajout échoue
        echo "Erreur lors de l'ajout de la classe.";
        // Vous pouvez également logger l'erreur ou afficher un message plus détaillé
    }
} else {
    // Gestion d'une tentative d'accès direct à ce script sans POST (non recommandé)
    echo "Accès non autorisé.";
}
