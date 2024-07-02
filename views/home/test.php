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
                            <i class="fa-solid fa-user-plus"></i> Ajouter un utilisateur
                        </a>

                        <a href="#" class="btn btn-danger d-flex flex-center flex-shrink-0 ms-4 h-40px" data-bs-toggle="modal" data-bs-target="#kt_modal_create_project">
                            <i class="fa-solid fa-users"></i> Ajouter une classe
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <div id="kt_app_content_container" class="app-container  container-fluid ">
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <div class="col-xxl-6 mb-lg-5 mb-xl-10">
                        <div class="card card-flush mb-5 mb-xl-10 h-lg-50">
                            <div class="card-header pt-5">
                                <div class="card-title d-flex flex-row-fluid flex-stack">
                                    <div class="d-flex flex-column">
                                        <a href="/keen/demo8/pages/user-profile/overview.html" class="text-hover-primary mb-2 fw-bold text-gray-800 fs-3">
                                            New Customers
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
                                        <a href="/keen/demo8/pages/user-profile/overview.html" class="opacity-75-hover mb-2 fw-bold text-white fs-3">Sales Increase</a>
                                        <span class="fs-6 text-light-success fs-semibase">
                                            92 Daily Avg.
                                        </span>
                                    </div>
                                    <span class="text-white fw-bold fs-2x">75%</span>
                                </div>
                            </div>
                            <div class="card-body d-flex align-items-end pt-0">
                                <div class="d-flex flex-column mt-3 w-100">
                                    <span class="fw-semibase fs-6 text-white mb-2">Progress</span>

                                    <div class="h-6px w-100 rounded" style="background-color:#DFF6F2">
                                        <div class="bg-white rounded h-6px" role="progressbar" style="width: 62%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6">
                        <div class="card card-flush h-md-100">
                            <div class="card-header border-0 pt-7">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-900">Top Products</span>

                                    <span class="text-muted mt-3 fw-semibold fs-6">240,000 Total Sales</span>
                                </h3>
                                <div class="card-toolbar">
                                    <button class="btn btn-icon btn-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">

                                        <i class="ki-outline ki-dots-square fs-2x"></i>
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
                                        </div>
                                        <div class="separator mb-3 opacity-75"></div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Ticket
                                            </a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Customer
                                            </a>
                                        </div>
                                        <div class="menu-item px-3" data-kt-menu-trigger="hover" data-kt-menu-placement="right-start">
                                            <a href="#" class="menu-link px-3">
                                                <span class="menu-title">New Group</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Admin Group
                                                    </a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Staff Group
                                                    </a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3">
                                                        Member Group
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3">
                                                New Contact
                                            </a>
                                        </div>
                                        <div class="separator mt-3 opacity-75"></div>
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3 py-3">
                                                <a class="btn btn-primary  btn-sm px-4" href="#">
                                                    Generate Reports
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-7 pb-5">
                                <div class="bgi-no-repeat bgi-size-cover rounded min-h-250px mb-7" style="background-image:url('/keen/demo8/assets/media/stock/900x600/16.jpg');">
                                </div>
                                <a href="/keen/demo8/pages/user-profile/projects.html" class="text-hover-primary fw-semibold text-gray-900 fs-3">Keen Admin Launch Day</a>
                                <div class="text-gray-600 fw-normal pt-3">
                                    You also need to be able to accept that not every post is going to get your motor running. Some posts will feel like
                                </div>
                            </div>
                            <div class="card-footer pt-0">
                                <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                    <div class="col-xl-4">
                        <div class="card card-flush h-xl-100">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-gray-900">Active Lessons</span>

                                    <span class="text-muted mt-1 fw-semibold fs-7">Avg. 72% completed lessons</span>
                                </h3>
                                <div class="card-toolbar">
                                    <a href="#" class="btn btn-sm btn-light">All Lessons</a>
                                </div>
                            </div>
                            <div class="card-body pt-5">
                                <div class="d-flex flex-stack">
                                    <div class="d-flex align-items-center me-3">
                                        <img src="/keen/demo8/assets/media/svg/brand-logos/laravel-2.svg" class="me-4 w-30px" alt="" />
                                        <div class="flex-grow-1">
                                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Laravel</a>
                                            <span class="text-gray-500 fw-semibold d-block fs-6">PHP Framework</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center w-100 mw-125px">
                                        <div class="progress h-6px w-100 me-2 bg-light-success">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="text-gray-500 fw-semibold">
                                            65%
                                        </span>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>
                                <div class="d-flex flex-stack">
                                    <div class="d-flex align-items-center me-3">
                                        <img src="/keen/demo8/assets/media/svg/brand-logos/vue-9.svg" class="me-4 w-30px" alt="" />
                                        <div class="flex-grow-1">
                                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Vue 3</a>
                                            <span class="text-gray-500 fw-semibold d-block fs-6">JS Framework</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center w-100 mw-125px">
                                        <div class="progress h-6px w-100 me-2 bg-light-warning">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 87%" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="text-gray-500 fw-semibold">
                                            87%
                                        </span>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>
                                <div class="d-flex flex-stack">
                                    <div class="d-flex align-items-center me-3">
                                        <img src="/keen/demo8/assets/media/svg/brand-logos/bootstrap5.svg" class="me-4 w-30px" alt="" />
                                        <div class="flex-grow-1">
                                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Bootstrap 5</a>
                                            <span class="text-gray-500 fw-semibold d-block fs-6">CSS Framework</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center w-100 mw-125px">
                                        <div class="progress h-6px w-100 me-2 bg-light-primary">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 44%" aria-valuenow="44" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="text-gray-500 fw-semibold">
                                            44%
                                        </span>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>
                                <div class="d-flex flex-stack">
                                    <div class="d-flex align-items-center me-3">
                                        <img src="/keen/demo8/assets/media/svg/brand-logos/angular-icon.svg" class="me-4 w-30px" alt="" />
                                        <div class="flex-grow-1">
                                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Angular 16</a>
                                            <span class="text-gray-500 fw-semibold d-block fs-6">JS Framework</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center w-100 mw-125px">
                                        <div class="progress h-6px w-100 me-2 bg-light-info">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="text-gray-500 fw-semibold">
                                            70%
                                        </span>
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-3"></div>
                                <div class="d-flex flex-stack">
                                    <div class="d-flex align-items-center me-3">
                                        <img src="/keen/demo8/assets/media/svg/brand-logos/spring-3.svg" class="me-4 w-30px" alt="" />
                                        <div class="flex-grow-1">
                                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold lh-0">Spring</a>
                                            <span class="text-gray-500 fw-semibold d-block fs-6">Java Framework</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center w-100 mw-125px">
                                        <div class="progress h-6px w-100 me-2 bg-light-danger">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 56%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="text-gray-500 fw-semibold">
                                            56%
                                        </span>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card h-xl-100">
                            <div class="card-header border-0 pt-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold fs-3 mb-1">Authors Earnings</span>
                                    <span class="text-muted mt-1 fw-semibold fs-7">More than 400 new authors</span>
                                </h3>
                            </div>
                            <div class="card-body py-3">
                                <div class="tab-content">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>