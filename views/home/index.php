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
                        <a href="#" class="btn btn-icon bg-body ms-4 flex-shrink-0 h-40px" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">
                            <i class="fa-solid fa-gear"></i>
                        </a>

                        <a href="#" class="btn btn-color-gray-700 bg-body d-flex flex-center flex-shrink-0 ms-4 h-40px" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">
                            <i class="fa-solid fa-plus"></i> Ajouter un utilisateur
                        </a>

                        <a href="#" class="btn btn-danger d-flex flex-center flex-shrink-0 ms-4 h-40px" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                            <i class="fa-solid fa-users"></i> Ajouter un classe
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <div id="kt_app_content_container" class="app-container  container-fluid ">
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <div class="col-xxl-2 ">
                        <div class="card card-flush bg-primary ">
                            <div class="card-body p-3">
                                <div class=" d-flex flex-column text-white">
                                    <h3 class="text-center fs-lg-2tx fw-bold text-white"> <span data-kt-countup="true" data-kt-countup-value="1254">1254</span></h3>
                                    <h6 class="text-center text-white"> <span>Garçons</span></h6>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-2 ">
                        <div class="card card-flush bg-danger ">
                            <div class="card-body p-3">
                                <div class=" d-flex flex-column text-white">
                                    <h3 class="text-center fs-lg-2tx fw-bold text-white"> <span data-kt-countup="true" data-kt-countup-value="1254">1254</span></h3>
                                    <h6 class="text-center text-white"> <span>Filles</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-2 ">
                        <div class="card card-flush ">
                            <div class="card-body p-3">
                                <div class=" d-flex flex-column ">
                                    <h3 class="text-center fs-lg-2tx fw-bold "> <span data-kt-countup="true" data-kt-countup-value="750">750</span></h3>
                                    <h6 class="text-center "> Classes</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <div class="col-xxl-6 mb-lg-5 mb-xl-10">
                        <div class="card card-flush mb-5 mb-xl-10 h-lg-50">
                            <div class="card-header pt-5">
                                <div class="card-title d-flex flex-row-fluid flex-stack">
                                    <div class="d-flex flex-column">
                                        <a href="/keen/demo8/pages/user-profile/overview.html" class="text-hover-primary mb-2 fw-bold text-gray-800 fs-3">
                                            New Customers
                                        </a>
                                        <span class="fs-6 text-gray-500 fs-semibase">
                                            28 Daily Avg.
                                        </span>
                                    </div>
                                    <span class="text-gray-800 fw-bold fs-2x">+958</span>
                                </div>
                            </div>
                            <div class="card-body d-flex align-items-end flex-row-fluid p-0">
                                <div class="card-rounded-bottom w-100" id="kt_charts_widget_44" data-kt-chart-color="danger" style="height: 120px"></div>
                            </div>
                        </div>
                        <div class="card card-flush bg-success h-lg-50">
                            <div class="card-header pt-5">
                                <div class="card-title d-flex flex-row-fluid flex-stack">
                                    <div class="d-flex flex-column">
                                        <a href="/keen/demo8/pages/user-profile/overview.html" class="opacity-75-hover mb-2 fw-bold text-white fs-3">Classes</a>
                                        <span class="fs-6 text-light-success fs-semibase">
                                            28 000 élèves.
                                        </span>
                                    </div>
                                    <span class="text-white fw-bold fs-2x">75%</span>
                                </div>
                            </div>
                            <div class="card-body d-flex align-items-end pt-0">
                                <div class="d-flex flex-column mt-3 w-100">
                                    <span class="fw-semibase fs-6 text-white mb-2">Progress</span>

                                    <div class="h-6px w-100 rounded" style="background-color:#DFF6F2">
                                        <div class="bg-black rounded h-6px" role="progressbar" style="width: 62%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6">
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
                        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                            <div class="col-md-3 ">
                                <div class="card card-flush">
                                    <div class="card-header ribbon ribbon-top ribbon-vertical">
                                        <div class="ribbon-label bg-success">
                                            VALIDE
                                        </div>
                                        <div class="card-title d-flex flex-column">
                                            <h3>5e5</h3>
                                            <small class="text-muted">Collège Anceau de Garlande</small>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class=" d-flex flex-column p-3">
                                            <div class="row text-center">
                                                <div class="col-md-6">
                                                    <h3>1200</h3>
                                                    <span>Garçons</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <h3>30</h3>
                                                    <span>Filles</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-blueffa p-3">
                                        <h5 class="text-center text-white">Voir</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="card card-flush">
                                    <div class="card-header ribbon ribbon-top ribbon-vertical">
                                        <div class="ribbon-label bg-warning ">
                                            EN COURS
                                        </div>
                                        <div class="card-title d-flex flex-column">
                                            <h3>5e6</h3>
                                            <small class="text-muted">Collège Anceau de Garlande</small>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class=" d-flex flex-column p-3">
                                            <div class="row text-center">
                                                <div class="col-md-6">
                                                    <h3>1200</h3>
                                                    <span>Garçons</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <h3>30</h3>
                                                    <span>Filles</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-blueffa p-3">
                                        <h5 class="text-center text-white">Voir ou modifier</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <div class="card card-flush">
                                    <div class="card-header ribbon ribbon-top ribbon-vertical">
                                        <div class="ribbon-label bg-danger">
                                            REFUSE
                                        </div>
                                        <div class="card-title d-flex flex-column">
                                            <h3>5e7</h3>
                                            <small class="text-muted">Collège Anceau de Garlande</small>
                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class=" d-flex flex-column p-3">
                                            <div class="row text-center">
                                                <div class="col-md-6">
                                                    <h3>1200</h3>
                                                    <span>Garçons</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <h3>30</h3>
                                                    <span>Filles</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="/classe">
                                        <div class="card-footer bg-blueffa p-3">
                                            <h5 class="text-center text-white">Voir ou modifier</h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
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
                        <label for="form-label">Choisir l'établissement scolaire</label>
                        <select class="form-select" data-placeholder="Select an option">
                            <option>Choisir ...</option>
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="form-label">Club d'Aviron partenaire</label>
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
                    <h6>Information sur le professeur d'EPS</h6>
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