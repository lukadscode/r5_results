<?php

use App\Models\Eleve;
use App\Connection;

// Vérification des données reçues du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $data = [
        'classe_id' => $_POST['classe_id'] ?? null,
        'epreuve' => $_POST['epreuve'] ?? null,
        'saison_id' => $_POST['saison_id'] ?? null,
        'nom' => $_POST['nom'] ?? null,
        'prenom' => $_POST['prenom'] ?? null,
        'sexe' => $_POST['sexe'] ?? null,
        'annee_naissance' => $_POST['annee_naissance'] ?? null,
        'distance' => $_POST['distance'] ?? null,
    ];

    // Validation des données (vous pouvez ajouter des vérifications supplémentaires ici)

    // Connexion à la base de données
    $pdo = Connection::getPDO(); // Assurez-vous d'utiliser correctement votre classe de connexion

    // Création de l'instance du modèle Eleve
    $eleveModel = new Eleve($pdo);

    // Appel à la méthode pour ajouter un élève
    $success = $eleveModel->addEleve($data);

    if ($success) {
        // Redirection après l'ajout réussi
        header("Location: /classe/{$_POST['classe_token']}");
        exit;
    } else {
        // Gestion des erreurs si l'ajout échoue
        echo "Erreur lors de l'ajout de l'élève.";
        // Vous pouvez également logger l'erreur ou afficher un message plus détaillé
    }
} else {
    // Gestion d'une tentative d'accès direct à ce script sans POST ou sans classe_token (non recommandé)
    echo "Accès non autorisé ou token de classe non spécifié.";
}
