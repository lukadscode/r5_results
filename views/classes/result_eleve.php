<?php

// Inclure vos dépendances et initialiser la connexion PDO

use App\Models\Eleve;
use App\Models\Classe;
use App\Connection;

// Connexion à la base de données
$pdo = Connection::getPDO(); // Assurez-vous d'utiliser correctement votre classe de connexion


$token = $params['token'] ?? null;

// Instanciation du modèle de Classe
$classeModel = new Classe($pdo);

// Récupération des détails de la classe à partir du token
$classe = $classeModel->getClasseByToken($token);

// Récupération de l'identifiant de la classe
$classeId = $classe['id'];

// Instanciation du modèle d'Eleve avec l'identifiant de la classe
$eleveModel = new Eleve($pdo);
$eleveModel->setClasseId($classeId); // Assurez-vous que votre modèle d'Eleve peut utiliser l'identifiant de la classe

// Récupération de tous les élèves associés à la classe
$eleves = $eleveModel->getAllElevesByClasse();

?>
<div class="card-header align-items-center py-5 gap-2 gap-md-5">
    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
        <!--begin::Export dropdown-->
        <button type="button" class="btn btn-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
            <i class="ki-duotone ki-exit-down fs-2"><span class="path1"></span><span class="path2"></span></i>
            Export classe
        </button>
        <!--begin::Menu-->
        <div id="kt_datatable_example_export_menu" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-kt-export="copy">
                    Copy to clipboard
                </a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-kt-export="excel">
                    Export as Excel
                </a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-kt-export="csv">
                    Export as CSV
                </a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-kt-export="pdf">
                    Export as PDF
                </a>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::Menu-->
        <!--end::Export dropdown-->

        <!--begin::Hide default export buttons-->
        <div id="kt_datatable_example_buttons" class="d-none"></div>
    </div>
</div>
<div class="card-body">
    <table class="table align-middle rounded table-row-dashed fs-6 g-5" id="kt_datatable_example">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase">
                <th class="text-center min-w-100px">N°</th>
                <th class="text-center min-w-100px">Nom</th>
                <th class="text-center min-w-100px">Prénom</th>
                <th class="text-center min-w-100px">Sexe</th>
                <th class="text-center">Année naiss.</th>
                <th class="text-center">Distance</th>
                <th class="text-center min-w-100px pe-5">Action</th>
            </tr>
        </thead>
        <tbody class="fw-semibold text-gray-600">
            <?php foreach ($eleves as $key => $eleve) : ?>
                <tr class="<?= $key % 2 == 0 ? 'even' : 'odd' ?>">
                    <td class="text-center">
                        <a href="#" class="text-gray-900 text-hover-primary"><?= $key + 1 ?></a>
                    </td>
                    <td class="text-center">
                        <a href="#" class="text-gray-900 text-hover-primary text-uppercase"><?= htmlspecialchars($eleve['nom']) ?></a>
                    </td>
                    <td class="text-center text-uppercase"><?= htmlspecialchars($eleve['prenom']) ?></td>
                    <td class="text-center"><?= htmlspecialchars($eleve['sexe']) ?></td>
                    <td class="text-center pe-0"><?= htmlspecialchars($eleve['annee_naissance']) ?></td>
                    <td class="text-center pe-0">
                        <div class="badge badge-light-success"><?= htmlspecialchars($eleve['distance']) ?></div>
                    </td>
                    <td class="text-center mx-auto">
                        <form action="/deleteEleve" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ?');">
                            <input type="hidden" name="eleve_id" value="<?= $eleve['id'] ?>">
                            <input type="hidden" name="classe_token" value="<?= $classe['token'] ?>">
                            <button type="submit" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                                <i class="fa-solid fa-trash text-danger h3 px-3"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    "use strict";

    // Class definition
    var KTDatatablesExample = function() {
        // Shared variables
        var table;
        var datatable;

        // Private functions
        var initDatatable = function() {
            // Set date data order
            const tableRows = table.querySelectorAll('tbody tr');

            tableRows.forEach(row => {
                const dateRow = row.querySelectorAll('td');
                const realDate = moment(dateRow[3].innerHTML, "DD MMM YYYY, LT").format(); // select date from 4th column in table
                dateRow[3].setAttribute('data-order', realDate);
            });

            // Init datatable --- more info on datatables: https://datatables.net/manual/
            datatable = $(table).DataTable({
                "info": false,
                'order': [],
                'pageLength': 10,
            });
        }

        // Hook export buttons
        var exportButtons = () => {
            const documentTitle = 'Customer Orders Report';
            var buttons = new $.fn.dataTable.Buttons(table, {
                buttons: [{
                        extend: 'copyHtml5',
                        title: documentTitle
                    },
                    {
                        extend: 'excelHtml5',
                        title: documentTitle
                    },
                    {
                        extend: 'csvHtml5',
                        title: documentTitle
                    },
                    {
                        extend: 'pdfHtml5',
                        title: documentTitle
                    }
                ]
            }).container().appendTo($('#kt_datatable_example_buttons'));

            // Hook dropdown menu click event to datatable export buttons
            const exportButtons = document.querySelectorAll('#kt_datatable_example_export_menu [data-kt-export]');
            exportButtons.forEach(exportButton => {
                exportButton.addEventListener('click', e => {
                    e.preventDefault();

                    // Get clicked export value
                    const exportValue = e.target.getAttribute('data-kt-export');
                    const target = document.querySelector('.dt-buttons .buttons-' + exportValue);

                    // Trigger click event on hidden datatable export buttons
                    target.click();
                });
            });
        }

        // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
        var handleSearchDatatable = () => {
            const filterSearch = document.querySelector('[data-kt-filter="search"]');
            filterSearch.addEventListener('keyup', function(e) {
                datatable.search(e.target.value).draw();
            });
        }

        // Public methods
        return {
            init: function() {
                table = document.querySelector('#kt_datatable_example');

                if (!table) {
                    return;
                }

                initDatatable();
                exportButtons();
                handleSearchDatatable();
            }
        };
    }();

    // On document ready
    KTUtil.onDOMContentLoaded(function() {
        KTDatatablesExample.init();
    });
</script>