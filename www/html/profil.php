<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$supabaseUrl = 'https://opytqyxheeezvwncboly.supabase.co';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9weXRxeXhoZWVlenZ3bmNib2x5Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDc2NDAyMTMsImV4cCI6MjA2MzIxNjIxM30.h_DdvClVy4-xbEkQ3AWQose3dqPaxPQ1gl-LaLhwtCE'; // anonymní klíč

$userId = $_SESSION['user_id'];
$headers = [
    "apikey: $supabaseKey",
    "Authorization: Bearer $supabaseKey",
    "Content-Type: application/json"
];

// 1. Získání profilu
$ch = curl_init("$supabaseUrl/rest/v1/user_profiles_with_email?user_id=eq.$userId&select=jmeno,pozice,vytvoreno,email");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers
]);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$profile = $data[0] ?? null;

if (!$profile) {
    $error = "Nepodařilo se načíst profil.";
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Profil uživatele</title>
    <link rel="icon" type="image/x-icon" href="chlumeclogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Profil uživatele</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
        <?php else: ?>
            <div class="card mx-auto" style="max-width: 500px;">
                <div class="card-body">
                    <h5 class="card-title"><i class="fa fa-user"></i> <?= htmlspecialchars($profile['jmeno']) ?></h5>
                    <p class="card-text"><strong>Pozice:</strong> <?= htmlspecialchars($profile['pozice']) ?></p>
                    <p class="card-text"><strong>E-mail:</strong> <?= htmlspecialchars($profile['email'] ?? 'Neuveden') ?></p>
                    <p class="card-text"><strong>Datum registrace:</strong> <?= htmlspecialchars(date('d.m.Y H:i', strtotime($profile['vytvoreno']))) ?></p>
                    <a href="logout.php" class="btn btn-outline-danger mt-3">Odhlásit se</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
