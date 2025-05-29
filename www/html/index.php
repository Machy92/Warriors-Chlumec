<?php
session_start();
// Předpokládáme, že máš config.php s $supabaseUrl, $supabaseKey a fetchSupabaseData()
require_once 'config.php'; 

// --- KONTROLA PŘIHLÁŠENÍ UŽIVATELE ---
// TUTO PODMÍNKU SI MUSÍŠ PŘIZPŮSOBIT SVÉMU SYSTÉMU PŘIHLAŠOVÁNÍ!
// Například, pokud po úspěšném přihlášení nastavuješ $_SESSION['user_id']:
$user_is_logged_in = isset($_SESSION['user_id']); 
// Pokud chceš, aby to viděl jen admin, podmínka by byla např.:
// $user_is_logged_in = (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin');

// Načtení top hráčů a brankářů (tato logika zůstává)
$top_skaters_query_params = 'select=jmeno,body,fotka_url,cislo_dresu,datum_narozeni,post&order=body.desc&limit=3';
$top_skaters = fetchSupabaseData('players', $top_skaters_query_params);

$top_goalies_query_params = 'select=jmeno,uspesnost,fotka_url,cislo_dresu,datum_narozeni&order=uspesnost.desc&limit=3';
$top_goalies = fetchSupabaseData('goalies', $top_goalies_query_params);

// Načtení položek karuselu (tato logika zůstává)
$carousel_items_query_params = 'select=image_url,title,description&is_active=eq.true&order=item_order.asc';
$carousel_items = fetchSupabaseData('carousel_items', $carousel_items_query_params);

?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warriors Chlumec</title>
    <link rel="icon" type="image/x-icon" href="chlumeclogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto Condensed', sans-serif; margin: 0; padding: 0; background-color: #f8f9fa; }
        .carousel-item img { height: 400px; object-fit: cover; }
        .carousel-caption { background-color: rgba(0, 0, 0, 0.5); padding: 5px 10px; border-radius: 5px; width: 90%; max-width: 600px; text-align: center; left: 50%; transform: translateX(-50%);}
        .section-title { font-size: 1.5rem; font-weight: 700; opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease-out, transform 0.6s ease-out; }
        .animate { opacity: 1 !important; transform: translateY(0) !important; }
        .section-title:hover { transform: scale(1.1); transition: transform 0.3s ease-in-out; }
        .card { transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; }
        .card:hover { transform: scale(1.05); box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2); }
        .players-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem; justify-items: center; margin-top: 1.5rem; }
        .players-grid .card { width: 100%; max-width: 20rem; }
        
        /* Nový styl pro kontejner tlačítka pro správu karuselu */
        .manage-carousel-container {
            text-align: right; /* Umístí tlačítko doprava */
            margin-bottom: 1rem; /* Odsazení pod tlačítkem, před hlavním obsahem */
            margin-top: 1rem; /* Odsazení nad tlačítkem */
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

<?php 
if (isset($_GET['login']) && $_GET['login'] == 'success' && !isset($_SESSION['login_message_shown'])) {
    echo '<div style="background: green; color: white; padding: 10px; text-align: center;">Úspěšně jste se přihlásili!</div>';
    $_SESSION['login_message_shown'] = true; 
}
?>

<nav>
    <?php include 'header.php'; ?>
</nav>

<div id="articlesCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php if (!empty($carousel_items)): ?>
            <?php foreach ($carousel_items as $index => $item): ?>
                <button type="button" data-bs-target="#articlesCarousel" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $index + 1 ?>"></button>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="carousel-inner">
        <?php if (!empty($carousel_items)): ?>
            <?php foreach ($carousel_items as $index => $item): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <img src="<?= htmlspecialchars($item['image_url']) ?>" class="d-block w-100" alt="<?= htmlspecialchars($item['title']) ?>">
                    <div class="carousel-caption">
                        <h5><?= htmlspecialchars($item['title']) ?></h5>
                        <p><?= htmlspecialchars($item['description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="carousel-item active">
                <img src="images/default_carousel.jpg" class="d-block w-100" alt="Výchozí obrázek">
                <div class="carousel-caption"><h5>Vítejte na stránkách Warriors Chlumec</h5><p>Obsah karuselu bude brzy doplněn.</p></div>
            </div>
        <?php endif; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#articlesCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Předchozí</span></button>
    <button class="carousel-control-next" type="button" data-bs-target="#articlesCarousel" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Další</span></button>
</div>

<div class="container manage-carousel-container">
    <?php if ($user_is_logged_in): ?>
        <a href="admin_carousel.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-cog"></i> Spravovat Karusel 
        </a>
    <?php endif; ?>
</div>
 
<main class="container text-center pb-5">
    <h3 class="mt-4 section-title text-uppercase">Nejúspěšnější hráči</h3>
    <div class="players-grid">
        <?php if (!empty($top_skaters)): ?>
            <?php foreach ($top_skaters as $player): ?>
                <div class="card shadow-sm" style="cursor:pointer;" onclick="window.location.href='profil_hrace.php?jmeno=<?= urlencode($player['jmeno']) ?>'">
                    <img src="<?= htmlspecialchars($player['fotka_url'] ?? 'images/default_photo.jpg') ?>" class="card-img-top" alt="<?= htmlspecialchars($player['jmeno']) ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h6 class="card-title text-uppercase fw-semibold" style="font-size: 1.1rem;"> <?= htmlspecialchars($player['jmeno']) ?> </h6>
                        <p class="card-text" style="font-size: 1rem;">Body: <strong><?= htmlspecialchars($player['body']) ?></strong></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Žádní hráči k zobrazení.</p>
        <?php endif; ?>
    </div>

    <h3 class="mt-4 section-title text-uppercase">Nejúspěšnější brankáři</h3>
    <div class="players-grid">
        <?php if (!empty($top_goalies)): ?>
            <?php foreach ($top_goalies as $goalie): ?>
                <div class="card shadow-sm" style="cursor:pointer;" onclick="window.location.href='profil_hrace.php?jmeno=<?= urlencode($goalie['jmeno']) ?>'">
                    <img src="<?= htmlspecialchars($goalie['fotka_url'] ?? 'images/default_photo.jpg') ?>" class="card-img-top" alt="<?= htmlspecialchars($goalie['jmeno']) ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h6 class="card-title text-uppercase fw-semibold" style="font-size: 1.1rem;"> <?= htmlspecialchars($goalie['jmeno']) ?> </h6>
                        <p class="card-text" style="font-size: 1rem;">Úspěšnost: <strong><?= htmlspecialchars(number_format($goalie['uspesnost'] ?? 0, 2)) ?>%</strong></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Žádní brankáři k zobrazení (tabulka 'goalies' je pravděpodobně prázdná, nebo se nepodařilo načíst data).</p>
        <?php endif; ?>
    </div>
</main>

<footer>
    <?php include 'footer.php'; ?>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>