<div class="card-body">
    <form action="/storeEleve" method="post">
        <input type="hidden" name="classe_id" value="<?= htmlspecialchars($classe['id'] ?? '') ?>">
        <input type="hidden" name="epreuve" value="R5">
        <input type="hidden" name="saison_id" value="1">
        <input type="hidden" name="classe_token" value="<?= htmlspecialchars($classe['token'] ?? '') ?>">
        <div class="row">
            <div class="mb-7 col-md-3">
                <label classe="form">Nom</label>
                <input type="text" class="form-control" id="floatingInput" name="nom" placeholder="DUPONT" />
            </div>
            <div class="mb-7 col-md-3">
                <label classe="form">Prénom</label>
                <input type="text" class="form-control" id="floatingInput" name="prenom" placeholder="Jean" />
            </div>
            <div class="mb-7 col-md-2">
                <label classe="form">Sexe</label>
                <input type="text" class="form-control" id="floatingInput" name="sexe" placeholder="H ou F" />
            </div>
            <div class="mb-7 col-md-2">
                <label classe="form">Année naissance</label>
                <input type="number" min="2006" max="2013" class="form-control" id="floatingInput" name="annee_naissance" placeholder="2011" />
            </div>
            <div class="mb-7 col-md-2">
                <label classe="form">Distance</label>
                <input type="text" class="form-control" id="floatingInput" name="distance" placeholder="306" />
            </div>
            <button type="submit" class="btn bg-blueffa text-white">Ajouter</button>
        </div>
    </form>
</div>