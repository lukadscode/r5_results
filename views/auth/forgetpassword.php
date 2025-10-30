<?php

// Connexion à la base de données avec PDO
use App\Connection;

// Connexion à la base de données
$pdo = Connection::getPDO();
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Retourne des tableaux associatifs

require_once '../views/helpers.php';

$resetPasswordErrors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $email = trim($_POST['email'] ?? ''); // Supprime les espaces inutiles

    // Validation de l'email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $resetPasswordErrors['email'] = "Veuillez entrer une adresse e-mail valide.";
    }

    if (empty($resetPasswordErrors)) {
        // Vérifiez si l'adresse e-mail existe
        $stmt = $pdo->prepare("SELECT id, email FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            try {
                // Générer un token de réinitialisation
                $resetToken = bin2hex(random_bytes(16)); // Token unique
                $stmt = $pdo->prepare("UPDATE users SET reset_token = :reset_token, reset_at = NOW() WHERE id = :id");
                $stmt->execute(['reset_token' => $resetToken, 'id' => $user['id']]);

                // Envoi de l'email avec le lien de réinitialisation
                $resetLink = "http://localhost:8080/reset-password?token=" . $resetToken;
                $subject = "Réinitialisation de votre mot de passe";
                $message = "
                <html>
                <body>
                    <p>Bonjour,</p>
                    <p>Vous avez demandé à réinitialiser votre mot de passe. Cliquez sur le lien ci-dessous pour créer un nouveau mot de passe :</p>
                    <p><a href='$resetLink'>Réinitialiser mon mot de passe</a></p>
                    <p>Si vous n'êtes pas à l'origine de cette demande, ignorez cet email.</p>
                </body>
                </html>
                ";

                // Exemple d'envoi d'email
                Envoiemail($user['email'], "Utilisateur", $subject, $message);

                // Redirection ou affichage d'un message de confirmation
                header('Location: /login');
                exit();
            } catch (PDOException $e) {
                $resetPasswordErrors['global'] = "Une erreur est survenue. Veuillez réessayer plus tard.";
            }
        } else {
            $resetPasswordErrors['email'] = "Aucun utilisateur trouvé avec cette adresse e-mail.";
        }
    }
}
?>

<!-- Formulaire de réinitialisation -->
<form action="" method="post">
    <!-- Affichage des erreurs globales -->
    <?php if (!empty($resetPasswordErrors['global'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($resetPasswordErrors['global']) ?>
        </div>
    <?php endif; ?>

    <div class="form-floating mb-3">
        <input
            type="email"
            class="form-control <?php echo isset($resetPasswordErrors['email']) ? 'is-invalid' : ''; ?>"
            id="floatingEmail"
            name="email"
            placeholder="Adresse e-mail"
            value="<?= htmlspecialchars($email ?? '', ENT_QUOTES) ?>"
            required>
        <label for="floatingEmail">Adresse e-mail</label>
        <?php if (isset($resetPasswordErrors['email'])): ?>
            <div class="invalid-feedback">
                <?= htmlspecialchars($resetPasswordErrors['email']) ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="d-grid">
        <button class="btn btn-success text-uppercase" style="color: white; font-weight: bold;" type="submit" name="reset_password">Envoyer le lien de réinitialisation</button>
    </div>
</form>