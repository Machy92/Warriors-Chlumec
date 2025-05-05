<?php
session_start();

// Načti data z JSON souboru
$hraci = [];
$json = file_get_contents('hraci.json');

if ($json !== false) {
    $hraci = json_decode($json, true);
}

// Rozdělení podle pozic
$pozice = ["Brankář" => "Brankáři", "Obránce" => "Obránci", "Útočník" => "Útočníci"];
$rozdelene = [];

foreach ($hraci as $hrac) {
    $pozice_hrace = $hrac['position'] ?? 'Neznámá pozice';
    $rozdelene[$pozice_hrace][] = $hrac;
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soupiska - Warriors Chlumec</title>
    <link rel="icon" type="image/x-icon" href="chlumeclogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            max-width: 900px;
            margin: auto;
            padding-top: 50px;
        }
        .team-header {
            font-size: 24px;
            font-weight: bold;
            color: #444;
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }
        .player-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            background-color: white;
            position: relative;
            transition: 0.3s;
        }
        .player-card:hover {
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
        }
        .player-card img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .player-name {
            font-size: 18px;
            font-weight: bold;
            color: #222;
        }
        .player-info {
            font-size: 14px;
            color: #666;
        }
        .stretched-link {
            position: absolute;
            top: 0; left: 0;
            right: 0; bottom: 0;
            z-index: 1;
        }
    </style>
</head>
<body>
<nav>
    <?php include 'header.php'; ?>
</nav>

<div class="container">
    <h1 class="text-center">Soupiska týmu Warriors Chlumec</h1>

    <?php if (!empty($rozdelene)): ?>
        <?php foreach ($pozice as $pozice_klic => $pozice_nazev): ?>
            <?php if (!isset($rozdelene[$pozice_klic])) continue; ?>
            <div class="team-header"> <?= $pozice_nazev ?> </div>
            <div class="row g-3">
    <?php foreach ($rozdelene[$pozice_klic] as $hrac): ?>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="player-card">
                <img src="<?= htmlspecialchars($hrac['photo']) ?>" alt="<?= htmlspecialchars($hrac['name']) ?>">
                <div class="player-name"><?= htmlspecialchars($hrac['name']) ?></div>
                <div class="player-info">
                    Číslo: <?= htmlspecialchars($hrac['number']) ?><br>
                    Věk: <?= htmlspecialchars($hrac['age']) ?><br>
                    Pozice: <?= htmlspecialchars($hrac['position']) ?>
                </div>
                <a href="profil_hrace.php?jmeno=<?= urlencode($hrac['slug']) ?>" class="stretched-link"></a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-warning text-center">Žádní hráči nenalezeni</div>
    <?php endif; ?>
</div>

<footer class="mt-5">
    <?php include 'footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
