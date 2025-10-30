<?php

use App\Connection;

$pdo = Connection::getPDO();

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = isset($_GET['q']) ? $_GET['q'] : '';
    $limit = 50;
    $sql = "SELECT id, Code_postal, Nom_etablissement, Nom_commune FROM etablissements 
            WHERE Nom_etablissement LIKE :query 
            LIMIT :limit";
    $stmt = $pdo->prepare($sql);
    $searchQuery = "%$query%";
    $stmt->bindParam(':query', $searchQuery, PDO::PARAM_STR);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $etablissements = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($etablissements);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
