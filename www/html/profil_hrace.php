<?php
session_start();

// Načti data z JSON souboru
$hraci = [];
$json = file_get_contents('hraci.json');

if ($json !== false) {
    $hraci = json_decode($json, true);
}

$slug = $_GET['jmeno'] ?? '';
$hrac = null;

// Najdi hráče podle slugu
foreach ($hraci as $h) {
    if (isset($h['slug']) && $h['slug'] === $slug) {
        $hrac = $h;
        break;
    }
}

if (!$hrac) {
    die("Hráč nenalezen.");
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($hrac['name']) ?> - Profil hráče</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f4f4;
        }
        .player-profile {
            max-width: 600px;
            margin: auto;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .player-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
        }
        .stat-table {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container">
    <div class="player-profile">
        <img src="<?= htmlspecialchars($hrac['photo']) ?>" alt="<?= htmlspecialchars($hrac['name']) ?>" class="player-img">
        <h2><?= htmlspecialchars($hrac['name']) ?></h2>
        <p><strong>Pozice:</strong> <?= htmlspecialchars($hrac['position']) ?></p>
        <p><strong>Číslo dresu:</strong> <?= htmlspecialchars($hrac['number']) ?></p>
        <p><strong>Věk:</strong> <?= htmlspecialchars($hrac['age']) ?></p>

        <table class="table table-striped stat-table">
    <tbody>
        <?php if ($hrac['position'] !== 'Brankář'): ?>
            <tr>
                <th>Odehrané zápasy</th>
                <td><?= htmlspecialchars($hrac['matches'] ?? 0) ?></td>
            </tr>
            <tr>
                <th>Góly</th>
                <td><?= htmlspecialchars($hrac['goals'] ?? 0) ?></td>
            </tr>
            <tr>
                <th>Asistence</th>
                <td><?= htmlspecialchars($hrac['assists'] ?? 0) ?></td>
            </tr>
            <tr>
                <th>Trestné minuty</th>
                <td><?= htmlspecialchars($hrac['penalties'] ?? 0) ?></td>
            </tr>
        <?php else: ?>
            <tr>
                <th>Odehrané minuty</th>
                <td><?= htmlspecialchars($hrac['minutes'] ?? 0) ?></td>
            </tr>
            <tr>
                <th>Úspěšnost zákroků</th>
                <td><?= htmlspecialchars($hrac['save_pct'] ?? 0) ?>%</td>
            </tr>
            <tr>
                <th>Trestné minuty</th>
                <td><?= htmlspecialchars($hrac['penalties'] ?? 0) ?></td>
            </tr>
            <tr>
                <th>Asistence</th>
                <td><?= htmlspecialchars($hrac['assists'] ?? 0) ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>


        <a href="soupisky.php" class="btn btn-dark mt-3">Zpět na soupisku</a>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>