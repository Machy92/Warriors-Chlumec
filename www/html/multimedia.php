<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fotogalerie</title>
    <link rel="icon" type="image/x-icon" href="chlumeclogo.png">

    <!-- LightGallery CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/css/lightgallery-bundle.min.css">

    <!-- LightGallery JS -->
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/lightgallery.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/thumbnail/lg-thumbnail.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery@2.7.1/plugins/zoom/lg-zoom.umd.min.js"></script>

    <script src="script.js" defer></script>
</head>
<body>
    <nav>
        <?php include 'header.php'; ?>
    </nav>

    <main>
        <h1 style="text-align:center;">Fotogalerie</h1>

        <!-- Sekce alb -->
        <div id="albums">
            <div class="album" onclick="openGallery('Zapas1')">Zápas 13. 4. 2025</div>
            <div class="album" onclick="openGallery('Zapas2')">Zápas 20. 4. 2025</div>
        </div>

        <!-- LightGallery kontejner -->
        <div id="lightgallery" class="gallery-container"></div>
    </main>

    <?php include 'footer.php'; ?>

    <style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        font-family: Arial, sans-serif;
    }
    main {
        flex: 1;
    }

    #albums {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin: 20px;
    }

    .album {
        background: #eee;
        padding: 20px;
        border-radius: 10px;
        cursor: pointer;
        box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
        transition: background 0.3s;
    }

    .album:hover {
        background: #ddd;
    }

    .
