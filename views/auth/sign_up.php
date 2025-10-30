<?php
// Connexion à la base de données avec PDO
use App\Connection;

// Connexion à la base de données
$pdo = Connection::getPDO();

use App\Models\Etablissement;
use App\Models\Club;

require_once '../views/helpers.php';

$etablissementModel = new Etablissement($pdo);
$clubModel = new Club($pdo);

$etablissements = $etablissementModel->getAllColleges();
$clubs = $clubModel->getAllClubs();

$signupErrors = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnmodifform'])) {
  // Récupérer et valider les données du formulaire
  $nom = trim($_POST['nom'] ?? '');
  $prenom = trim($_POST['prenom'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $password2 = $_POST['password2'] ?? '';
  $role_id = $_POST['role_id'] ?? '';
  $etablissement_id = $_POST['etablissement_id'] ?? '';

  // Validation des champs
  if (empty($nom)) {
    $signupErrors['nom'] = "Le nom est requis.";
  }
  if (empty($prenom)) {
    $signupErrors['prenom'] = "Le prénom est requis.";
  }
  if (empty($role_id)) {
    $signupErrors['role_id'] = "Le rôle est requis.";
  }
  if (empty($etablissement_id)) {
    $signupErrors['etablissement_id'] = "L'établissement est requis.";
  }
  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $signupErrors['email'] = "Un email valide est requis.";
  }
  if (empty($password) || strlen($password) < 8) {
    $signupErrors['password'] = "Le mot de passe doit comporter au moins 8 caractères.";
  }
  if ($password !== $password2) {
    $signupErrors['password2'] = "Les mots de passe ne correspondent pas.";
  }

  // Vérifier si l'email existe déjà
  if (empty($signupErrors)) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
      $signupErrors['email'] = "Cet email est déjà utilisé.";
    }
  }

  // Si aucune erreur, procéder à l'inscription
  if (empty($signupErrors)) {
    try {
      // Hacher le mot de passe
      $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

      // Générer un token de confirmation (aléatoire et sécurisé)
      $confirmation_token = bin2hex(random_bytes(30));

      // Insérer les données dans la base de données
      $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, password, confirmation_token, role_id, etablissement_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->execute([
        $nom,
        $prenom,
        $email,
        $hashedPassword,
        $confirmation_token,
        $role_id,
        $etablissement_id
      ]);

      // Envoi de l'email de confirmation
      $confirmationLink = "http://localhost:8080/confirm.php?token=" . $confirmation_token;
      $subject = "Confirmez votre compte et rejoignez-nous !";
      $message = "
      <!DOCTYPE html>
      <html lang='fr'>
      <head>
          <meta charset='UTF-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1.0'>
          <style>
              body {
                  font-family: Arial, sans-serif;
                  line-height: 1.6;
                  background-color: #f4f4f4;
                  color: #333;
                  margin: 0;
                  padding: 0;
              }
              .email-container {
                  background-color: #ffffff;
                  margin: 20px auto;
                  padding: 20px;
                  border-radius: 10px;
                  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                  max-width: 600px;
              }
              .header {
                  text-align: center;
                  padding: 10px 0;
                  background-color: #a4bf2c;
                  color: #ffffff;
                  border-radius: 10px 10px 0 0;
              }
              .header h1 {
                  margin: 0;
                  font-size: 24px;
              }
              .content {
                  padding: 20px;
                  text-align: center;
              }
              .content p {
                  margin: 15px 0;
              }
              .btn {
                  display: inline-block;
                  background-color: #a4bf2c;
                  color: #ffffff;
                  padding: 10px 20px;
                  text-decoration: none;
                  border-radius: 5px;
                  font-weight: bold;
              }
              .btn:hover {
                  background-color: #0056b3;
              }
              .footer {
                  margin-top: 20px;
                  font-size: 12px;
                  color: #777;
                  text-align: center;
              }
          </style>
      </head>
      <body>
          <div class='email-container'>
              <div class='header'>
                  <h1>Bienvenue dans notre communauté !</h1>
              </div>
              <div class='content'>
                  <p>Bonjour <strong>$prenom</strong>,</p>
                  <p>Nous sommes ravis de vous compter parmi nous. Cliquez sur le bouton ci-dessous pour confirmer votre adresse email et activer votre compte :</p>
                  <a href='$confirmationLink' class='btn'>Confirmer mon compte</a>
                  <p>Si vous n'avez pas initié cette demande, veuillez ignorer cet email.</p>
              </div>
              <div class='footer'>
                  <p>© 2024 FFAviron. Tous droits réservés.</p>
                  <p>Besoin d'aide ? aviron-scolaire@ffaviron.fr.</p>
              </div>
          </div>
      </body>
      </html>
      ";

      // Assurez-vous que l'envoi de mail fonctionne correctement
      Envoiemail($email, $nom, $subject, $message);

      // Rediriger avec succès
      $_SESSION['success'] = "Votre compte a été créé avec succès ! Veuillez confirmer votre adresse email.";
      header('Location: /login');
      exit();
    } catch (PDOException $e) {
      $signupErrors['database'] = "Erreur lors de l'enregistrement : " . $e->getMessage();
    }
  }
}
?>

