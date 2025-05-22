<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$supabaseUrl = 'https://opytqyxheeezvwncboly.supabase.co';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9weXRxeXhoZWVlenZ3bmNib2x5Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDc2NDAyMTMsImV4cCI6MjA2MzIxNjIxM30.h_DdvClVy4-xbEkQ3AWQose3dqPaxPQ1gl-LaLhwtCE';

$userId = $_SESSION['user_id'];
$headers = [
    "apikey: $supabaseKey",
    "Authorization: Bearer $supabaseKey",
    "Content-Type: application/json"
];

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
    <link rel="icon" href="chlumeclogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <h2 class="text-center mb-4">Profil uživatele</h2>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
                <?php else: ?>
                    <div class="card shadow rounded">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-3">
                                <i class="fa-solid fa-user"></i> <?= htmlspecialchars($profile['jmeno']) ?>
                            </h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <i class="fa-solid fa-briefcase"></i>
                                    <strong> Pozice:</strong> <?= htmlspecialchars($profile['pozice']) ?>
                                </li>
                                <li class="list-group-item">
                                    <i class="fa-solid fa-envelope"></i>
                                    <strong> E-mail:</strong> <?= htmlspecialchars($profile['email'] ?? 'Neuveden') ?>
                                </li>
                                <li class="list-group-item">
                                    <i class="fa-solid fa-calendar-plus"></i>
                                    <strong> Datum registrace:</strong> <?= htmlspecialchars(date('d.m.Y H:i', strtotime($profile['vytvoreno']))) ?>
                                </li>
                            </ul>
                            <div class="d-grid gap-2 mt-4">
                                <button class="btn btn-warning mt-3" onclick="document.getElementById('changePasswordForm').style.display='block'">
                                <i class="fa-solid fa-key"></i> Změnit heslo</button>

                                <div id="changePasswordForm" class="mt-4" style="display:none;">
                                <form method="post" action="change_password.php">
                               <div class="mb-3">
                                 <label for="new_password" class="form-label">Nové heslo</label>
                                  <input type="password" name="new_password" id="new_password" class="form-control" required minlength="6">
                                  </div>
                                   <button type="submit" class="btn btn-success">Změnit heslo</button>
                                    </form>
                                </div>

                                <a href="logout.php" class="btn btn-outline-danger">
                                    <i class="fa-solid fa-right-from-bracket"></i> Odhlásit se
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
