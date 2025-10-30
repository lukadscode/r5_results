<?php
// Connexion à la base de données
$pdo = \App\Connection::getPDO();

use App\Models\Etablissement;
use App\Models\Club;

$etablissementModel = new Etablissement($pdo);
$clubModel = new Club($pdo);

$etablissements = $etablissementModel->getAllColleges();
$clubs = $clubModel->getAllClubs();


// Vérification du token dans l'URL (supposons que le token soit passé en paramètre d'URL)
$token = $params['token'] ?? null;


if (!$token) {
    echo "Token non spécifié.";
    exit;
}

// Création de l'instance du modèle Etablissement
$etablissementModel = new \App\Models\Etablissement($pdo);

// Récupération des informations de la classe par token (supposons que cela soit déjà implémenté dans Classe)
$classeModel = new \App\Models\Classe($pdo);
$classe = $classeModel->getClasseByToken($token);

if (!$classe) {
    echo "Aucune classe trouvée pour ce token.";
    exit;
}

// Récupération du nom de l'établissement correspondant à etablissement_id
$nomEtablissement = $etablissementModel->getEtablissementNameById($classe['etablissement_id']);
$saison = 1;
$epreuve = "R5";
$classeId = $classe['id'];

?>

<div class="app-main flex-column flex-row-fluid " id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar ">
            <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack ">
                <div class="page-title d-flex flex-column justify-content-center me-3 mb-6 mb-lg-0">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">
                        Classe <?= htmlspecialchars($classe['nom_classe'] ?? '') ?> - <?= htmlspecialchars($nomEtablissement ?? '') ?>
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="/" class="text-muted text-hover-primary">
                                Accueil </a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            Classe <?= htmlspecialchars($classe['nom_classe'] ?? '') ?> - <?= htmlspecialchars($nomEtablissement ?? '') ?></li>

                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <div class="d-flex">
                        <a href="#" class="btn btn-<?= $classe['statut'] == 2 ? 'success' : 'warning' ?> d-flex flex-center flex-shrink-0 ms-4 h-40px">
                            <?= $classe['statut'] == 2 ? 'VALIDE' : 'Validé la classe' ?>
                        </a>
                        <a href="#" class="btn btn-danger d-flex flex-center flex-shrink-0 ms-4 h-40px" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                            <i class="fa-solid fa-users"></i> Générer mes diplômes
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <div id="kt_app_content_container" class="app-container  container-fluid ">
                <div class="col-md-12  mb-5 mb-xl-10">
                    <?php require('infoClasse.php'); ?>
                </div>
                <div class="col-md-12  mb-5 mb-xl-10">
                    <div class="card">
                        <div class="card-header border-0 pt-7">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-900">Ajouter un élève</span>
                            </h3>
                        </div>
                        <?php require('../views/eleves/newEleve.php'); ?>

                        <?php require('importClasse.php'); ?>
                    </div>
                </div>
                <?php require('statClasse.php'); ?>
                <div class="col-xl-12">
                    <div class="card h-xl-100">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">Résultats classe</span>
                            </h3>
                        </div>
                        <div class="card-body py-3">
                            <?php require('result_eleve.php'); ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="/js/modals/KTUtil.js"></script>
    <script src="/js/modals/new-classe.js"></script>