<?php

use App\Connection;
use App\Models\Etablissement;
use App\Models\Club;

$pdo = Connection::getPDO();
$etablissementModel = new Etablissement($pdo);
$clubModel = new Club($pdo);

$etablissements = $etablissementModel->getAllColleges();
$clubs = $clubModel->getAllClubs();


?>


<!--begin Modal Add classes-->
<div class="modal fade" tabindex="-1" id="kt_modal_new_address">
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
                    <div class="mb-3">
                        <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                            <span class="required">Etablissement</span>
                        </label>
                        <select name="etablissement_id" data-control="select2" data-dropdown-parent="#kt_modal_new_address" data-placeholder="Selectionner un établissement..." class="form-select form-select-solid">
                            <option value="">Selectionner un établissement ...</option>
                            <?php
                            if (!empty($etablissements)) {
                                foreach ($etablissements as $etablissement) {
                                    echo '<option value="' . $etablissement["id"] . '">' . $etablissement["Code_postal"] . ' - ' . $etablissement["Nom_commune"] . ' - ' . $etablissement["Nom_etablissement"] . '</option>';
                                }
                            } else {
                                echo '<option value="">Aucun établissement trouvé</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="form-label">Club d'Aviron partenaire</label>
                        <select id="clubSelect" name="club_id" data-control="select2" data-dropdown-parent="#kt_modal_new_address" data-placeholder="Selectionner un club ..." class="form-select form-select-solid">
                            <option value="">Selectionner un club ...</option>
                            <option value="Aucun">Pas de club partenaire</option>
                            <?php
                            if (!empty($clubs)) {
                                foreach ($clubs as $club) {
                                    echo '<option value="' . $club["id"] . '">' . $club["N_STR"] . ' - ' . $club["NOM_STR"] . '</option>';
                                }
                            } else {
                                echo '<option value="">Aucun club trouvé</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Classe</label>
                        <input type="text" name="nom_classe" class="form-control" placeholder="5e3" />
                    </div>
                    <hr>
                    <h6>Information sur le professeur d'EPS</h6>
                    <hr>
                    <div class="form-floating mb-7">
                        <input type="text" name="representant_nom" class="form-control" id="floatingInput" placeholder="name@example.com" />
                        <label for="floatingInput">Nom et prénom</label>
                    </div>
                    <div class="form-floating mb-7">
                        <input type="email" name="representant_mail" class="form-control" id="floatingInput" placeholder="name@example.com" />
                        <label for="floatingInput">E-mail</label>
                    </div>
                    <div class="form-floating mb-7">
                        <input type="text" name="representant_tel" class="form-control" id="floatingInput" placeholder="name@example.com" />
                        <label for="floatingInput">Numero de téléphone</label>
                    </div>
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