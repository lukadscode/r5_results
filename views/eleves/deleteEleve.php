<?php


use App\Models\Eleve;

// Connexion à la base de données
$pdo = \App\Connection::getPDO();

// Vérification des données reçues du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eleve_id'])) {
    $eleveId = $_POST['eleve_id'];

    // Création de l'instance de modèle Eleve avec la connexion PDO valide
    $eleveModel = new Eleve($pdo); // Assurez-vous que $pdo est bien défini et non null

    // Appel à la méthode pour supprimer l'élève par son ID
    $success = $eleveModel->deleteEleveById($eleveId);

    $token = $params['token'];
    // Après la suppression, vous pouvez rediriger vers une autre page ou actualiser la page actuelle
    if ($success) {
        header("Location: /classe/{$_POST['classe_token']}"); // Redirection vers la page des élèves après suppression
        exit;
    } else {
        echo "Erreur lors de la suppression de l'élève.";
        // Gestion d'une situation d'erreur
    }
} else {
    // Gestion d'une tentative d'accès direct à ce script sans POST (non recommandé)
    echo "Accès non autorisé.";
}
