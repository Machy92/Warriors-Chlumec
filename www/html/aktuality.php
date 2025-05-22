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
$ch = curl_init("$supabaseUrl/rest/v1/aktuality?select=*&order=datum.desc");
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
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
    <link rel="stylesheet" href="styles.css"> <!-- Pokud máš vlastní styl -->
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Aktuality</h2>

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
                                <i class="fa-regular fa-user"></i> <?= htmlspecialchars($clanek['autor'] ?? 'Neznámý') ?><br>
                                <i class="fa-regular fa-clock"></i> <?= date('d.m.Y H:i', strtotime($clanek['datum'])) ?>
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
