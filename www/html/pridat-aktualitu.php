<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'db.php';

if (!isset($_SESSION["user_id"])) {
    die("Přístup zamítnut. Musíte být přihlášeni.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"] ?? '';
    $content = $_POST["content"] ?? '';
    $author_id = $_SESSION["user_id"];

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("INSERT INTO articles (title, content, author_id, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$title, $content, $author_id]);

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
    <title>Přidat aktualitu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Přidat novou aktualitu</h2>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Název:</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Obsah:</label>
            <textarea id="content" name="content" rows="5" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">📢 Přidat aktualitu</button>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
