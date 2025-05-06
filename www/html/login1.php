<?php 
require 'db.php'; // Připojení k databázi

if (isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Přesměrování, pokud už je uživatel přihlášen
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        header("Location: index.php"); // Po úspěšném přihlášení
        exit();
    } else {
        $error = "Nesprávný e-mail nebo heslo!";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warriors Chlumec - Přihlášení</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav>
        <?php include 'header.php'; ?>
    </nav>

    <div class="container">
        <div class="box form-box">
            <header>Přihlášení</header>
            <?php if (isset($error)) echo "<p class='message'>$error</p>"; ?>
            <form action="login.php" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="on" required>
                </div>

                <div class="field input">
                    <label for="password">Heslo</label>
                    <input type="password" name="password" id="password" autocomplete="on" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login">
                </div>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
