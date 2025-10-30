<?php

use App\Connection;

// Connexion à la base de données
$pdo = Connection::getPDO();

// Récupérer toutes les catégories et leurs sous-catégories
$categoriesStmt = $pdo->query("SELECT * FROM categories ORDER BY name");
$categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer tous les articles
$articlesStmt = $pdo->query("SELECT * FROM articles ORDER BY creation_date DESC");
$articles = $articlesStmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer toutes les sous-catégories pour chaque catégorie
$subcategories = [];
foreach ($categories as $category) {
    $subcategoryStmt = $pdo->prepare("SELECT * FROM subcategories WHERE category_id = :category_id ORDER BY name");
    $subcategoryStmt->execute(['category_id' => $category['id']]);
    $subcategories[$category['id']] = $subcategoryStmt->fetchAll(PDO::FETCH_ASSOC);
}

// Regrouper les articles par sous-catégorie
$articlesBySubcategory = [];
foreach ($articles as $article) {
    $subcategoryId = $article['subcategory_id'];
    if ($subcategoryId) {
        $articlesBySubcategory[$subcategoryId][] = $article;
    }
}

// Regrouper les articles par catégorie
$articlesByCategory = [];
foreach ($categories as $category) {
    $articlesByCategory[$category['id']] = [
        'category' => $category,
        'subcategories' => []
    ];

    foreach ($subcategories[$category['id']] as $subcategory) {
        $articlesByCategory[$category['id']]['subcategories'][$subcategory['id']] = [
            'subcategory' => $subcategory,
            'articles' => $articlesBySubcategory[$subcategory['id']] ?? []
        ];
    }
}

?>

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar">
            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center me-3 mb-6 mb-lg-0">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">
                        Padlet
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="/keen/demo8/index.html" class="text-muted text-hover-primary">Accueil</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Padlet</li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <div class="d-flex">
                        <a href="/padlet/categorie" class="btn btn-color-gray-700 bg-body d-flex flex-center flex-shrink-0 ms-4 h-40px">
                            <i class="fa-solid fa-plus"></i> Catégorie
                        </a>
                        <a href="#" class="btn btn-danger d-flex flex-center flex-shrink-0 ms-4 h-40px" data-bs-toggle="modal" data-bs-target="#kt_modal_new_address">
                            <i class="fa-solid fa-users"></i> Documents
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                    <li class="nav-item">
                        <a class="nav-link active h3" data-bs-toggle="tab" href="#kt_tab_pane_all">
                            <h3>Tous les articles</h3>
                        </a>
                    </li>
                    <?php foreach ($categories as $category): ?>
                        <li class="nav-item">
                            <a class="nav-link h3" data-bs-toggle="tab" href="#kt_tab_pane_<?php echo $category['id']; ?>">
                                <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <!-- Onglet Tous les articles -->
                    <div class="tab-pane fade show active" id="kt_tab_pane_all" role="tabpanel">
                        <?php foreach ($articlesByCategory as $categoryId => $categoryData): ?>
                            <h4><?php echo htmlspecialchars($categoryData['category']['name']); ?></h4>
                            <?php foreach ($categoryData['subcategories'] as $subcategoryId => $subcategoryData): ?>
                                <h5><?php echo htmlspecialchars($subcategoryData['subcategory']['name']); ?></h5>
                                <div class="row">
                                    <?php foreach ($subcategoryData['articles'] as $article): ?>
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-xl-100">
                                                <div class="card-header border-0">
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="card-label fw-bold fs-5"><?php echo htmlspecialchars($article['title']); ?></span>
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($article['content']); ?></h6>

                                                    <!-- Afficher le contenu du type d'article -->
                                                    <?php if ($article['type'] == 'youtube'): ?>
                                                        <iframe width="100%" height="200" src="<?php echo htmlspecialchars($article['link']); ?>" frameborder="0" allowfullscreen></iframe>
                                                    <?php elseif ($article['type'] == 'pdf'): ?>
                                                        <embed src="<?php echo htmlspecialchars($article['link']); ?>" type="application/pdf" width="100%" height="200" />
                                                    <?php elseif ($article['type'] == 'image'): ?>
                                                        <img src="<?php echo htmlspecialchars($article['link']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($article['title']); ?>" />
                                                    <?php endif; ?>

                                                    <p class="text-muted mt-2"><?php echo date('d-m-Y', strtotime($article['creation_date'])); ?></p>
                                                    <a href="?delete_article_id=<?php echo $article['id']; ?>" class="btn btn-sm btn-danger mt-2">Supprimer</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- Onglets pour chaque catégorie -->
                    <?php foreach ($articlesByCategory as $categoryId => $categoryData): ?>
                        <div class="tab-pane fade" id="kt_tab_pane_<?php echo $categoryId; ?>" role="tabpanel">
                            <?php foreach ($categoryData['subcategories'] as $subcategoryId => $subcategoryData): ?>
                                <h5><?php echo htmlspecialchars($subcategoryData['subcategory']['name']); ?></h5>
                                <div class="row">
                                    <?php foreach ($subcategoryData['articles'] as $article): ?>
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-xl-100">
                                                <div class="card-header border-0">
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="card-label fw-bold fs-5"><?php echo htmlspecialchars($article['title']); ?></span>
                                                    </h3>
                                                </div>
                                                <div class="card-body">
                                                    <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($article['content']); ?></h6>

                                                    <!-- Afficher le contenu du type d'article -->
                                                    <?php if ($article['type'] == 'youtube'): ?>
                                                        <iframe width="100%" height="200" src="<?php echo htmlspecialchars($article['link']); ?>" frameborder="0" allowfullscreen></iframe>
                                                    <?php elseif ($article['type'] == 'pdf'): ?>
                                                        <embed src="<?php echo htmlspecialchars($article['link']); ?>" type="application/pdf" width="100%" height="200" />
                                                    <?php elseif ($article['type'] == 'image'): ?>
                                                        <img src="<?php echo htmlspecialchars($article['link']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($article['title']); ?>" />
                                                    <?php endif; ?>

                                                    <p class="text-muted mt-2"><?php echo date('d-m-Y', strtotime($article['creation_date'])); ?></p>
                                                    <a href="?delete_article_id=<?php echo $article['id']; ?>" class="btn btn-sm btn-danger mt-2">Supprimer</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>