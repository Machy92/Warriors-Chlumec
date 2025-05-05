<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$host = "postgres";
$dbname = "warriorschlumec";
$user = "postgres";
$password = "qwerty";

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Chyba připojení: " . $e->getMessage());
}

$message = "";
$success = false; // Přidáno - defaultně neúspěch

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $currentPassword = $_POST["current_password"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];

    $stmt = $conn->prepare("SELECT password FROM users WHERE id = :id");
    $stmt->bindParam(":id", $_SESSION["user_id"]);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $message = "Uživatel nenalezen.";
    } elseif (!password_verify($currentPassword, $user["password"])) {
        $message = "Aktuální heslo je špatně.";
    } elseif ($newPassword !== $confirmPassword) {
        $message = "Nová hesla se neshodují.";
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":id", $_SESSION["user_id"]);
        $stmt->execute();
        $message = "Heslo bylo úspěšně změněno!";
        $success = true; // Heslo úspěšně změněno
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Změna hesla</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2>Změna hesla</h2>

    <?php if ($message): ?>
        <div class="alert <?= $success ? 'alert-success' : 'alert-danger' ?> mt-3">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label for="current_password" class="form-label">Aktuální heslo</label>
            <input type="password" name="current_password" id="current_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="new_password" class="form-label">Nové heslo</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Potvrdit nové heslo</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-danger">Změnit heslo</button>
    </form>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
