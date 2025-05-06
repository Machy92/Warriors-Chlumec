<?php
session_start();
require 'db.php';
try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql_zapasy = "SELECT * FROM zapas ORDER BY date, time";
    $stmt_zapasy = $conn->prepare($sql_zapasy);
    $stmt_zapasy->execute();
    $zapasy = $stmt_zapasy->fetchAll(PDO::FETCH_ASSOC);

    $sql_vysledky = "SELECT * FROM vysledek ORDER BY id DESC"; 
    $stmt_vysledky = $conn->prepare($sql_vysledky);
    $stmt_vysledky->execute();
    $vysledky = $stmt_vysledky->fetchAll(PDO::FETCH_ASSOC);

    $logos = [
        "Warriors" => "chlumeclogo1.png",
        "Tigers" => "tigerslogo1.png",
        "Lions" => "lionslogo1.png",        
        "Sharks" => "sharkslogo.png",
        "Falcons" => "falconslogo1.png",
        "Eagles" => "eagleslogo1.png"
    ];

} catch (PDOException $e) {
    echo "Chyba připojení: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warriors Chlumec</title>
    <link rel="icon" type="image/x-icon" href="chlumeclogo.png">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Vlastní styl -->
    <style>
    body {
        background-color: #f4f4f4;
        }
    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: none;
        border-radius: 10px;
    }
    .team-logo {
        width: 40px;
        height: auto;
    }
    .team-name {
        font-size: 18px;
        font-weight: bold;
    }
    .vs-text {
        font-size: 16px;
        color: #555;
        font-weight: bold;
    }
    .match-card, .result-card {
        margin-bottom: 20px;
        height: 170px; /* Nastavení stejné výšky pro všechny karty */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .result-card[data-status="prohra"] {
        border: 2px solid red;
    }
    .result-card[data-status="vyhra"] {
        border: 2px solid green;
    }
    .text-center-middle {
        text-align: center;
        margin-top: 10px;
        flex-grow: 1; /* Umožní flexboxu, aby vyplnil zbývající prostor */
    }
    h1 {
        margin: 40px 0; /* Zvýšení horního a spodního odsazení nadpisů */
    }
</style>

    </style>
</head>
<body>
<nav>
<?php include 'header.php'; ?>
</nav>

    <div class="container">
        <div class="row">
            <!-- Nadcházející zápasy -->
            <div class="col-lg-6">
                <h1 class="mb-4">Nadcházející zápasy</h1>
                <?php if (!empty($zapasy)): ?>
                    <?php foreach ($zapasy as $zapas): ?>
                        <div class="card match-card p-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="team">
                                        <?php if (isset($logos[$zapas['domaci']])): ?>
                                            <img src="logos/<?= htmlspecialchars($logos[$zapas['domaci']]) ?>" alt="<?= htmlspecialchars($zapas['domaci']) ?>" class="team-logo">
                                        <?php endif; ?>
                                        <span class="team-name"><?= htmlspecialchars($zapas['domaci']) ?></span>
                                    </div>
                                    <span class="vs-text">vs</span>
                                    <div class="team">
                                        <?php if (isset($logos[$zapas['hoste']])): ?>
                                            <img src="logos/<?= htmlspecialchars($logos[$zapas['hoste']]) ?>" alt="<?= htmlspecialchars($zapas['hoste']) ?>" class="team-logo">
                                        <?php endif; ?>
                                        <span class="team-name"><?= htmlspecialchars($zapas['hoste']) ?></span>
                                    </div>
                                </div>
                                <div class="text-center-middle">
                                    <p><?= date('j.n.Y', strtotime($zapas['date'])) ?></p>
                                    <p><?= date('H:i', strtotime($zapas['time'])) ?> / <?= htmlspecialchars($zapas['misto']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-warning">Žádné zápasy nenalezeny</div>
                <?php endif; ?>
            </div>

            <!-- Výsledky zápasů -->
            <div class="col-lg-6">
                <h1 class="mb-4">Výsledky zápasů</h1>
                <?php if (!empty($vysledky)): ?>
                    <?php foreach ($vysledky as $vysledek): ?>
                        <?php
                            list($skore_domaci, $skore_hoste) = explode(':', $vysledek['vysledek']);
                            $status = 'vyhra';

                            if (stripos($vysledek['domaci'], 'warriors') !== false && (int)$skore_domaci < (int)$skore_hoste) {
                                $status = 'prohra';
                            } elseif (stripos($vysledek['hoste'], 'warriors') !== false && (int)$skore_hoste < (int)$skore_domaci) {
                                $status = 'prohra';
                            }
                        ?>
                        <div class="card result-card p-3" data-status="<?= $status ?>">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="team">
                                        <?php if (isset($logos[$vysledek['domaci']])): ?>
                                            <img src="logos/<?= htmlspecialchars($logos[$vysledek['domaci']]) ?>" alt="<?= htmlspecialchars($vysledek['domaci']) ?>" class="team-logo">
                                        <?php endif; ?>
                                        <span class="team-name"><?= htmlspecialchars($vysledek['domaci']) ?></span>
                                    </div>
                                    <span class="vs-text">vs</span>
                                    <div class="team">
                                        <?php if (isset($logos[$vysledek['hoste']])): ?>
                                            <img src="logos/<?= htmlspecialchars($logos[$vysledek['hoste']]) ?>" alt="<?= htmlspecialchars($vysledek['hoste']) ?>" class="team-logo">
                                        <?php endif; ?>
                                        <span class="team-name"><?= htmlspecialchars($vysledek['hoste']) ?></span>
                                    </div>
                                </div>
                                <div class="text-center-middle">
                                    <h2><?= htmlspecialchars($vysledek['vysledek']) ?></h2>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-warning">Žádné výsledky nenalezeny</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer class="mt-5">
        <?php include 'footer.php'; ?>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>







