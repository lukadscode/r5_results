<?php

namespace App\Models;

use PDO;

class Club
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllClubs()
    {
        $sql = "SELECT id, NOM_STR, N_STR FROM FFAlisteclub";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
