<?php

// Connexion à la base de données
$pdo = \App\Connection::getPDO();

// Vérification des données reçues du formulaire et existence du token
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'])) {
    // Récupération du token et des données du formulaire
    $token = $_POST['token'];
    $data = [
        'etablissement_id' => $_POST['etablissement_id'] ?? null,
        'nom_classe' => $_POST['nom_classe'] ?? null,
        'representant_nom' => $_POST['representant_nom'] ?? null,
        'representant_mail' => $_POST['representant_mail'] ?? null,
        'representant_tel' => $_POST['representant_tel'] ?? null,
        'club_id' => $_POST['club_id'] ?? null,
    ];

    // Validation des données (vous pouvez ajouter des vérifications supplémentaires ici)

    // Création de l'instance du modèle Classe
    $classeModel = new \App\Models\Classe($pdo);

    // Appel à la méthode pour mettre à jour une classe
    $success = $classeModel->updateClass($token, $data);

    if ($success) {
        // Redirection vers la page /classe/$token après la mise à jour réussie
        header("Location: /classe/{$token}");
        exit;
    } else {
        // Gestion des erreurs si la mise à jour échoue
        echo "Erreur lors de la mise à jour de la classe.";
        // Vous pouvez également logger l'erreur ou afficher un message plus détaillé
    }
} else {
    // Gestion d'une tentative d'accès direct à ce script sans POST ou sans token (non recommandé)
    echo "Accès non autorisé ou token de classe non spécifié.";
}
