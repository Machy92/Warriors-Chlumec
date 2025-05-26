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

// Načtení profilu
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil uživatele</title>
    <link rel="icon" href="chlumeclogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-11 col-md-8 col-lg-6"> <?php if (isset($_GET['heslo'])): ?>
                <?php if ($_GET['heslo'] === 'ok'): ?>
                    <div class="alert alert-success text-center">Heslo bylo úspěšně změněno.</div>
                <?php else: ?>
                    <div class="alert alert-danger text-center">Nepodařilo se změnit heslo. Zkontroluj zadané údaje.</div>
                <?php endif; ?>
            <?php endif; ?>

            <h2 class="text-center mb-4">Profil uživatele</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
            <?php else: ?>
                <div class="card shadow rounded">
                    <div class="card-body p-4">
                        <h5 class="card-title text-center mb-4"> <i class="fa-solid fa-user"></i> <?= htmlspecialchars($profile['jmeno']) ?>
                        </h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="fa-solid fa-briefcase text-muted me-2"></i> <strong>Pozice:</strong> <?= htmlspecialchars($profile['pozice']) ?>
                            </li>
                            <li class="list-group-item">
                                <i class="fa-solid fa-envelope text-muted me-2"></i>
                                <strong>E-mail:</strong> <?= htmlspecialchars($profile['email'] ?? 'Neuveden') ?>
                            </li>
                            <li class="list-group-item">
                                <i class="fa-solid fa-calendar-plus text-muted me-2"></i>
                                <strong>Datum registrace:</strong> <?= htmlspecialchars(date('d.m.Y H:i', strtotime($profile['vytvoreno']))) ?>
                            </li>
                        </ul>

                        <div class="mt-4">
                            <button class="btn btn-warning w-100" onclick="document.getElementById('changePasswordForm').style.display='block'">
                                <i class="fa-solid fa-key"></i> Změnit heslo
                            </button>

                            <div id="changePasswordForm" class="mt-4 border p-4 rounded bg-light" style="display:none;">
                                <h5 class="mb-3">Změna hesla</h5>
                                <form method="post" action="change_password.php">
                                    <div class="mb-3">
                                        <label for="old_password" class="form-label">Staré heslo</label>
                                        <input type="password" name="old_password" id="old_password" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Nové heslo</label>
                                        <input type="password" name="new_password" id="new_password" class="form-control" required minlength="6">
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Zopakuj nové heslo</label>
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required minlength="6">
                                    </div>
                                    <button type="submit" class="btn btn-success">Potvrdit změnu</button>
                                </form>
                            </div>

                            <a href="logout.php" class="btn btn-outline-danger w-100 mt-3">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>