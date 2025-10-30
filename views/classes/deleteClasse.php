<?php

use App\Models\Classe;

// Connexion à la base de données
$pdo = \App\Connection::getPDO();

// Vérification des données reçues de la requête GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($params['classe_id'])) {
    $classeId = $params['classe_id'];

    // Création de l'instance de modèle Classe avec la connexion PDO
    $classeModel = new Classe($pdo);

    // Appel à la méthode pour supprimer la classe par son ID
    $success = $classeModel->deleteClass($classeId);

    // Redirection après la suppression
    if ($success) {
        header("Location: /"); // Redirection vers la page d'accueil après suppression
        exit;
    } else {
        echo "Erreur lors de la suppression de la classe.";
        // Gestion d'une situation d'erreur
    }
} else {
    // Gestion d'une tentative d'accès direct à ce script sans les bons paramètres
    echo "Accès non autorisé.";
}
