<?php

namespace App\Models;

use PDO;

class Etablissement
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllColleges()
    {
        $sql = "SELECT id, Code_postal, Nom_etablissement, Nom_commune FROM etablissement WHERE Type_etablissement = 'Collège'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getEtablissementNameById(int $etablissement_id): ?string
    {
        $stmt = $this->pdo->prepare("SELECT nom_etablissement FROM etablissement WHERE id = :id");
        $stmt->execute(['id' => $etablissement_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['nom_etablissement'] : null;
    }

    public function getEtablissementById(int $etablissement_id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM etablissement WHERE id = :id");
        $stmt->execute(['id' => $etablissement_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
