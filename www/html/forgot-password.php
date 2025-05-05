<?php
require 'db.php'; // Připojení k databázi

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];

    // Ověříme, jestli existuje uživatel s tímto e-mailem
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Generování tokenu a expirace
$token = bin2hex(random_bytes(50)); // Generuje náhodný token
$expireTime = date("Y-m-d H:i:s", strtotime("+1 hour")); // Nastaví expiraci za hodinu

// Uložení tokenu a expirace do databáze
$stmt = $conn->prepare("UPDATE users SET reset_token = :reset_token, reset_token_expire = :reset_token_expire WHERE email = :email");
$stmt->bindParam(':reset_token', $token);
$stmt->bindParam(':reset_token_expire', $expireTime);
$stmt->bindParam(':email', $email);
$stmt->execute();


        // Vytvoříme odkaz na reset hesla
        $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/reset-password.php?token=" . $token;

        // Zjistíme, jestli jsme na localhostu
        $isLocalhost = in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1']);

        if ($isLocalhost) {
            // Na localhostu vypíšeme odkaz
            $message = "Odkaz pro reset hesla (pouze pro testování): <br><a href='$resetLink'>$resetLink</a>";
        } else {
            // Na serveru pošleme e-mail
            $subject = "Obnova hesla";
            $headers = "From: info@tvoje-domena.cz\r\n";
            $headers .= "Reply-To: info@tvoje-domena.cz\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $body = "<p>Obdrželi jsme žádost o resetování hesla. Klikněte na odkaz níže:</p>";
            $body .= "<p><a href='$resetLink'>$resetLink</a></p>";
            $body .= "<p>Platnost odkazu je 1 hodina.</p>";

            mail($email, $subject, $body, $headers);

            $message = "Pokud existuje účet s tímto e-mailem, byly zaslány instrukce pro reset hesla.";
        }
    } else {
        $message = "Pokud existuje účet s tímto e-mailem, byly zaslány instrukce pro reset hesla.";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Zapomenuté heslo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2>Zapomenuté heslo</h2>

    <?php if (isset($message)): ?>
        <div class="alert alert-info">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Zadejte svůj e-mail:</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Odeslat</button>
    </form>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
