<?php
// src/Controller/AjoutUtilisateur.php
namespace App\Controller;

require __DIR__ . '/../autoload.php';

use App\Connection;
use PDO;
use Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $role_id = $_POST['role_id'] ?? '';
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    $errors = [];

    // Validation des champs
    if (!preg_match("/^[a-zA-Z]+$/", $nom)) {
        $errors[] = "Le nom ne doit contenir que des lettres.";
    }

    if (!preg_match("/^[a-zA-Z]+$/", $prenom)) {
        $errors[] = "Le prénom ne doit contenir que des lettres.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email est invalide.";
    }

    if (!in_array($role_id, ['3', '4'])) {
        $errors[] = "Le rôle sélectionné est invalide.";
    }

    if (
        strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password) ||
        !preg_match("/[\W_]/", $password)
    ) {
        $errors[] = "Le mot de passe doit comporter au moins 8 caractères, dont une majuscule, une minuscule et un chiffre.";
    }

    if ($password !== $password2) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    if (empty($errors)) {
        try {
            $pdo = Connection::getPDO();
            $stmt = $pdo->prepare("INSERT INTO users (email, nom, prenom, password, role_id, type, date_creation) VALUES (:email, :nom, :prenom, :password, :role_id, 'user', NOW())");
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $stmt->execute([
                ':email' => $email,
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':password' => $passwordHash,
                ':role_id' => $role_id
            ]);
            echo "Utilisateur ajouté avec succès !";
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}
