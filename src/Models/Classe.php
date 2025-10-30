<?php

namespace App\Models;

use PDO;

class Classe
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllClasses(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM classe");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClasseByToken(string $token): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM classe WHERE token = :token");
        $stmt->execute(['token' => $token]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null; // Retourner null si aucun résultat trouvé
    }

    public function getClassesByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT c.*, e.nom_etablissement, 
                   (SELECT COUNT(*) FROM resultat WHERE classe_id = c.id AND sexe = 'H') AS garcons, 
                   (SELECT COUNT(*) FROM resultat WHERE classe_id = c.id AND sexe = 'F') AS filles 
            FROM classe c
            JOIN etablissement e ON c.etablissement_id = e.id
            WHERE c.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function countClasses(): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS count FROM classe ");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    public function createClass(array $data): bool
    {
        // Générer un token aléatoire
        $data['token'] = $this->generateToken();

        $stmt = $this->pdo->prepare("INSERT INTO classe (etablissement_id, user_id, nom_classe, representant_nom, representant_mail, representant_tel, club_id, token) VALUES (:etablissement_id, :user_id, :nom_classe, :representant_nom, :representant_mail, :representant_tel, :club_id, :token)");
        return $stmt->execute($data);
    }

    public function updateClass(string $token, array $data)
    {
        $data['token'] = $token; // Assurez-vous que le token est bien ajouté aux données à mettre à jour
        $stmt = $this->pdo->prepare("UPDATE classe SET etablissement_id = :etablissement_id, nom_classe = :nom_classe, representant_nom = :representant_nom, representant_mail = :representant_mail, representant_tel = :representant_tel, club_id = :club_id WHERE token = :token");
        return $stmt->execute($data);
    }

    public function deleteClass(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM classe WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    private function generateToken(): string
    {
        // Génération d'un token aléatoire (exemple : 24D-CA8-AB4)
        $token = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 3)) . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 3)) . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 3));
        return $token;
    }
    public function getLastInsertedToken(): ?string
    {
        // Utilisation de lastInsertId() pour récupérer l'ID de la dernière insertion
        $lastId = $this->pdo->lastInsertId();

        if (!$lastId) {
            return null;
        }

        // Requête pour récupérer le token associé à l'ID inséré
        $stmt = $this->pdo->prepare("SELECT token FROM classe WHERE id = :id");
        $stmt->execute(['id' => $lastId]);
        $token = $stmt->fetchColumn(); // Supposons que 'token' est une colonne de votre table 'classe'

        return $token;
    }
}
