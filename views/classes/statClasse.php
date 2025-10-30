<?php

// Inclure vos dépendances et initialiser la connexion PDO
use App\Models\Classe;
use App\Models\Eleve;
use App\Connection;

// Connexion à la base de données
$pdo = Connection::getPDO(); // Assurez-vous d'utiliser correctement votre classe de connexion
// Instanciation du modèle de Classe
$classeModel = new Classe($pdo);
// Récupération des détails de la classe à partir du token
$classe = $classeModel->getClasseByToken($token);
// Récupération de l'identifiant de la classe
$classeId = $classe['id'];
// Instanciation du modèle d'Eleve avec l'identifiant de la classe
$eleveModel = new Eleve($pdo);
$eleveModel->setClasseId($classeId); // Assurez-vous que votre modèle d'Eleve peut utiliser l'identifiant de la classe

// Récupération des stats
$nombreElevesMasculins = $eleveModel->countMaleStudentsByClasse();
$nombreElevesFeminin = $eleveModel->countFemaleStudentsByClasse();
$totalDistance = $eleveModel->getTotalDistanceByClasse();
$averageDistance = $eleveModel->getAverageDistanceByClasse();
$totalWeightedDistance = $eleveModel->getTotalWeightedDistanceByClasse();
$averageWeightedDistance = $eleveModel->getAverageWeightedDistanceByClasse();
?>

<div class=" row g-5 g-xl-10 mb-5 mb-xl-10">
    <div class="col-sm-2 ">
        <div class="card card-flush bg-primary ">
            <div class="card-body p-3">
                <div class=" d-flex flex-column text-white">
                    <h3 class="text-center fs-lg-2tx fw-bold text-white"> <span data-kt-countup="true" data-kt-countup-value="<?= $nombreElevesMasculins ?>"><?= $nombreElevesMasculins ?></span></h3>
                    <h6 class="text-center text-white"> <span>Garçons</span></h6>
                </div>

            </div>
        </div>
    </div>
    <div class="col-sm-2 ">
        <div class="card card-flush bg-danger ">
            <div class="card-body p-3">
                <div class=" d-flex flex-column text-white">
                    <h3 class="text-center fs-lg-2tx fw-bold text-white"> <span data-kt-countup="true" data-kt-countup-value="<?= $nombreElevesFeminin ?>"><?= $nombreElevesFeminin ?></span></h3>
                    <h6 class="text-center text-white"> <span>Filles</span></h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-2 ">
        <div class="card card-flush ">
            <div class="card-body p-3">
                <div class=" d-flex flex-column ">
                    <h3 class="text-center fs-lg-2tx fw-bold "> <span data-kt-countup="true" data-kt-countup-value="<?= $totalDistance ?>"><?= $totalDistance ?>m</span></h3>
                    <h6 class="text-center ">Distance total</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-2 ">
        <div class="card card-flush ">
            <div class="card-body p-3">
                <div class=" d-flex flex-column ">
                    <h3 class="text-center fs-lg-2tx fw-bold "> <span data-kt-countup="true" data-kt-countup-value="<?= $averageDistance ?>"><?= $averageDistance ?>m</span></h3>
                    <h6 class="text-center ">Distance moyenne</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-2 ">
        <div class="card card-flush ">
            <div class="card-body p-3">
                <div class=" d-flex flex-column ">
                    <h3 class="text-center fs-lg-2tx fw-bold "> <span data-kt-countup="true" data-kt-countup-value="<?= $totalWeightedDistance ?>"><?= $totalWeightedDistance ?>m</span></h3>
                    <h6 class="text-center ">Distance totale pondérée</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-2 ">
        <div class="card card-flush ">
            <div class="card-body p-3">
                <div class=" d-flex flex-column ">
                    <h3 class="text-center fs-lg-2tx fw-bold "> <span data-kt-countup="true" data-kt-countup-value="<?= $averageWeightedDistance ?>"><?= $averageWeightedDistance ?>m</span></h3>
                    <h6 class="text-center ">Distance moyenne pondérée</h6>
                </div>
            </div>
        </div>
    </div>
</div>