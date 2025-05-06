<?php
session_start();

// Načtení hráčů ze souboru JSON
$players_json = file_get_contents('hraci.json');
$players = json_decode($players_json, true);

// Rozdělení hráčů na hráče v poli a brankáře
$skaters = [];
$goalies = [];

foreach ($players as $player) {
    if ($player['position'] === 'Brankář') {
        $goalies[] = $player;
    } else {
        $skaters[] = $player;
    }
}

// Seřazení hráčů podle počtu gólů
usort($skaters, function($a, $b) {
    return $b['goals'] - $a['goals'];
});

// Seřazení brankářů podle úspěšnosti zákroků
usort($goalies, function($a, $b) {
    return ($b['save_pct'] ?? 0) <=> ($a['save_pct'] ?? 0);
});
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warriors Chlumec</title>
    <link rel="icon" type="image/x-icon" href="chlumeclogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto Condensed', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .carousel-item img {
            height: 400px;
            object-fit: cover;
        }
        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 5px 10px;
            border-radius: 5px;
            width: 90%;
            max-width: 600px;
            text-align: center;
            left: 50%;
            transform: translateX(-50%);
        }
        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .animate {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
        .section-title:hover {
            transform: scale(1.1);
            transition: transform 0.3s ease-in-out;
        }
        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }
        .players-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            justify-items: center;
            margin-top: 1.5rem;
        }
        .players-grid .card {
            width: 100%;
            max-width: 1.7rem;
        }
        @media (max-width: 992px) {
            .players-grid .card {
                max-width: 14rem;
                transform: scale(0.95);
            }
        }
        @media (max-width: 768px) {
            .players-grid .card {
                max-width: 12rem;
                transform: scale(0.9);
            }
        }
        @media (max-width: 576px) {
       .players-grid .card {
        max-width: 19rem;
        transform: scale(1.25);
            }
        }


    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const titles = document.querySelectorAll(".section-title");
            function checkScroll() {
                titles.forEach(title => {
                    const rect = title.getBoundingClientRect();
                    if (rect.top < window.innerHeight - 100) {
                        title.classList.add("animate");
                    }
                });
            }
            window.addEventListener("scroll", checkScroll);
            checkScroll();
        });
    </script>
</head>
<body>

<?php if (isset($_GET['login']) && $_GET['login'] == 'success'): ?>
    <div style="background: green; color: white; padding: 10px; text-align: center;">
        Úspěšně jste se přihlásili!
    </div>
<?php endif; ?>

<nav>
    <?php include 'header.php'; ?>
</nav>

<!-- Karusel -->
<div id="articlesCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#articlesCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#articlesCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#articlesCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="img1.jpg" class="d-block w-100" alt="Popis článku 1">
            <div class="carousel-caption">
                <h5>Sezóna začíná!</h5>
                <p>První zápas nové sezóny se blíží. Přijďte podpořit tým Warriors Chlumec!</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="img2.jpg" class="d-block w-100" alt="Popis článku 2">
            <div class="carousel-caption">
                <h5>Turnaj mladých nadějí</h5>
                <p>Warriors si vedli skvěle a přivezli domů pohár!</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="img3.jpg" class="d-block w-100" alt="Popis článku 3">
            <div class="carousel-caption">
                <h5>Nová posila v týmu</h5>
                <p>Zkušený hráč posílí naši obranu!</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#articlesCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Předchozí</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#articlesCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Další</span>
    </button>
</div>

<main class="container text-center pb-5">
    <h3 class="mt-4 section-title text-uppercase">Nejúspěšnější hráči</h3>
    <div class="players-grid">
        <?php foreach (array_slice($skaters, 0, 3) as $player): ?>
            <div class="card shadow-sm" style="cursor:pointer;" onclick="window.location.href='profil_hrace.php?jmeno=<?= urlencode($player['slug']) ?>'">
                <img src="<?= htmlspecialchars($player['photo']) ?>" class="card-img-top" alt="<?= htmlspecialchars($player['name']) ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase fw-semibold" style="font-size: 1.1rem;"> <?= htmlspecialchars($player['name']) ?> </h6>
                    <p class="card-text" style="font-size: 1rem;">Góly: <strong><?= htmlspecialchars($player['goals']) ?></strong></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <h3 class="mt-4 section-title text-uppercase">Nejúspěšnější brankáři</h3>
    <div class="players-grid">
        <?php foreach (array_slice($goalies, 0, 3) as $goalie): ?>
            <div class="card shadow-sm" style="cursor:pointer;" onclick="window.location.href='profil_hrace.php?jmeno=<?= urlencode($goalie['slug']) ?>'">
                <img src="<?= htmlspecialchars($goalie['photo']) ?>" class="card-img-top" alt="<?= htmlspecialchars($goalie['name']) ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body text-center">
                    <h6 class="card-title text-uppercase fw-semibold" style="font-size: 1.1rem;"> <?= htmlspecialchars($goalie['name']) ?> </h6>
                    <p class="card-text" style="font-size: 1rem;">Úspěšnost zákroků: <strong><?= htmlspecialchars(number_format($goalie['save_pct'], 2)) ?>%</strong></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<footer>
    <?php include 'footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
