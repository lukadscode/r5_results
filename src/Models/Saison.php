<?php

namespace App\Models;

use PDO;

class Saison
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllSaisons(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM saison");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSaisonById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM saison WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function createSaison(array $data): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO saison (nom, active) VALUES (:nom, :active)");
        return $stmt->execute($data);
    }

    public function updateSaison(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("UPDATE saison SET nom = :nom, active = :active WHERE id = :id");
        return $stmt->execute(['id' => $id] + $data);
    }

    public function deleteSaison(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM saison WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function activateSaison(int $id): bool
    {
        // Désactiver toutes les saisons
        $this->pdo->query("UPDATE saison SET active = 0");

        // Activer la saison spécifiée
        $stmt = $this->pdo->prepare("UPDATE saison SET active = 1 WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
