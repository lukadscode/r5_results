<?php
// Connexion à la base de données avec PDO
use App\Connection;

// Connexion à la base de données
$pdo = Connection::getPDO();
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Retourner des tableaux associatifs

$confirmationMessage = "";

if (isset($params['token']) && !empty($params['token'])) {
    $token = $params['token'];

    // Rechercher l'utilisateur correspondant au token
    $stmt = $pdo->prepare("SELECT id, email_verified FROM users WHERE confirmation_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        if ($user['email_verified']) {
            $confirmationMessage = "Votre email a déjà été confirmé.";
        } else {
            // Mettre à jour l'utilisateur pour marquer l'email comme vérifié
            $updateStmt = $pdo->prepare("UPDATE users SET email_verified = 1, confirmation_token = NULL WHERE id = ?");
            $updateStmt->execute([$user['id']]);
            $confirmationMessage = "Merci, votre email a été confirmé avec succès ! Vous pouvez maintenant vous connecter.";
        }
    } else {
        $confirmationMessage = "Ce lien de confirmation est invalide ou a déjà été utilisé.";
    }
} else {
    $confirmationMessage = "Aucun token de confirmation fourni.";
}
?>

<div class="container mt-5">
    <div class="alert <?= isset($user) && !$user['email_verified'] ? 'alert-success' : 'alert-danger' ?>">
        <?= htmlspecialchars($confirmationMessage) ?>
    </div>
    <a href="/login" class="btn btn-primary">Retour à la page de connexion</a>
</div>