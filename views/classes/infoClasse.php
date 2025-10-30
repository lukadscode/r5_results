<div class="card">
    <div class="card-header border-0 pt-7">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-gray-900">Information établissement</span>
        </h3>
    </div>
    <div class="card-body" id="kt_update_classe">
        <form action="/updateClasse" method="post">
            <input type="hidden" name="token" value="<?= htmlspecialchars($classe['token'] ?? '') ?>">
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label for="form-label">Choisir l'établissement</label>
                    <select name="etablissement_id" data-control="select2" data-dropdown-parent="#kt_update_classe" data-placeholder="Selectionner un établissement..." class="form-select form-select-solid">
                        <option value="">Selectionner un établissement ...</option>
                        <?php
                        if (!empty($etablissements)) {
                            foreach ($etablissements as $etablissement) {
                                $selected = ($etablissement['id'] == ($classe['etablissement_id'] ?? '')) ? 'selected' : '';
                                echo '<option value="' . $etablissement["id"] . '" ' . $selected . '>' . $etablissement["Code_postal"] . ' - ' . $etablissement["Nom_commune"] . ' - ' . $etablissement["Nom_etablissement"] . '</option>';
                            }
                        } else {
                            echo '<option value="">Aucun établissement trouvé</option>';
                        }
                        ?>
                    </select>

                </div>
                <div class="mb-3 col-md-4">
                    <label for="form-label">Choisir la structure</label>
                    <select id="clubSelect" name="club_id" data-control="select2" data-dropdown-parent="#kt_update_classe" data-placeholder="Selectionner un club ..." class="form-select form-select-solid">
                        <option value="">Selectionner un club ...</option>
                        <option value="Aucun">Pas de club partenaire</option>

                        <?php

                        if (!empty($clubs)) {
                            foreach ($clubs as $club) {
                                $selected = ($club['id'] == ($classe['club_id'] ?? '')) ? 'selected' : '';
                                echo '<option value="' . $club["id"] . '" ' . $selected . '>' . $club["N_STR"] . ' - ' . $club["NOM_STR"] . '</option>';
                            }
                        } else {
                            echo '<option value="">Aucun club trouvé</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="" class="form-label">Classe</label>
                    <input type="text" class="form-control" placeholder="5e3" name="nom_classe" value="<?= htmlspecialchars($classe['nom_classe'] ?? '') ?>" />
                </div>
            </div>
            <hr>
            <h6>Information sur le responsable pédagogique</h6>
            <hr>
            <div class=" row">
                <div class="mb-7 col-md-4">
                    <label classe="form">Nom et prénom</label>
                    <input type="text" class="form-control" id="floatingInput" placeholder="DUPONT Jean" name="representant_nom" value="<?= htmlspecialchars($classe['representant_nom'] ?? '') ?>" />
                </div>
                <div class="mb-7 col-md-4">
                    <label classe="form">E-mail</label>
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="representant_mail" value="<?= htmlspecialchars($classe['representant_mail'] ?? '') ?>" />
                </div>
                <div class="mb-7 col-md-4">
                    <label classe="form">Numero de téléphone</label>
                    <input type="text" class="form-control" id="floatingInput" placeholder="06 XX XX XX XX" name="representant_tel" value="<?= htmlspecialchars($classe['representant_tel'] ?? '') ?>" />
                </div>
            </div>
            <button type="submit" class="btn btn-primary bg-blueffa">Mettre à jour</button>
        </form>
    </div>
</div>