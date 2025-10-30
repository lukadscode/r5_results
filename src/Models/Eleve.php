<?php

namespace App\Models;

use PDO;

class Eleve
{
    private $pdo;
    private $classeId; // Nouvelle propriété pour l'identifiant de la classe

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function setClasseId($classeId)
    {
        $this->classeId = $classeId;
    }

    public function addEleve(array $data): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO resultat (nom, prenom, sexe, annee_naissance, distance, classe_id, epreuve, saison_id) 
                                    VALUES (:nom, :prenom, :sexe, :annee_naissance, :distance, :classe_id, :epreuve, :saison_id)");

        return $stmt->execute($data);
    }

    public function deleteEleveById(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM resultat WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function countMaleStudents(): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS count FROM resultat WHERE sexe = 'H'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    public function countMaleStudentsByClasse(): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS count FROM resultat WHERE classe_id = :classe_id AND sexe = 'H'");
        $stmt->execute(['classe_id' => $this->classeId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    public function countFemaleStudents(): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS count FROM resultat WHERE  sexe = 'F'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    public function countFemaleStudentsByClasse(): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS count FROM resultat WHERE classe_id = :classe_id AND sexe = 'F'");
        $stmt->execute(['classe_id' => $this->classeId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    public function getTotalDistanceByClasse(): int
    {
        $stmt = $this->pdo->prepare("SELECT SUM(distance) AS total_distance FROM resultat WHERE classe_id = :classe_id");
        $stmt->execute(['classe_id' => $this->classeId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_distance'] ?? 0;
    }

    public function getAverageDistanceByClasse(): float
    {
        $stmt = $this->pdo->prepare("SELECT AVG(distance) AS average_distance FROM resultat WHERE classe_id = :classe_id");
        $stmt->execute(['classe_id' => $this->classeId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) $result['average_distance'] ?? 0.00;
    }

    public function getTotalWeightedDistanceByClasse(): float
    {
        $stmt = $this->pdo->prepare("SELECT SUM(CASE WHEN sexe = 'F' THEN distance + 10 ELSE distance END) AS total_weighted_distance FROM resultat WHERE classe_id = :classe_id");
        $stmt->execute(['classe_id' => $this->classeId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) $result['total_weighted_distance'] ?? 0.00;
    }

    public function getAverageWeightedDistanceByClasse(): float
    {
        $stmt = $this->pdo->prepare("SELECT AVG(CASE WHEN sexe = 'F' THEN distance + 10 ELSE distance END) AS average_weighted_distance FROM resultat WHERE classe_id = :classe_id");
        $stmt->execute(['classe_id' => $this->classeId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) $result['average_weighted_distance'] ?? 0.00;
    }

    public function getAllElevesByClasse(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM resultat WHERE classe_id = :classe_id ORDER BY distance DESC");
        $stmt->execute(['classe_id' => $this->classeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Autres méthodes pour récupérer, mettre à jour des élèves...

}
