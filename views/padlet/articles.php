<?php

$pdo = \App\Connection::getPDO();

// Traitement des actions CRUD pour les articles
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $type = $_POST['type'];
    $categoryId = $_POST['category_id'] ?? null;
    $subcategoryId = !empty($_POST['subcategory_id']) ? $_POST['subcategory_id'] : null; // Assurez-vous d'utiliser NULL ici

    // Initialisation des variables pour les fichiers
    $filePath = null;

    // Gestion des différents types d'articles
    if ($type === 'video') {
        // Validation du lien YouTube
        if (filter_var($_POST['youtube_link'], FILTER_VALIDATE_URL)) {
            $filePath = $_POST['youtube_link'];
        } else {
            echo "<div class='alert alert-danger'>Le lien de la vidéo YouTube est invalide.</div>";
        }
    } elseif ($type === 'pdf') {
        // Gestion de l'upload d'un fichier PDF
        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['pdf_file']['tmp_name'];
            $fileName = $_FILES['pdf_file']['name'];
            $filePath = 'uploads/pdfs/' . basename($fileName);
            move_uploaded_file($fileTmpPath, $filePath);
        }
    } elseif ($type === 'image') {
        // Gestion de l'upload d'une image
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image_file']['tmp_name'];
            $fileName = $_FILES['image_file']['name'];
            $filePath = 'uploads/images/' . basename($fileName);
            move_uploaded_file($fileTmpPath, $filePath);
        }
    }

    // Ajouter un nouvel article si le chemin du fichier est valide
    if (!empty($title) && !empty($content) && !empty($type) && !empty($filePath)) {
        // Préparez et exécutez l'insertion
        $stmt = $pdo->prepare("INSERT INTO articles (title, content, type, link, category_id, subcategory_id) VALUES (:title, :content, :type, :link, :category_id, :subcategory_id)");
        $stmt->execute([
            'title' => $title,
            'content' => $content,
            'type' => $type,
            'link' => $filePath, // Stocke le lien ou le chemin du fichier ici
            'category_id' => $categoryId,
            'subcategory_id' => $subcategoryId, // ici NULL si non sélectionné
        ]);
    }

    header('Location: ' . $_SERVER['PHP_INFO']);
    exit;
}

// Suppression d'un article
if (isset($_GET['delete_article_id'])) {
    $articleId = $_GET['delete_article_id'];
    $stmt = $pdo->prepare("DELETE FROM articles WHERE id = :id");
    $stmt->execute(['id' => $articleId]);

    header('Location: ' . $_SERVER['PHP_INFO']);
    exit;
}

// Récupérer tous les articles
$articlesStmt = $pdo->query("SELECT * FROM articles ORDER BY creation_date DESC");
$articles = $articlesStmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer toutes les catégories pour le formulaire
$categoriesStmt = $pdo->query("SELECT * FROM categories ORDER BY name");
$categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer toutes les sous-catégories pour le formulaire
$subcategoriesStmt = $pdo->query("SELECT * FROM subcategories ORDER BY name");
$subcategories = $subcategoriesStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h1>Gestion des Articles</h1>

    <!-- Formulaire pour ajouter un article -->
    <div class="card mb-4">
        <div class="card-header">
            <h2>Ajouter un nouvel article</h2>
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Titre de l'article</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Contenu de l'article</label>
                    <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Type d'article</label>
                    <select class="form-select" id="type" name="type" required onchange="toggleFields()">
                        <option value="">Choisir un type</option>
                        <option value="youtube">Vidéo YouTube</option>
                        <option value="pdf">PDF</option>
                        <option value="image">Image</option>
                    </select>
                </div>
                <div class="mb-3" id="youtube_link_field" style="display:none;">
                    <label for="youtube_link" class="form-label">Lien de la vidéo YouTube</label>
                    <input type="url" class="form-control" id="youtube_link" name="youtube_link">
                </div>
                <div class="mb-3" id="pdf_file_field" style="display:none;">
                    <label for="pdf_file" class="form-label">Télécharger un PDF</label>
                    <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept=".pdf">
                </div>
                <div class="mb-3" id="image_file_field" style="display:none;">
                    <label for="image_file" class="form-label">Télécharger une image</label>
                    <input type="file" class="form-control" id="image_file" name="image_file" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Sélectionner une catégorie</label>
                    <select class="form-select" id="category_id" name="category_id">
                        <option value="">Aucune</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="subcategory_id" class="form-label">Sélectionner une sous-catégorie</label>
                    <select class="form-select" id="subcategory_id" name="subcategory_id">
                        <option value="">Aucune</option>
                        <?php foreach ($subcategories as $subcategory): ?>
                            <option value="<?php echo $subcategory['id']; ?>"><?php echo htmlspecialchars($subcategory['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter l'article</button>
            </form>
        </div>
    </div>

    <!-- Liste des articles -->
    <div class="card mb-4">
        <div class="card-header">
            <h2>Liste des articles</h2>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <?php foreach ($articles as $article): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong><?php echo htmlspecialchars($article['title']); ?></strong> - <?php echo htmlspecialchars($article['content']); ?>
                        <span class="badge bg-primary"><?php echo htmlspecialchars($article['type']); ?></span>
                        <span class="text-muted"><?php echo date('d-m-Y', strtotime($article['creation_date'])); ?></span>
                        <a href="?delete_article_id=<?php echo $article['id']; ?>" class="btn btn-sm btn-danger">Supprimer</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleFields() {
        var type = document.getElementById("type").value;
        document.getElementById("youtube_link_field").style.display = (type === "youtube") ? "block" : "none";
        document.getElementById("pdf_file_field").style.display = (type === "pdf") ? "block" : "none";
        document.getElementById("image_file_field").style.display = (type === "image") ? "block" : "none";
    }
</script>