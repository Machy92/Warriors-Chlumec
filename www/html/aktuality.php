

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktuality</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="chlumeclogo.png">
    <style>
        .article-card {
            border-radius: 15px;
        }
        .btn-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<?php include 'header.php'; ?>

<div class="container my-5 flex-grow-1">
    <h2 class="mb-4 text-center">Aktuality</h2>

    <?php if (isset($_SESSION["user_id"])): ?>
        <div class="text-center mb-4">
            <a href="pridat-aktualitu.php" class="btn btn-primary">➕ Přidat článek</a>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
    <?php foreach ($articles as $article): ?>
    <div class="col-12 col-md-10">
        <div class="card mb-4 shadow-sm article-card">
            <div class="card-body">
                <h3 class="card-title"><?= htmlspecialchars($article["title"]) ?></h3>
                <p class="card-text"><?= nl2br(htmlspecialchars($article["content"])) ?></p>
                <p class="text-muted small">
                    Autor: <?= htmlspecialchars($article["jmeno"] . ' ' . $article["prijmeni"]) ?> |
                    <?= date('j. n. Y H:i', strtotime($article["created_at"])) ?>
                </p>

                <?php if (isset($_SESSION["user_id"])): ?>
                    <div class="btn-group mt-3">
                        <a href="editovat-aktualitu.php?id=<?= $article['id'] ?>" class="btn btn-warning">✏️ Editovat</a>
                        <a href="smazat-aktualitu.php?id=<?= $article['id'] ?>" class="btn btn-danger" onclick="return confirm('Opravdu chcete smazat tento článek?');">🗑️ Smazat</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

    </div>
</div>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>