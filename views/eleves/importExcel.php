<?php

use App\Models\Eleve;
use App\Connection;
use PhpOffice\PhpSpreadsheet\IOFactory;

// Connexion à la base de données
$pdo = Connection::getPDO();

// Initialiser une variable pour stocker les messages d'erreur
$errors = [];
$success = false;

// Récupération du token et autres paramètres
$token = $_POST['token'] ?? null;
$classeId = $_POST['id'] ?? null; // Assurez-vous que l'identifiant de la classe est bien passé
$epreuve = $_POST['epreuve'] ?? null;
$saison = $_POST['saison'] ?? null;

// Vérification si un fichier a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
    $fileTmpName = $_FILES['excel_file']['tmp_name'];
    $fileError = $_FILES['excel_file']['error'];
    $fileSize = $_FILES['excel_file']['size'];

    // Vérification des erreurs de téléchargement de fichier
    if ($fileError !== UPLOAD_ERR_OK) {
        $errors[] = "Erreur lors du téléchargement du fichier.";
    } elseif ($fileSize > 10485760) { // Taille maximale de 10 Mo
        $errors[] = "Le fichier est trop volumineux. La taille maximale autorisée est 10 Mo.";
    } else {
        // Vérifier si c'est bien un fichier Excel
        try {
            $inputFileType = IOFactory::identify($fileTmpName);
            $reader = IOFactory::createReader($inputFileType);
            $spreadsheet = $reader->load($fileTmpName);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            $errors[] = "Erreur lors de la lecture du fichier Excel : " . $e->getMessage();
        }

        if (empty($errors)) {
            // Vérification des en-têtes
            $headers = $sheetData[1] ?? [];
            $expectedHeaders = ['Nom', 'Prenom', 'Sexe', 'Annee naissance', 'Distance'];

            foreach ($expectedHeaders as $header) {
                if (!in_array($header, $headers)) {
                    $errors[] = "L'un des en-têtes attendus est manquant dans le fichier : " . $header;
                    break;
                }
            }

            if (empty($errors)) {
                // Boucle sur les lignes à partir de la deuxième ligne (la première ligne est généralement les en-têtes)
                foreach ($sheetData as $index => $row) {
                    if ($index === 1) continue; // Ignorer la première ligne d'en-tête

                    // Validation des données
                    $nom = $row['A'] ?? '';
                    $prenom = $row['B'] ?? '';
                    $sexe = strtoupper(trim($row['C'] ?? '')); // Normaliser sexe en majuscule
                    $annee_naissance = $row['D'] ?? '';
                    $distance = $row['E'] ?? '';

                    // Conversion du sexe
                    if ($sexe === 'F') {
                        $sexe = 'F';
                    } elseif (in_array($sexe, ['M', 'H'])) {
                        $sexe = 'H';
                    } else {
                        $sexe = 'Invalid'; // Si le sexe est invalide
                    }

                    // Vérification des données
                    if (empty($nom) || empty($prenom) || !in_array($sexe, ['F', 'H']) || !is_numeric($annee_naissance) || !is_numeric($distance)) {
                        $errors[] = "Les données de la ligne {$index} sont invalides.";
                        continue;
                    }

                    // Utilisation du modèle Eleve pour insérer en base de données
                    $eleveModel = new Eleve($pdo);
                    $data = [
                        'nom' => $nom,
                        'prenom' => $prenom,
                        'sexe' => $sexe,
                        'annee_naissance' => $annee_naissance,
                        'distance' => $distance,
                        'epreuve' => $epreuve,
                        'saison_id' => $saison,
                        'classe_id' => $classeId
                    ];

                    if (!$eleveModel->addEleve($data)) {
                        $errors[] = "Erreur lors de l'ajout de l'élève : {$nom} {$prenom}.";
                    }
                }

                if (empty($errors)) {
                    // Redirection vers la page de la classe avec le token
                    header("Location: /classe/{$token}");
                    exit;
                }
            }
        }
    }
}

// Affichage des messages d'erreur ou de succès
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p class='text-danger'>{$error}</p>";
    }
} else if ($success) {
    echo "<p class='text-success'>Importation réussie !</p>";
}
