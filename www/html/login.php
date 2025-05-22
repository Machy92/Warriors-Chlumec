<?php
session_start();

$supabaseUrl = 'https://opytqyxheeezvwncboly.supabase.co';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9weXRxeXhoZWVlenZ3bmNib2x5Iiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc0NzY0MDIxMywiZXhwIjoyMDYzMjE2MjEzfQ.j5P0CgFejLb99zkwP-4SdUZ6IC-z8HvCY9D0JL0ovWQ';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $headers = [
        "apikey: $supabaseKey",
        "Authorization: Bearer $supabaseKey",
        "Content-Type: application/json"
    ];

    // 1) Přihlášení přes Supabase Auth
    $data = json_encode([
        "email" => $email,
        "password" => $password
    ]);

    $ch = curl_init("$supabaseUrl/auth/v1/token?grant_type=password");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => $headers
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (isset($result['access_token']) && isset($result['user']['id'])) {
        $_SESSION['user_id'] = $result['user']['id'];
        $_SESSION['user_email'] = $result['user']['email'];

        // 2) Načtení role (pozice) z tabulky `profiles`
        $userId = $result['user']['id'];
        $queryUrl = "$supabaseUrl/rest/v1/profiles?user_id=eq.$userId&select=pozice";

        $ch2 = curl_init($queryUrl);
        curl_setopt_array($ch2, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "apikey: $supabaseKey",
                "Authorization: Bearer $supabaseKey",
                "Content-Type: application/json",
                "Prefer: return=representation"
            ]
        ]);

        $response2 = curl_exec($ch2);
        curl_close($ch2);

        $profileData = json_decode($response2, true);

        if (!empty($profileData) && isset($profileData[0]['pozice'])) {
            $_SESSION['pozice'] = $profileData[0]['pozice'];
        } else {
            $_SESSION['pozice'] = null; // Bez role
        }

        header("Location: profil.php");
        exit;
    } else {
        $error = "Přihlášení se nezdařilo. Zkontrolujte e-mail nebo heslo.";
    }
}
?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení – Warriors Chlumec</title>
    <link rel="icon" type="image/x-icon" href="chlumeclogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Přihlášení uživatele</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <form method="POST" class="border p-4 rounded shadow-sm bg-light">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Heslo:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Přihlásit se</button>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
