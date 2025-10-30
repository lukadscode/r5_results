<?php
// Connexion à la base de données avec PDO
use App\Connection;

// Connexion à la base de données
$pdo = Connection::getPDO();
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Retourner des tableaux associatifs par défaut

$loginErrors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnLoginForm'])) {
  // Récupérer les données du formulaire
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  // Validation des champs
  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $loginErrors['email'] = "Un email valide est requis.";
  }
  if (empty($password)) {
    $loginErrors['password'] = "Le mot de passe est requis.";
  }

  // Si aucune erreur, vérifier les informations de connexion
  if (empty($loginErrors)) {
    $stmt = $pdo->prepare("SELECT id, password, role_id, email_verified FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
      if (!$user['email_verified']) {
        $loginErrors['email'] = "Votre email n'est pas encore vérifié. Veuillez vérifier vos emails.";
      } elseif (password_verify($password, $user['password'])) {
        // Connexion réussie
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role_id'] = $user['role_id'];

        // Redirection vers la page d'accueil ou tableau de bord
        header('Location: /'); // Changez ceci selon votre page d'accueil
        exit();
      } else {
        $loginErrors['email'] = "Email ou mot de passe incorrect.";
      }
    } else {
      $loginErrors['email'] = "Email ou mot de passe incorrect.";
    }
  }
}
?>

<!-- Formulaire de connexion -->
<form action="" method="post">
  <div class="form-floating mb-3">
    <input
      type="email"
      class="form-control <?php echo isset($loginErrors['email']) ? 'is-invalid' : ''; ?>"
      id="floatingInput"
      name="email"
      placeholder="name@example.com"
      value="<?php echo htmlspecialchars($email ?? '', ENT_QUOTES); ?>">
    <label for="floatingInput">E-mail</label>
    <?php if (isset($loginErrors['email'])): ?>
      <div class="invalid-feedback">
        <?php echo $loginErrors['email']; ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="form-floating mb-3">
    <input
      type="password"
      class="form-control <?php echo isset($loginErrors['password']) ? 'is-invalid' : ''; ?>"
      id="floatingPassword"
      name="password"
      placeholder="Password">
    <label for="floatingPassword">Mot de passe</label>
    <?php if (isset($loginErrors['password'])): ?>
      <div class="invalid-feedback">
        <?php echo $loginErrors['password']; ?>
      </div>
    <?php endif; ?>
  </div>

  <div class="d-grid mb-4">
    <button class="btn btn-success text-uppercase" style="color: white; font-weight: bold;" name="btnLoginForm">Se connecter</button>
  </div>
  <div class="d-grid">
    <a class="btn btn-success text-uppercase" style="color: white; font-weight: bold;" href="/signup">Créer mon compte</a>
  </div>
</form>
<div class="text-center">
  <a class="small" href="/forget">J'ai oublié mon mot de passe</a>
</div>