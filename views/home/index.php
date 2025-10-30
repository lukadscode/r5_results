<?php

// Inclure vos dépendances et initialiser la connexion PDO

use App\Models\Eleve;
use App\Models\Classe;
use App\Connection;

// Connexion à la base de données
$pdo = Connection::getPDO(); // Assurez-vous d'utiliser correctement votre classe de connexion


// Instanciation du modèle d'Eleve avec l'identifiant de la classe
$eleveModel = new Eleve($pdo);

$nombreElevesMasculins = $eleveModel->countMaleStudents();
$nombreElevesFeminins = $eleveModel->countFemaleStudents();

$ClasseModel = new Classe($pdo);
$nombreClasses = $ClasseModel->countClasses();

$etablissementModel = new App\Models\Etablissement($pdo);

$objectif = 1000;
$pourcentage = ($nombreClasses / $objectif) * 100;

?>

<div class="app-main flex-column flex-row-fluid " id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar ">
            <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack ">
                <div class="page-title d-flex flex-column justify-content-center me-3 mb-6 mb-lg-0">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">
                        Accueil
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="/keen/demo8/index.html" class="text-muted text-hover-primary">
                                Home </a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            Dashboards </li>

                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <div class="d-flex">
                        <a href="#" class="btn btn-icon bg-body ms-4 flex-shrink-0 h-40px" data-bs-toggle="modal" data-bs-target="#kt_modal_saison">
                            <i class="fa-solid fa-gear"></i>
                        </a>

                        <a href="#" class="btn btn-color-gray-700 bg-body d-flex flex-center flex-shrink-0 ms-4 h-40px" data-bs-toggle="modal" data-bs-target="#kt_modal_saison">
                            <i class="fa-solid fa-plus"></i> Ajouter une saison
                        </a>

                        <a href="#" class="btn btn-danger d-flex flex-center flex-shrink-0 ms-4 h-40px" data-bs-toggle="modal" data-bs-target="#kt_modal_new_address">
                            <i class="fa-solid fa-users"></i> Ajouter un classe
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <div id="kt_app_content_container" class="app-container  container-fluid ">
                <div class="row g-5 col-md-12 mb-5">
                    <div class="col-md-2 ">
                        <div class="card card-flush bg-primary ">
                            <div class="card-body p-3">
                                <div class=" d-flex flex-column text-white">
                                    <h3 class="text-center fs-lg-2tx fw-bold text-white"> <span data-kt-countup="true" data-kt-countup-value="<?= $nombreElevesMasculins ?>"><?= $nombreElevesMasculins ?></span></h3>
                                    <h6 class="text-center text-white"> <span>Garçons</span></h6>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <div class="card card-flush bg-primary">
                            <div class="card-body p-3">
                                <div class=" d-flex flex-column ">
                                    <h3 class="text-center fs-lg-2tx fw-bold text-white"> <span data-kt-countup="true" data-kt-countup-value="<?= $nombreClasses ?>"><?= $nombreClasses ?></span></h3>
                                    <h6 class="text-center text-white"> Meilleur perf. G</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <div class="card card-flush bg-danger ">
                            <div class="card-body p-3">
                                <div class=" d-flex flex-column text-white">
                                    <h3 class="text-center fs-lg-2tx fw-bold text-white"> <span data-kt-countup="true" data-kt-countup-value="<?= $nombreElevesFeminins ?>"><?= $nombreElevesFeminins ?></span></h3>
                                    <h6 class="text-center text-white"> <span>Filles</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <div class="card card-flush bg-danger  ">
                            <div class="card-body p-3">
                                <div class=" d-flex flex-column ">
                                    <h3 class="text-center fs-lg-2tx fw-bold text-white "> <span data-kt-countup="true" data-kt-countup-value="<?= $nombreClasses ?>"><?= $nombreClasses ?></span></h3>
                                    <h6 class="text-center text-white"> Meilleur perf. F</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <div class="card card-flush ">
                            <div class="card-body p-3">
                                <div class=" d-flex flex-column ">
                                    <h3 class="text-center fs-lg-2tx fw-bold "> <span data-kt-countup="true" data-kt-countup-value="<?= $nombreClasses ?>"><?= $nombreClasses ?></span></h3>
                                    <h6 class="text-center "> Classes</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 ">
                        <div class="card card-flush ">
                            <div class="card-body p-3">
                                <div class=" d-flex flex-column ">
                                    <h3 class="text-center fs-lg-2tx fw-bold "> <span data-kt-countup="true" data-kt-countup-value="<?= $nombreClasses ?>"><?= $nombreClasses ?></span></h3>
                                    <h6 class="text-center ">Etablissements</h6>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="row g-5 col-12">
                    <div class="col-md-6 col-md-5">
                        <div class="card card-flush bg-success h-lg-50">
                            <div class="card-header pt-5">
                                <div class="card-title d-flex flex-row-fluid flex-stack">
                                    <div class="d-flex flex-column">
                                        <a href="/keen/demo8/pages/user-profile/overview.html" class="opacity-75-hover mb-2 fw-bold text-white fs-3">Classes</a>
                                        <span class="fs-6 text-light-success fs-semibase">
                                            <?php $eleveTotal = $nombreElevesMasculins + $nombreElevesFeminins;
                                            echo $eleveTotal ?> élèves.
                                        </span>
                                    </div>
                                    <span class="text-white fw-bold fs-2x"><?= round($pourcentage, 1) . "%." ?></span>
                                </div>
                            </div>
                            <div class="card-body d-flex align-items-end pt-0">
                                <div class="d-flex flex-column mt-3 w-100">
                                    <span class="fw-semibase fs-6 text-white mb-2">Progress</span>

                                    <div class="h-6px w-100 rounded" style="background-color:#DFF6F2">
                                        <div class="bg-black rounded h-6px" role="progressbar" style="width: <?= round($pourcentage, 1) ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-flush h-md-100">
                            <div class="card-header border-0 pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-900">Actus</span>
                                    <span class="text-muted mt-3 fw-semibold fs-6">29 juin 2024</span>
                                </h3>
                            </div>
                            <div class="card-body pt-7 pb-5">
                                <div class="bgi-no-repeat bgi-size-cover rounded min-h-250px mb-7">
                                    <img src="/img/images/R5-PCS.jpg" alt="">
                                </div>
                                <a href="" class="text-hover-primary fw-semibold text-gray-900 fs-3">L'actu de l'année</a>
                                <div class="text-gray-600 fw-normal pt-3">
                                    You also need to be able to accept that not every post is going to get your motor running. Some posts will feel like
                                </div>
                            </div>
                            <div class="card-footer pt-0">
                                <a href="#" class="btn btn-primary bg-blueffa btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">En savoir plus ...</a>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                    <li class="nav-item">
                        <a class="nav-link active h3" data-bs-toggle="tab" href="#kt_tab_pane_1">
                            <h3>Mosaïque</h3>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link h3" data-bs-toggle="tab" href="#kt_tab_pane_2">
                            <h3>Tableau</h3>
                        </a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                        <?php require('cards.php'); ?>
                    </div>
                    <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                        <div class="col-xl-12">
                            <div class="card h-xl-100">
                                <div class="card-header border-0 pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold fs-3 mb-1">Classement national rame en 5e</span>
                                    </h3>
                                </div>
                                <div class="card-body py-3">
                                    <?php require('result_table.php'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<?php require 'modalAddClasse.php'; ?>
<?php require 'modalSaison.php'; ?>