<?php

use App\Models\Saison;

// Connexion à la base de données
$pdo = \App\Connection::getPDO();

// Création de l'instance de modèle saison avec la connexion PDO valide
$saisonModel = new Saison($pdo);

// Récupérer toutes les saisons
$saisons = $saisonModel->getAllSaisons();

?>


<!--begin Modal Add classes-->
<div class="modal fade" tabindex="-1" id="kt_modal_saison">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="addClasse" method="post" id="kt_modal_new_address_form">

                <input type="hidden" name="user_id" value="1">
                <div class="modal-header">
                    <h3 class="modal-title">Ajouter une classe</h3>

                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>

                <div class="modal-body">
                    <h6>Ajout saison</h6>
                    <div class="form-floating mb-7">
                        <input type="text" name="representant_tel" class="form-control" id="floatingInput" placeholder="name@example.com" />
                        <label for="floatingInput">Saison</label>
                    </div>
                    <hr>
                    <table class="table align-middle rounded table-row-dashed fs-6 g-5" id="kt_datatable_example">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase">
                                <th class="text-center min-w-100px">ID</th>
                                <th class="text-center min-w-100px">Nom</th>
                                <th class="text-center min-w-100px">Statut</th>
                                <th class="text-center min-w-100px">Action</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            <?php foreach ($saisons as $saison) : ?>
                                <tr>
                                    <td class="text-center"><?= htmlspecialchars($saison['id']) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($saison['nom']) ?></td>
                                    <td class="text-center">
                                        <div class="badge badge-light-<?= $saison['active'] ? 'success' : 'warning' ?>">
                                            <?= $saison['active'] ? 'Active' : 'Inactive' ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <form action="/saison/activate/<?= $saison['id'] ?>" method="post" style="display:inline;">
                                            <button class="btn btn-primary" type="submit">Activer</button>
                                        </form>
                                        <form action="/saison/delete/<?= $saison['id'] ?>" method="post" style="display:inline;">
                                            <button class="btn btn-danger" type="submit">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary bg-blueffa">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/js/modals/KTUtil.js"></script>
<script src="/js/modals/new-classe.js"></script>