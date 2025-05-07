<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warriors Chlumec – Historie klubu</title>
    <link rel="icon" type="image/x-icon" href="chlumeclogo.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Navigace -->
    <nav>
        <?php include 'header.php'; ?>
    </nav>

    <!-- Sekce Historie klubu -->
    <section class="container my-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="mb-4">Historie klubu</h2>
                <p>
                    <strong>HSÚ SHC Warriors Chlumec</strong> je hokejbalový klub založený v roce <strong>2006</strong>. Od svého vzniku působí na severu Čech jako významný regionální celek, který se účastní soutěží Českomoravského svazu hokejbalu (ČMSHb).
                </p>
                <p>
                    Klub vychoval řadu mladých talentů a je známý svou týmovou kulturou, bojovností a silnou komunitní základnou. Domácí zápasy se odehrávají na hřišti ve <em>Stradovské ulici</em>, které je centrem dění nejen pro fanoušky, ale i pro mládežnické kategorie.
                </p>
                <button id="toggleInfoBtn" class="btn btn-danger mt-3">Zobrazit více</button>
                <div id="extraInfo" class="mt-3" style="display: none;">
                    <ul>
                        <li><strong>Největší úspěch:</strong> Účast ve finále krajské ligy v roce 2019.</li>
                        <li><strong>Hráčská základna:</strong> muži, junioři a přípravka.</li>
                        <li><strong>Klubové barvy:</strong> černá, bílá a zlatá.</li>
                        <li><strong>Filozofie:</strong> "Srdcem na hřišti, rozumem v týmu."</li>
                    </ul>
                </div>
                <p class="mt-3">
                    Sledujte nás na <a href="https://www.facebook.com/p/HS%C3%9A-SHC-Warriors-Chlumec-100069910536674/?locale=cs_CZ" target="_blank">Facebooku</a> nebo <a href="https://www.instagram.com/warriorschlumec/" target="_blank">Instagramu</a> a buďte u toho!
                </p>
            </div>
            <div class="col-md-6">
                <img src="images/team_photo.jpg" class="img-fluid rounded shadow" alt="Týmová fotografie Warriors Chlumec">
            </div>
        </div>
    </section>

    <!-- Patka -->
    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS + vlastní skript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.getElementById("toggleInfoBtn");
            const extraInfo = document.getElementById("extraInfo");

            toggleBtn.addEventListener("click", function () {
                const isVisible = extraInfo.style.display === "block";
                extraInfo.style.display = isVisible ? "none" : "block";
                toggleBtn.textContent = isVisible ? "Zobrazit více" : "Skrýt informace";
            });
        });
    </script>
</body>
</html>
