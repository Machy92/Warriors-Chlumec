<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION["user_id"] = $user['id'];
        $_SESSION["user_email"] = $user['email'];

        $_SESSION["message"] = "✅ Úspěšně jste se přihlásili!";
        $_SESSION["message_type"] = "success";

        header("Location: index.php");
        exit;
    } else {
        $_SESSION["message"] = "❌ Neplatné přihlašovací údaje.";
        $_SESSION["message_type"] = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Přihlášení</title>
    <link rel="icon" type="image/x-icon" href="chlumeclogo.png">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }
        .card {
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
            padding: 20px;
        }
    </style>
</head>
<body>

<nav><?php include 'header.php'; ?></nav>

<div class="container-fluid login-container">
    <div class="card shadow">
        <h3 class="mb-4 text-center">Přihlášení</h3>

        <?php if (isset($_SESSION["message"])): ?>
            <div class="alert alert-<?= $_SESSION["message_type"] ?> text-center">
                <?= $_SESSION["message"] ?>
            </div>
            <?php unset($_SESSION["message"]); ?>
        <?php endif; ?>

        <form action="" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">Emailová adresa</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="např. jan@domena.cz" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Heslo</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-dark w-100">Přihlásit se</button>
            <div class="text-center mt-3">
            <a href="forgot-password.php">Zapomněli jste heslo?</a>
            </div>

        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
