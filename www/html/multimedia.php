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

    .gallery-container {
        margin: 30px auto;
        max-width: 1000px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .gallery-container a {
        display: inline-block;
    }

    .gallery-container img {
        width: 150px;
        margin: 5px;
    }
    </style>

<script>
function openGallery(albumName) {
    const gallery = document.getElementById('lightgallery');
    gallery.innerHTML = '';

    for (let i = 1; i <= 20; i++) {
        const imagePath = `galerie/${albumName}/${i}.png`;

        const a = document.createElement('a');
        a.href = imagePath;
        a.dataset.src = imagePath;
        a.dataset.subHtml = `<p>Obrázek ${i}</p>`;

        const img = document.createElement('img');
        img.src = imagePath;
        img.alt = `Fotka ${i}`;

        a.appendChild(img);
        gallery.appendChild(a);
    }

    lightGallery(gallery, {
        plugins: [lgZoom, lgThumbnail],
        speed: 500,
        download: false
    });
}
</script>
</body>
</html>
