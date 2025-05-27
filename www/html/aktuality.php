<?php
session_start();

$supabaseUrl = 'https://opytqyxheeezvwncboly.supabase.co';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9weXRxeXhoZWVlenZ3bmNib2x5Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDc2NDAyMTMsImV4cCI6MjA2MzIxNjIxM30.h_DdvClVy4-xbEkQ3AWQose3dqPaxPQ1gl-LaLhwtCE';

$headers = [
    "apikey: $supabaseKey",
    "Authorization: Bearer $supabaseKey",
    "Content-Type: application/json"
];

// Načtení článků
$chAktuality = curl_init("$supabaseUrl/rest/v1/aktuality?select=*&order=datum.desc");
curl_setopt_array($chAktuality, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers
]);
$responseAktuality = curl_exec($chAktuality);

// Zkontroluj, zda nedošlo k chybě při cURL požadavku pro aktuality
if ($responseAktuality === false) {
    $error = curl_error($chAktuality);
    curl_close($chAktuality);
    die("Chyba při načítání aktualit: $error");
}

$data = json_decode($responseAktuality, true); // články
curl_close($chAktuality);

// Načtení profilů
$chProfiles = curl_init("$supabaseUrl/rest/v1/profiles?select=user_id,jmeno");
curl_setopt_array($chProfiles, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers
]);
$responseProfiles = curl_exec($chProfiles);

// Zkontroluj, zda nedošlo k chybě při cURL požadavku pro profily
if ($responseProfiles === false) {
    $error = curl_error($chProfiles);
    curl_close($chProfiles);
    die("Chyba při načítání profilů: $error");
}

curl_close($chProfiles);
$profiles = json_decode($responseProfiles, true); // profily

// Mapování user_id -> jméno
$autoriMap = [];
if (is_array($profiles)) {
    foreach ($profiles as $profil) {
        $autoriMap[$profil['user_id']] = $profil['jmeno'];
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aktuality</title>
    <link rel="icon" href="chlumeclogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="container mt-5 mb-5">
    <h2 class="text-center mb-4">Aktuality</h2>

    <?php if (isset($_GET['zprava'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['zprava']) ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['zprava_chyba'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['zprava_chyba']) ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="text-center mb-4">
            <a href="pridat-aktualitu.php" class="btn btn-success">
                <i class="fa-solid fa-plus"></i> Přidat aktualitu
            </a>
        </div>
    <?php endif; ?>

    <?php if (empty($data)): ?>
        <p class="text-center">Zatím žádné aktuality.</p>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($data as $clanek): ?>
                <?php
                    $autor_id = $clanek['autor'] ?? null;
                    $autor_jmeno = 'Neznámý';
                    if ($autor_id && isset($autoriMap[$autor_id])) {
                        $autor_jmeno = $autoriMap[$autor_id];
                    }
                ?>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($clanek['obrazek_url'])): ?>
                            <img src="<?= htmlspecialchars($clanek['obrazek_url']) ?>" class="card-img-top" alt="Obrázek článku">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($clanek['nadpis']) ?></h5>
                            <p class="card-text">
                                <?= nl2br(htmlspecialchars(mb_substr($clanek['obsah'], 0, 150))) ?>...
                            </p>
                        </div>
                        <div class="card-footer text-muted small">
                            <i class="fa-regular fa-user"></i> <?= htmlspecialchars($autor_jmeno) ?><br>
                            <i class="fa-regular fa-clock"></i> <?= date('d.m.Y H:i', strtotime($clanek['datum'])) ?>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <br>
                                <a href="upravit-aktualitu.php?id=<?= htmlspecialchars($clanek['id']) ?>" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-pen-to-square"></i> Upravit
                                </a>
                                <a href="smazat-aktualitu.php?id=<?= htmlspecialchars($clanek['id']) ?>" class="btn btn-danger btn-sm ms-2" onclick="return confirm('Opravdu chcete smazat tuto aktualitu?')">
                                    <i class="fa-solid fa-trash-can"></i> Smazat
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>