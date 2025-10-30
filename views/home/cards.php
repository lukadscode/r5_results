<?php

use App\Models\Classe;
use App\Connection;

// Connexion à la base de données
$pdo = Connection::getPDO();
$classeModel = new Classe($pdo);
$userId = 1;
$classes = $classeModel->getClassesByUserId($userId);

?>
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <?php foreach ($classes as $classe) : ?>
        <div class="col-xl-3 col-ms-4 ">
            <div class="card card-flush">
                <div class="card-header ribbon ribbon-top ribbon-vertical">
                    <div class="ribbon-label bg-<?= $classe['statut'] == 2 ? 'success' : 'warning' ?>">
                        <?= $classe['statut'] == 2 ? 'VALIDE' : 'EN COURS' ?>
                    </div>
                    <div class="card-title d-flex flex-column">
                        <h3><?= htmlspecialchars($classe['nom_classe']) ?></h3>
                        <small class="text-muted"><?= htmlspecialchars($classe['nom_etablissement']) ?></small>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class=" d-flex flex-column p-3">
                        <div class="row text-center">
                            <div class="col-md-6">
                                <h3><?= htmlspecialchars($classe['garcons']) ?></h3>
                                <span>Garçons</span>
                            </div>
                            <div class="col-md-6">
                                <h3><?= htmlspecialchars($classe['filles']) ?></h3>
                                <span>Filles</span>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="/classe/<?= htmlspecialchars($classe['token']) ?>">
                    <div class="card-footer bg-blueffa p-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-center text-white"><?= $classe['statut'] == 2 ? 'Voir' : 'Voir / Modifier' ?></h5>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-center text-white">Dupliquer</h5>
                            </div>
                        </div>

                    </div>
                </a>
            </div>
        </div>
    <?php endforeach; ?>

</div>