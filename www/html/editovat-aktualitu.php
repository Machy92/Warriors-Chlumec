<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'db.php';

if (!isset($_SESSION["user_id"])) {
    die("Přístup zamítnut. Musíte být přihlášeni.");
}

$id = $_GET["id"] ?? null;
if (!$id) die("Chybějící ID článku");

$stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$article) die("Článek nenalezen.");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"] ?? '';
    $content = $_POST["content"] ?? '';

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("UPDATE articles SET title = ?, content = ? WHERE id = ?");
        $stmt->execute([$title, $content, $id]);

        header("Location: aktuality.php");
        exit();
    } else {
        $error_message = "Vyplňte všechna pole!";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Editovat aktualitu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Editovat aktualitu</h2>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Název:</label>
            <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($article["title"]) ?>" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Obsah:</label>
            <textarea id="content" name="content" rows="5" class="form-control" required><?= htmlspecialchars($article["content"]) ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">💾 Uložit změny</button>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
