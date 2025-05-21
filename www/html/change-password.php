
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Změna hesla</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Změna hesla</h2>
        <?php if (isset($_GET['success'])) echo "<p class='text-success'>Heslo úspěšně změněno.</p>"; ?>
        <?php if (isset($_GET['error'])) echo "<p class='text-danger'>" . htmlspecialchars($_GET['error']) . "</p>"; ?>
        <form action="change_password_process.php" method="POST">
            <div class="mb-3">
                <label for="current_password">Současné heslo:</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="new_password">Nové heslo:</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password">Potvrď nové heslo:</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-danger">Změnit heslo</button>
        </form>
    </div>
</body>
</html>
