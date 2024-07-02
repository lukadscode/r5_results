<div class="app-main flex-column flex-row-fluid " id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar ">
            <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack ">
                <div class="page-title d-flex flex-column justify-content-center me-3 mb-6 mb-lg-0">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">
                        Classe 5e4 - Collège Henri IV
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
                            Classe </li>

                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <div class="d-flex">
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
                    <div class="card">
                        <div class="card-header border-0 pt-7">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-900">Information établissement</span>
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label for="form-label">Choisir l'établissement</label>
                                        <select class="form-select" data-placeholder="Select an option">
                                            <option>Choisir ...</option>
                                            <option value="1">Option 1</option>
                                            <option value="2">Option 2</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="form-label">Choisir la structure</label>
                                        <select class="form-select" data-placeholder="Select an option">
                                            <option>Choisir ...</option>
                                            <option value="1">Option 1</option>
                                            <option value="2">Option 2</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label for="" class="form-label">Classe</label>
                                        <input type="text" class="form-control" placeholder="5e3" />
                                    </div>
                                </div>
                                <hr>
                                <h6>Information sur le responsable pédagogique</h6>
                                <hr>
                                <div class="row">
                                    <div class="mb-7 col-md-4">
                                        <label classe="form">Nom et prénom</label>
                                        <input type="text" class="form-control" id="floatingInput" placeholder="DUPONT Jean" />
                                    </div>
                                    <div class="mb-7 col-md-4">
                                        <label classe="form">E-mail</label>
                                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" />
                                    </div>
                                    <div class="mb-7 col-md-4">
                                        <label classe="form">Numero de téléphone</label>
                                        <input type="text" class="form-control" id="floatingInput" placeholder="06 XX XX XX XX" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12  mb-5 mb-xl-10">
                    <div class="card">
                        <div class="card-header border-0 pt-7">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-900">Ajouter un élève</span>
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">

                                <div class="row">
                                    <div class="mb-7 col-md-3">
                                        <label classe="form">Nom</label>
                                        <input type="text" class="form-control" id="floatingInput" placeholder="DUPONT" />
                                    </div>
                                    <div class="mb-7 col-md-3">
                                        <label classe="form">Prénom</label>
                                        <input type="text" class="form-control" id="floatingInput" placeholder="Jean" />
                                    </div>
                                    <div class="mb-7 col-md-2">
                                        <label classe="form">Sexe</label>
                                        <input type="text" class="form-control" id="floatingInput" placeholder="H ou F" />
                                    </div>
                                    <div class="mb-7 col-md-2">
                                        <label classe="form">Année naissance</label>
                                        <input type="text" class="form-control" id="floatingInput" placeholder="2011" />
                                    </div>
                                    <div class="mb-7 col-md-2">
                                        <label classe="form">Distance</label>
                                        <input type="text" class="form-control" id="floatingInput" placeholder="306" />
                                    </div>
                                    <button class="btn bg-blueffa text-white">Ajouter</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <h3>Importer une classe</h3>
                        </div>
                    </div>
                </div>
                <div class=" row g-5 g-xl-10 mb-5 mb-xl-10">
                    <div class="col-xxl-2 ">
                        <div class="card card-flush bg-primary ">
                            <div class="card-body p-3">
                                <div class=" d-flex flex-column text-white">
                                    <h3 class="text-center fs-lg-2tx fw-bold text-white"> <span data-kt-countup="true" data-kt-countup-value="14">14</span></h3>
                                    <h6 class="text-center text-white"> <span>Garçons</span></h6>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-2 ">
                        <div class="card card-flush bg-danger ">
                            <div class="card-body p-3">
                                <div class=" d-flex flex-column text-white">
                                    <h3 class="text-center fs-lg-2tx fw-bold text-white"> <span data-kt-countup="true" data-kt-countup-value="12">12</span></h3>
                                    <h6 class="text-center text-white"> <span>Filles</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-2 ">
                        <div class="card card-flush ">
                            <div class="card-body p-3">
                                <div class=" d-flex flex-column ">
                                    <h3 class="text-center fs-lg-2tx fw-bold "> <span data-kt-countup="true" data-kt-countup-value="8470">8470m</span></h3>
                                    <h6 class="text-center ">Distance total</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-2 ">
                        <div class="card card-flush ">
                            <div class="card-body p-3">
                                <div class=" d-flex flex-column ">
                                    <h3 class="text-center fs-lg-2tx fw-bold "> <span data-kt-countup="true" data-kt-countup-value="605">605.00m</span></h3>
                                    <h6 class="text-center ">Distance moyenne</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-2 ">
                        <div class="card card-flush ">
                            <div class="card-body p-3">
                                <div class=" d-flex flex-column ">
                                    <h3 class="text-center fs-lg-2tx fw-bold "> <span data-kt-countup="true" data-kt-countup-value="8530">8530m</span></h3>
                                    <h6 class="text-center ">Distance totale pondérée</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-2 ">
                        <div class="card card-flush ">
                            <div class="card-body p-3">
                                <div class=" d-flex flex-column ">
                                    <h3 class="text-center fs-lg-2tx fw-bold "> <span data-kt-countup="true" data-kt-countup-value="609.29">609.29m</span></h3>
                                    <h6 class="text-center ">Distance moyenne pondérée</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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



    <!--begin Modal Add classes-->
    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Ajouter une classe</h3>

                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>

                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="form-label">Choisir l'établissement</label>
                            <select class="form-select" data-placeholder="Select an option">
                                <option>Choisir ...</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="form-label">Choisir la structure</label>
                            <select class="form-select" data-placeholder="Select an option">
                                <option>Choisir ...</option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Classe</label>
                            <input type="text" class="form-control" placeholder="5e3" />
                        </div>
                        <hr>
                        <h6>Information sur le responsable pédagogique</h6>
                        <hr>
                        <div class="form-floating mb-7">
                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" />
                            <label for="floatingInput">Nom et prénom</label>
                        </div>
                        <div class="form-floating mb-7">
                            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" />
                            <label for="floatingInput">E-mail</label>
                        </div>
                        <div class="form-floating mb-7">
                            <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com" />
                            <label for="floatingInput">Numero de téléphone</label>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary bg-blueffa">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>