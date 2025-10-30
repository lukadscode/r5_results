<div class="card-body">
    <h3>Importer une classe</h3>
    <!--begin::Input group-->
    <div class="form-group row">
        <!--begin::Label-->
        <div class="mb-4">
            <a href="/doc/exemple_import_R5.xlsx" class="btn btn-secondary" download>Télécharger le fichier d'exemple</a>
            <p class="text-danger">Attention, le fichier d'import doit contenir les colonnes suivantes Nom, Prenom, Sexe, Annee naissance et Distance</p>
        </div>
        <!--end::Label-->

        <!--begin::Col-->
        <div class="col-lg-10">
            <!--begin::Dropzone-->
            <div class="dropzone dropzone-queue mb-2" id="kt_dropzonejs_example_2">

                <form action="/importExcel" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($classeId) ?>">
                    <input type="hidden" name="saison" value="<?= htmlspecialchars($saison) ?>">
                    <input type="hidden" name="epreuve" value="<?= htmlspecialchars($epreuve) ?>">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    <input type="file" name="excel_file" accept=".xls, .xlsx">
                    <button class="btn btn-primary" type="submit">Importer</button>
                </form>

            </div>
            <!--end::Items-->
        </div>
        <!--end::Dropzone-->

        <!--begin::Hint-->
        <span class="form-text text-muted">Limité à 1 fichier en xls ou xlsx avec une taille max de 10 Mo.</span>
        <!--end::Hint-->
    </div>
    <!--end::Col-->
</div>