<form action="" method="post" id="userForm">
  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
  <div class="form-floating mb-3">
    <input type="text" class="form-control <?= isset($signupErrors['nom']) ? 'is-invalid' : '' ?>" id="floatingInputNom" name="nom" placeholder="DUPONT" value="<?= htmlspecialchars($nom ?? '') ?>">
    <label for="floatingInputNom">Nom</label>
    <div class="invalid-feedback"><?= $signupErrors['nom'] ?? '' ?></div>
  </div>
  <div class="form-floating mb-3">
    <input type="text" class="form-control <?= isset($signupErrors['prenom']) ? 'is-invalid' : '' ?>" id="floatingInputPrenom" name="prenom" placeholder="Jean" value="<?= htmlspecialchars($prenom ?? '') ?>">
    <label for="floatingInputPrenom">Prénom</label>
    <div class="invalid-feedback"><?= $signupErrors['prenom'] ?? '' ?></div>
  </div>
  <div class="form-floating mb-3">
    <label for="floatingRole">Rôle</label>
    <select class="form-select <?= isset($signupErrors['role_id']) ? 'is-invalid' : '' ?>" id="floatingRole" name="role_id">
      <option value="3" <?= isset($role_id) && $role_id == 3 ? 'selected' : '' ?>>Coach</option>
      <option value="4" <?= isset($role_id) && $role_id == 4 ? 'selected' : '' ?>>Enseignant</option>
    </select>
    <div class="invalid-feedback"><?= $signupErrors['role_id'] ?? '' ?></div>
  </div>
  <div class="mb-3">
    <label for="etablissement_id">Choisir l'établissement</label>
    <select name="etablissement_id" class="form-select <?= isset($signupErrors['etablissement_id']) ? 'is-invalid' : '' ?>">
      <option value="">Sélectionner un établissement...</option>
      <?php foreach ($etablissements as $etablissement): ?>
        <option value="<?= $etablissement['id'] ?>" <?= isset($etablissement_id) && $etablissement_id == $etablissement['id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($etablissement["Code_postal"] . ' - ' . $etablissement["Nom_commune"] . ' - ' . $etablissement["Nom_etablissement"]) ?>
        </option>
      <?php endforeach; ?>
    </select>
    <div class="invalid-feedback"><?= $signupErrors['etablissement_id'] ?? '' ?></div>
  </div>
  <div class="form-floating mb-3">
    <input type="email" class="form-control <?= isset($signupErrors['email']) ? 'is-invalid' : '' ?>" id="floatingInputMail" name="email" placeholder="name@example.com" value="<?= htmlspecialchars($email ?? '') ?>">
    <label for="floatingInputMail">E-mail</label>
    <div class="invalid-feedback"><?= $signupErrors['email'] ?? '' ?></div>
  </div>
  <div class="form-floating mb-3">
    <input type="password" class="form-control <?= isset($signupErrors['password']) ? 'is-invalid' : '' ?>" id="floatingPassword" name="password" placeholder="Password">
    <label for="floatingPassword">Mot de passe</label>
    <div class="invalid-feedback"><?= $signupErrors['password'] ?? '' ?></div>
  </div>
  <div class="form-floating mb-3">
    <input type="password" class="form-control <?= isset($signupErrors['password2']) ? 'is-invalid' : '' ?>" id="floatingPassword2" name="password2" placeholder="Password">
    <label for="floatingPassword2">Répéter le mot de passe</label>
    <div class="invalid-feedback"><?= $signupErrors['password2'] ?? '' ?></div>
  </div>
  <div class="d-grid">
    <button class="btn btn-success text-uppercase" style="color: white; font-weight: bold;" name="btnmodifform">S'inscrire</button>
  </div>
</form>