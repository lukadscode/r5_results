<?php

$pdo = \App\Connection::getPDO();


// Traitement des actions CRUD pour les catégories
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_name'])) {
    $categoryName = $_POST['category_name'];

    // Ajouter une nouvelle catégorie
    if (!empty($categoryName)) {
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->execute(['name' => $categoryName]);
    }

    header('Location: ' . $_SERVER['PATH_INFO']);
    exit;
}

// Traitement des actions CRUD pour les sous-catégories
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subcategory_name'])) {
    $subcategoryName = $_POST['subcategory_name'];
    $categoryId = $_POST['category_id'];

    // Ajouter une nouvelle sous-catégorie à la catégorie sélectionnée
    if (!empty($subcategoryName) && !empty($categoryId)) {
        $stmt = $pdo->prepare("INSERT INTO subcategories (category_id, name) VALUES (:category_id, :name)");
        $stmt->execute(['category_id' => $categoryId, 'name' => $subcategoryName]);
    }

    header('Location: ' . $_SERVER['PATH_INFO']);
    exit;
}

// Suppression d'une catégorie (et suppression en cascade des sous-catégories associées)
if (isset($_GET['delete_category_id'])) {
    $categoryId = $_GET['delete_category_id'];
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");
    $stmt->execute(['id' => $categoryId]);

    header('Location: ' . $_SERVER['PATH_INFO']);
    exit;
}

// Suppression d'une sous-catégorie
if (isset($_GET['delete_subcategory_id'])) {
    $subcategoryId = $_GET['delete_subcategory_id'];
    $stmt = $pdo->prepare("DELETE FROM subcategories WHERE id = :id");
    $stmt->execute(['id' => $subcategoryId]);

    header('Location: ' . $_SERVER['PATH_INFO']);
    exit;
}

// Récupérer toutes les catégories (tableaux associatifs)
$categoriesStmt = $pdo->query("SELECT * FROM categories ORDER BY name");
$categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer toutes les sous-catégories avec leurs catégories (tableaux associatifs)
$subcategoriesStmt = $pdo->query("
    SELECT s.id as subcategory_id, s.name as subcategory_name, s.category_id, c.name as category_name
    FROM subcategories s
    JOIN categories c ON s.category_id = c.id
    ORDER BY c.name, s.name
");
$subcategories = $subcategoriesStmt->fetchAll(PDO::FETCH_ASSOC);

// Combiner catégories et sous-catégories
$combinedList = [];

// Ajouter les catégories à la liste combinée
foreach ($categories as $category) {
    $combinedList[] = [
        'type' => 'category',
        'id' => $category['id'],
        'name' => $category['name'],
    ];

    // Ajouter les sous-catégories pour cette catégorie
    foreach ($subcategories as $subcategory) {
        if ($subcategory['category_id'] == $category['id']) {
            $combinedList[] = [
                'type' => 'subcategory',
                'id' => $subcategory['subcategory_id'],
                'name' => $subcategory['subcategory_name'],
                'category_name' => $subcategory['category_name'], // pour affichage
            ];
        }
    }
}
?>

<div class="app-main flex-column flex-row-fluid " id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar ">
            <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex flex-stack ">
                <div class="page-title d-flex flex-column justify-content-center me-3 mb-6 mb-lg-0">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">
                        Padlet
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="/keen/demo8/index.html" class="text-muted text-hover-primary">
                                Accueil </a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            Padlet </li>

                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <div class="d-flex">

                        <a href="#" class="btn btn-danger d-flex flex-center flex-shrink-0 ms-4 h-40px" data-bs-toggle="modal" data-bs-target="#kt_modal_new_address">
                            <i class="fa-solid fa-users"></i> Documents
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <div id="kt_app_content" class="app-content  flex-column-fluid ">
            <div id="kt_app_content_container" class="app-container  container-fluid ">
                <h1>Gestion des Catégories et Sous-catégories</h1>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Formulaire pour ajouter une catégorie -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="mb-3">
                                        <label for="category_name" class="form-label">Nom de la catégorie</label>
                                        <input type="text" class="form-control" id="category_name" name="category_name" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Ajouter la catégorie</button>
                                </form>
                            </div>
                        </div>

                        <!-- Formulaire pour ajouter une sous-catégorie -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Sélectionner une catégorie</label>
                                        <select class="form-select" id="category_id" name="category_id" required>
                                            <option value="">Choisir une catégorie</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="subcategory_name" class="form-label">Nom de la sous-catégorie</label>
                                        <input type="text" class="form-control" id="subcategory_name" name="subcategory_name" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Ajouter la sous-catégorie</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card card-flush ">
                                <div class="card-header pt-5">
                                    <h2>Liste des catégories et sous-catégories</h2>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <?php foreach ($combinedList as $item): ?>
                                            <li class="list-group-item d-flex justify-content-between align-items-center" style="<?php echo $item['type'] == 'subcategory' ? 'padding-left: 30px;' : ''; ?>">
                                                <?php
                                                if ($item['type'] == 'category') {
                                                    echo htmlspecialchars($item['name']);
                                                } else {
                                                    echo htmlspecialchars($item['name']);
                                                }
                                                ?>
                                                <a href="?delete_<?php echo $item['type']; ?>_id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger">Supprimer</a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>